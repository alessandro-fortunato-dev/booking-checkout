<?php

class BuchungModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertBuchung(array $daten): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO buchung (
                kunde_id,
                standort_id,
                gutschein_id,
                erwachsene,
                kinder,
                checkin,
                ankunftszeit,
                checkout,
                gesamtpreis,
                erstellt_am,
                status
            ) VALUES (
                :kunde_id,
                :standort_id,
                :gutschein_id,
                :erwachsene,
                :kinder,
                :checkin,
                :ankunftszeit,
                :checkout,
                :gesamtpreis,
                NOW(),
                :status
            )
        ");

        $stmt->execute([
            'kunde_id' => $daten['kunde_id'],
            'standort_id' => $daten['standort_id'],
            'gutschein_id' => $daten['gutschein_id'],
            'erwachsene' => $daten['erwachsene'],
            'kinder' => $daten['kinder'],
            'checkin' => $daten['checkin'],
            'ankunftszeit' => $daten['ankunftszeit'],
            'checkout' => $daten['checkout'],
            'gesamtpreis' => $daten['gesamtpreis'],
            'status' => $daten['status']
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}