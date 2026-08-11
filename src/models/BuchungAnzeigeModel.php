<?php

class BuchungAnzeigeModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getBuchungMitKundeUndStandort(int $buchungId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                b.buchung_id,
                b.checkin,
                b.checkout,
                b.ankunftszeit,
                b.erwachsene,
                b.kinder,
                b.gesamtpreis,
                b.status,
                k.vorname,
                k.nachname,
                k.email,
                s.bezeichnung AS standort_bezeichnung
            FROM buchung b
            INNER JOIN kunde k ON b.kunde_id = k.kunde_id
            INNER JOIN standort s ON b.standort_id = s.standort_id
            WHERE b.buchung_id = :buchung_id
            LIMIT 1
        ");

        $stmt->execute([
            'buchung_id' => $buchungId
        ]);

        return $stmt->fetch();
    }

    public function hatRomantikUpgrade(int $buchungId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT 1
            FROM buch_zus
            WHERE buchung_id = :buchung_id
              AND zusatz_id = 1
            LIMIT 1
        ");

        $stmt->execute([
            'buchung_id' => $buchungId
        ]);

        return (bool) $stmt->fetchColumn();
    }
}