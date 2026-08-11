<?php

class GutscheinModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getGueltigenGutscheinByCode($code)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM gutschein
            WHERE code = :code
              AND eingeloest_am IS NULL
              AND gueltig_bis >= CURDATE()
            LIMIT 1
        ");

        $stmt->execute([
            'code' => $code
        ]);

        return $stmt->fetch();
    }
}