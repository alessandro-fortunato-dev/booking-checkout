<?php

class KundeModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertKunde(array $daten): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO kunde (
                anrede,
                vorname,
                nachname,
                email,
                telefon,
                strasse_hausNr,
                plz,
                ort,
                land
            ) VALUES (
                :anrede,
                :vorname,
                :nachname,
                :email,
                :telefon,
                :strasse_hausNr,
                :plz,
                :ort,
                :land
            )
        ");

        $stmt->execute([
            'anrede' => $daten['anrede'] ?? '',
            'vorname' => $daten['vorname'],
            'nachname' => $daten['nachname'],
            'email' => $daten['email'],
            'telefon' => $daten['telefon'],
            'strasse_hausNr' => $daten['strasse_hausNr'],
            'plz' => $daten['plz'],
            'ort' => $daten['ort'],
            'land' => $daten['land']
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}