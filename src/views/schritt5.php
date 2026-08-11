<?php
$buchung = $buchung ?? null;
$hatRomantikUpgrade = $hatRomantikUpgrade ?? false;

$datumAnzeige = '';

if (!empty($buchung['checkin']) && !empty($buchung['checkout'])) {
    $checkinDate = new DateTime($buchung['checkin']);
    $checkoutDate = new DateTime($buchung['checkout']);

    if ($checkinDate->format('Y') === $checkoutDate->format('Y')) {
        $datumAnzeige = $checkinDate->format('d.m.') . ' - ' . $checkoutDate->format('d.m.Y');
    } else {
        $datumAnzeige = $checkinDate->format('d.m.Y') . ' - ' . $checkoutDate->format('d.m.Y');
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Checkout - Schritt 5</title>
    <link rel="stylesheet" href="/booking-checkout/src/views/style.css">
</head>
<body>
    <div class="haupt-container">

        <div class="navigation">
            <div class="logo">
                <img src="/booking-checkout/src/public/img/Logo.png" alt="Booking Logo">
            </div>
        </div>

        <form class="content-wrapper step-4" action="/booking-checkout/index.php?step=5" method="post">

            <div class="upgrade-karte-inhalt">

                <div class="upgrade-icon">
                    <img src="/booking-checkout/src/public/img/Vector.png"alt="Buchungsbestätigung">
                </div>

                <h2 class="erfolg-titel" style="color: #4a6f55; font-size: 20px; font-weight: 700; text-align: center;">
                    Vielen Dank für Deine Buchungsanfrage!
                </h2>

                <div class="buchungs-details-grid2">
                    <div class="detail-row" style="text-align: center;">
                        <span class="buchung-info-text">
                            Nach Zahlungseingang wird die Buchung bestätigt<br>
                            und eine Bestätigung an 
                            <strong><?php echo htmlspecialchars($buchung['email'] ?? ''); ?></strong> 
                            versendet.
                        </span>
                        
                    </div>
                </div>

                <div class="trennlinie-punktiert6"></div>

                <div class="standort-wrapper6" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 15px;">
                    <img src="/booking-checkout/src/public/img/Location.png" alt="Standort" style="width: 16px;">
                    <span class="standort-text"><?php echo htmlspecialchars($buchung['standort_bezeichnung'] ?? ''); ?></span>
                </div>

                <div class="buchungs-details-grid" style="margin-top: 20px;">
                    <div class="detail-row">
                        <span class="detail-label">Buchungsnummer:</span>
                        <span class="detail-wert"><?php echo (int)($buchung['buchung_id'] ?? 0); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-wert"><?php echo htmlspecialchars($buchung['status'] ?? ''); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Gast:</span>
                        <span class="detail-wert"><?php echo htmlspecialchars(($buchung['vorname'] ?? '') . ' ' . ($buchung['nachname'] ?? '')); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Datum:</span>
                        <span class="detail-wert"><?php echo htmlspecialchars($datumAnzeige); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Erwachsene:</span>
                        <span class="detail-wert"><?php echo (int)($buchung['erwachsene'] ?? 0); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kinder:</span>
                        <span class="detail-wert"><?php echo (int)($buchung['kinder'] ?? 0); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Ankunftszeit:</span>
                        <span class="detail-wert">ab 
                            <?php
                            if (!empty($buchung['ankunftszeit'])) {
                                echo htmlspecialchars(date('H:i', strtotime($buchung['ankunftszeit'])));
                            }
                            ?> Uhr
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Gesamtpreis:</span>
                        <span class="detail-wert">€ <?php echo number_format((float)($buchung['gesamtpreis'] ?? 0), 2, ',', '.'); ?></span>
                    </div>

                    <?php if ($hatRomantikUpgrade): ?>
                        <div class="detail-row">
                            <span class="detail-label">Zusatzleistung:</span>
                            <span class="detail-wert">Romantik-Upgrade</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="karten-container-upgrade">
                <section class="upgrade-karte-navigation">
                    <div class="button-area-step3">
                        <button
                            type="button"
                            class="btn-beleg-final"
                            style="all: unset; display: inline-flex; align-items: center; justify-content: center; height: 46px; width: 240px; border: 1px solid #4a6f55; border-radius: 40px; color: #4a6f55; font-size: 13px; font-weight: 700; cursor: pointer;"
                        >
                            Buchungsübersicht herunterladen
                        </button>
                    </div>
                </section>
            </div>

        </form>
    </div>
</body>
</html>