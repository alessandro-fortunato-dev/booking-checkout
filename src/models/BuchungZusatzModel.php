<?php

class BuchungZusatzModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertBuchungZusatz(int $buchungId, int $zusatzId): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO buch_zus (
                buchung_id,
                zusatz_id
            ) VALUES (
                :buchung_id,
                :zusatz_id
            )
        ");

        $stmt->execute([
            'buchung_id' => $buchungId,
            'zusatz_id' => $zusatzId
        ]);
    }
}