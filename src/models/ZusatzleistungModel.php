<?php

class ZusatzleistungModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getZusatzleistungById(int $zusatzId)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM zusatzleistung
            WHERE zusatz_id = :zusatz_id
            LIMIT 1
        ");

        $stmt->execute([
            'zusatz_id' => $zusatzId
        ]);

        return $stmt->fetch();
    }
}