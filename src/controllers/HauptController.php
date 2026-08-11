<?php

require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../models/StandortModel.php';
require_once __DIR__ . '/../models/GutscheinModel.php';
require_once __DIR__ . '/../models/KundeModel.php';
require_once __DIR__ . '/../models/BuchungModel.php';
require_once __DIR__ . '/../models/BuchungZusatzModel.php';
require_once __DIR__ . '/../models/BuchungAnzeigeModel.php';
require_once __DIR__ . '/../models/ZusatzleistungModel.php';

class HauptController
{
    /* =========================
       ======= SHOW ============
       ========================= */

    public function showStep1()
    {
        $pdo = (new Database())->getConnection();
        $standortModel = new StandortModel($pdo);

        $standortId = filter_input(INPUT_GET, 'standort_id', FILTER_VALIDATE_INT) ?: 1;
        $standort = $standortModel->getStandortById($standortId);

        if (!$standort) {
            $standortId = 1;
            $standort = $standortModel->getStandortById(1);
        }

        $_SESSION['checkout']['standort_id'] = $standortId;
        $standortName = $standort['bezeichnung'] ?? '';

        require_once __DIR__ . '/../views/schritt1.php';
    }

    public function showStep2()
    {
        if (!$this->hatSchritt1Daten()) {
            header('Location: /booking-checkout/index.php?step=1');
            exit;
        }

        $standortName = $this->getStandortName();

        require_once __DIR__ . '/../views/schritt2.php';
    }

    public function showStep3()
    {
        if (!$this->hatSchritt1Daten() || !$this->hatSchritt2Daten()) {
            header('Location: /booking-checkout/index.php?step=1');
            exit;
        }

        $pdo = (new Database())->getConnection();
        $zusatzleistungModel = new ZusatzleistungModel($pdo);

        $standortName = $this->getStandortName();

        $zusatzleistung = $zusatzleistungModel->getZusatzleistungById(1);

        $zusatzId = (int)($zusatzleistung['zusatz_id'] ?? 0);
        $zusatzBezeichnung = $zusatzleistung['bezeichnung'] ?? '';
        $zusatzBeschreibung = $zusatzleistung['beschreibung'] ?? '';
        $zusatzPreis = (float)($zusatzleistung['preis'] ?? 0.00);

        $gewaehlteZusatzleistungen = $_SESSION['checkout']['zusatzleistungen'] ?? [];

        require_once __DIR__ . '/../views/schritt3.php';
    }

    public function showStep4()
    {
        if (!$this->hatSchritt1Daten() || !$this->hatSchritt2Daten()) {
            header('Location: /booking-checkout/index.php?step=1');
            exit;
        }

        // Preise berechnen
        $this->berechneGesamtpreis();

        $pdo = (new Database())->getConnection();
        $standortModel = new StandortModel($pdo);
        $zusatzleistungModel = new ZusatzleistungModel($pdo);

        $standortId = $_SESSION['checkout']['standort_id'] ?? 1;
        $standort = $standortModel->getStandortById($standortId);

        if (!$standort) {
            $standortId = 1;
            $standort = $standortModel->getStandortById($standortId);
            $_SESSION['checkout']['standort_id'] = $standortId;
        }

        $standortName = $standort['bezeichnung'] ?? '';
        $preisProNacht = (float)($standort['preis_pro_nacht'] ?? 0.00);

        $checkin = $_SESSION['checkout']['checkin'] ?? '';
        $checkout = $_SESSION['checkout']['checkout'] ?? '';
        $erwachsene = $_SESSION['checkout']['erwachsene'] ?? 0;
        $kinder = $_SESSION['checkout']['kinder'] ?? 0;
        $ankunftszeit = $_SESSION['checkout']['ankunftszeit'] ?? '15:00';

        $zusatzleistungen = $_SESSION['checkout']['zusatzleistungen'] ?? [];
        $gutscheinCode = $_SESSION['checkout']['gutschein_code'] ?? '';
        $gutscheinWert = (float)($_SESSION['checkout']['gutschein_wert'] ?? 0.00);

        $checkinDate = new DateTime($checkin);
        $checkoutDate = new DateTime($checkout);

        if ($checkinDate->format('Y') === $checkoutDate->format('Y')) {
            $datumAnzeige = $checkinDate->format('d.m.') . ' - ' . $checkoutDate->format('d.m.Y');
        } else {
            $datumAnzeige = $checkinDate->format('d.m.Y') . ' - ' . $checkoutDate->format('d.m.Y');
        }

        $naechte = (int)$checkinDate->diff($checkoutDate)->days;
        $basispreis = $naechte * $preisProNacht;
        $gesamtpreis = $_SESSION['checkout']['gesamtpreis'] ?? 0.00;

        $zusatzpreis = 0.00;
        $zusatzBezeichnung = '';
        $preisZusatzProNacht = 0.00;

        if (in_array(1, $zusatzleistungen, true)) {
            $zusatzleistung = $zusatzleistungModel->getZusatzleistungById(1);
            $preisZusatzProNacht = (float)($zusatzleistung['preis'] ?? 0.00);
            $zusatzpreis = $naechte * $preisZusatzProNacht;
            $zusatzBezeichnung = $zusatzleistung['bezeichnung'] ?? 'Zusatzleistung';
        }

        require_once __DIR__ . '/../views/schritt4.php';
    }

    public function showStep5()
    {
        $pdo = (new Database())->getConnection();
        $buchungAnzeigeModel = new BuchungAnzeigeModel($pdo);

        $buchungId = $_SESSION['buchung_id'] ?? null;

        if (!$buchungId) {
            header('Location: /booking-checkout/index.php?step=1');
            exit;
        }

        $buchung = $buchungAnzeigeModel->getBuchungMitKundeUndStandort((int)$buchungId);
        $hatRomantikUpgrade = $buchungAnzeigeModel->hatRomantikUpgrade((int)$buchungId);

        require_once __DIR__ . '/../views/schritt5.php';
    }

    /* =========================
       ======= PROCESS =========
       ========================= */

    public function processStep1()
    {
        $checkin = $_POST['checkin'] ?? '';
        $checkout = $_POST['checkout'] ?? '';
        $erwachsene = (int)($_POST['erwachsene'] ?? 0);
        $kinder = (int)($_POST['kinder'] ?? 0);

        $errors = [];
        $morgen = date('Y-m-d', strtotime('+1 day'));

        if ($checkin < $morgen) {
            $errors['checkin'] = 'Check-in ist frühestens ab morgen möglich.';
        }

        if ($checkout <= $checkin) {
            $errors['checkout'] = 'Check-out muss nach Check-in liegen.';
        }

        $naechte = (new DateTime($checkin))->diff(new DateTime($checkout))->days;
        if ($naechte > 14) {
            $errors['checkout'] = 'Maximal 14 Nächte erlaubt.';
        }

        if ($erwachsene < 2 || $erwachsene > 10) {
            $errors['erwachsene'] = '2–10 Erwachsene erlaubt.';
        }

        if ($kinder < 0 || $kinder > 10) {
            $errors['kinder'] = '0–10 Kinder erlaubt.';
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /Checkout/index.php?step=1');
            exit;
        }

        $_SESSION['checkout']['checkin'] = $checkin;
        $_SESSION['checkout']['checkout'] = $checkout;
        $_SESSION['checkout']['erwachsene'] = $erwachsene;
        $_SESSION['checkout']['kinder'] = $kinder;

        header('Location: /booking-checkout/index.php?step=2');
        exit;
    }

    public function processStep2()
    {
        $vorname = trim($_POST['vorname'] ?? '');
        $nachname = trim($_POST['nachname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefon = trim($_POST['telefon'] ?? '');
        $land = trim($_POST['land'] ?? '');
        $strasseHausNr = trim($_POST['strasse_hausNr'] ?? '');
        $plz = trim($_POST['plz'] ?? '');
        $ort = trim($_POST['ort'] ?? '');

        $errors = [];

        if ($vorname === '') {
            $errors['vorname'] = 'Bitte Vorname angeben.';
        } elseif (!preg_match('/^[a-zA-ZäöüÄÖÜß\s-]+$/u', $vorname)) {
            $errors['vorname'] = 'Vorname darf nur Buchstaben enthalten.';
        }

        if ($nachname === '') {
            $errors['nachname'] = 'Bitte Nachname angeben.';
        } elseif (!preg_match('/^[a-zA-ZäöüÄÖÜß\s-]+$/u', $nachname)) {
            $errors['nachname'] = 'Nachname darf nur Buchstaben enthalten.';
        }

        if ($email === '') {
            $errors['email'] = 'Bitte E-Mail-Adresse angeben.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Bitte eine gültige E-Mail-Adresse angeben.';
        }

        if ($telefon === '') {
            $errors['telefon'] = 'Bitte Telefonnummer angeben.';
        } elseif (!preg_match('/^[0-9+\-\s\/()]+$/', $telefon)) {
            $errors['telefon'] = 'Bitte eine gültige Telefonnummer angeben.';
        } else {
            $telefonNurZahlen = preg_replace('/\D/', '', $telefon);
            if (strlen($telefonNurZahlen) < 7) {
                $errors['telefon'] = 'Telefonnummer ist zu kurz.';
            }
        }

        if ($land === '') {
            $errors['land'] = 'Bitte Land angeben.';
        } elseif (!preg_match('/^[a-zA-ZäöüÄÖÜß\s-]+$/u', $land)) {
            $errors['land'] = 'Land darf nur Buchstaben enthalten.';
        }

        if ($strasseHausNr === '') {
            $errors['strasse_hausNr'] = 'Bitte Straße und Hausnummer angeben.';
        } elseif (!preg_match('/^[a-zA-Z0-9äöüÄÖÜß\s.\-]+$/u', $strasseHausNr)) {
            $errors['strasse_hausNr'] = 'Ungültige Straße.';
        } elseif (!preg_match('/[a-zA-ZäöüÄÖÜß]/u', $strasseHausNr) || !preg_match('/[0-9]/', $strasseHausNr)) {
            $errors['strasse_hausNr'] = 'Bitte Straße und Hausnummer angeben.';
        }

        if ($plz === '') {
            $errors['plz'] = 'Bitte Postleitzahl angeben.';
        } elseif (!preg_match('/^[0-9]{5}$/', $plz)) {
            $errors['plz'] = 'PLZ muss mindestens 5-stellig sein.';
        }

        if ($ort === '') {
            $errors['ort'] = 'Bitte Ort angeben.';
        } elseif (!preg_match('/^[a-zA-ZäöüÄÖÜß\s-]+$/u', $ort)) {
            $errors['ort'] = 'Ort darf nur Buchstaben enthalten.';
        }

        $_SESSION['checkout']['vorname'] = $vorname;
        $_SESSION['checkout']['nachname'] = $nachname;
        $_SESSION['checkout']['email'] = $email;
        $_SESSION['checkout']['telefon'] = $telefon;
        $_SESSION['checkout']['land'] = $land;
        $_SESSION['checkout']['strasse_hausNr'] = $strasseHausNr;
        $_SESSION['checkout']['plz'] = $plz;
        $_SESSION['checkout']['ort'] = $ort;

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /booking-checkout/index.php?step=2');
            exit;
        }

        header('Location: /booking-checkout/index.php?step=3');
        exit;
    }

    public function processStep3()
    {
        $zusatzId = (int)($_POST['zusatz_id'] ?? 0);
        $_SESSION['checkout']['zusatzleistungen'] = $zusatzId > 0 ? [$zusatzId] : [];

        header('Location: /booking-checkout/index.php?step=4');
        exit;
    }

    public function processStep4()
    {
        if (!$this->hatSchritt1Daten() || !$this->hatSchritt2Daten()) {
            header('Location: /booking-checkout/index.php?step=1');
            exit;
        }

        $pdo = (new Database())->getConnection();

        if (isset($_POST['gutschein_pruefen'])) {
            $code = trim($_POST['gutschein_code'] ?? '');
            $gutschein = (new GutscheinModel($pdo))->getGueltigenGutscheinByCode($code);

            if (!$gutschein) {
                $_SESSION['gutschein_error'] = 'Ungültig oder eingelöst.';
            } else {
                $_SESSION['checkout']['gutschein_id'] = $gutschein['gutschein_id'];
                $_SESSION['checkout']['gutschein_wert'] = $gutschein['wert'];
                $_SESSION['checkout']['gutschein_code'] = $gutschein['code'];
                $_SESSION['gutschein_success'] = 'Gutschein angewendet.';
            }
            header('Location: /booking-checkout/index.php?step=4');
            exit;
        }

        if (isset($_POST['buchung_bestaetigen'])) {
            if (!isset($_POST['agb'])) {
                $_SESSION['gutschein_error'] = 'Bitte AGB bestätigen.';
                header('Location: /booking-checkout/index.php?step=4');
                exit;
            }

            try {
                $pdo->beginTransaction();
                $this->berechneGesamtpreis();

                $kundeId = (new KundeModel($pdo))->insertKunde($_SESSION['checkout']);
                $buchungId = (new BuchungModel($pdo))->insertBuchung([
                    ...$_SESSION['checkout'],
                    'kunde_id' => $kundeId,
                    'status' => 'pending'
                ]);

                if (!empty($_SESSION['checkout']['zusatzleistungen'])) {
                    $mModel = new BuchungZusatzModel($pdo);
                    foreach ($_SESSION['checkout']['zusatzleistungen'] as $zid) {
                        $mModel->insertBuchungZusatz($buchungId, (int)$zid);
                    }
                }

                if (!empty($_SESSION['checkout']['gutschein_id'])) {
                    $pdo->prepare("UPDATE gutschein SET eingeloest_am = NOW() WHERE gutschein_id = ?")
                        ->execute([$_SESSION['checkout']['gutschein_id']]);
                }

                $pdo->commit();
                $_SESSION['buchung_id'] = $buchungId;
                unset($_SESSION['checkout']);
                header('Location: /booking-checkout/index.php?step=5');
                exit;
            } catch (Exception $e) {
                $pdo->rollBack();
                die('Fehler: ' . $e->getMessage());
            }
        }
    }

    /* =========================
       ======= HELPER ==========
       ========================= */

    private function berechneGesamtpreis(): void
    {
        $pdo = (new Database())->getConnection();
        $standort = (new StandortModel($pdo))->getStandortById($_SESSION['checkout']['standort_id'] ?? 1);
        $zusatzleistungModel = new ZusatzleistungModel($pdo);

        $preisProNacht = (float)($standort['preis_pro_nacht'] ?? 0.00);
        $checkinDate = new DateTime($_SESSION['checkout']['checkin']);
        $checkoutDate = new DateTime($_SESSION['checkout']['checkout']);
        $naechte = (int)$checkinDate->diff($checkoutDate)->days;

        $basispreis = $naechte * $preisProNacht;
        $zusatzpreis = 0.00;

        if (in_array(1, $_SESSION['checkout']['zusatzleistungen'] ?? [], true)) {
            $zusatz = $zusatzleistungModel->getZusatzleistungById(1);
            $zusatzpreis = $naechte * (float)($zusatz['preis'] ?? 0.00);
        }

        $gutscheinWert = (float)($_SESSION['checkout']['gutschein_wert'] ?? 0.00);
        $gesamtpreis = $basispreis + $zusatzpreis - $gutscheinWert;

        if ($gesamtpreis < 0) {
            $gesamtpreis = 0.00;
        }

        $_SESSION['checkout']['gesamtpreis'] = $gesamtpreis;
    }

    private function getStandortName(): string
    {
        $pdo = (new Database())->getConnection();
        $standort = (new StandortModel($pdo))->getStandortById($_SESSION['checkout']['standort_id']);
        return $standort['bezeichnung'] ?? '';
    }

    private function hatSchritt1Daten(): bool
    {
        return !empty($_SESSION['checkout']['checkin']) &&
               !empty($_SESSION['checkout']['checkout']) &&
               isset($_SESSION['checkout']['erwachsene']) &&
               $_SESSION['checkout']['erwachsene'] >= 2;
    }

    private function hatSchritt2Daten(): bool
    {
        return !empty($_SESSION['checkout']['vorname']) &&
               !empty($_SESSION['checkout']['nachname']) &&
               !empty($_SESSION['checkout']['email']) &&
               !empty($_SESSION['checkout']['telefon']) &&
               !empty($_SESSION['checkout']['land']) &&
               !empty($_SESSION['checkout']['strasse_hausNr']) &&
               !empty($_SESSION['checkout']['plz']) &&
               !empty($_SESSION['checkout']['ort']);
    }
}