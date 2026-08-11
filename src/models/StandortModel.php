<?php

class StandortModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStandortById($standort_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM standort
            WHERE standort_id = :id
        ");

        $stmt->execute(['id' => $standort_id]);

        return $stmt->fetch();
    }
}