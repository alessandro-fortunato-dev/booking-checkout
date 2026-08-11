<?php
session_start();

if (!isset($_SESSION['checkout'])) {
    $_SESSION['checkout'] = [
        'standort_id'      => 1,
        'checkin'          => '',
        'checkout'         => '',
        'ankunftszeit'     => '15:00',
        'erwachsene'       => 2,
        'kinder'           => 0,
        'vorname'          => '',
        'nachname'         => '',
        'email'            => '',
        'telefon'          => '',
        'land'             => '',
        'strasse_hausNr'   => '',
        'plz'              => '',
        'ort'              => '',
        'zusatzleistungen' => [],
        'gutschein_id'     => null,
        'gutschein_code'   => '',
        'gutschein_wert'   => 0.00,
        'gesamtpreis'      => 0.00
    ];
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/Router.php';

$router = new Router();
$router->handleRequest();