<?php

require_once __DIR__ . '/src/controllers/HauptController.php';

class Router
{
    public function handleRequest()
    {
        $controller = new HauptController();

        // Welcher Schritt? (Standard = 1)
        $step = $_GET['step'] ?? '1';

        // GET oder POST?
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            switch ($step) {
                case '1':
                    $controller->processStep1();
                    break;

                case '2':
                    $controller->processStep2();
                    break;

                case '3':
                    $controller->processStep3();
                    break;

                case '4':
                    $controller->processStep4();
                    break;

                case '5':
                    $controller->processStep5();
                    break;

                default:
                    $controller->showStep1();
                    break;
            }

        } else {

            switch ($step) {
                case '1':
                    $controller->showStep1();
                    break;

                case '2':
                    $controller->showStep2();
                    break;

                case '3':
                    $controller->showStep3();
                    break;

                case '4':
                    $controller->showStep4();
                    break;

                case '5':
                    $controller->showStep5();
                    break;

                default:
                    $controller->showStep1();
                    break;
            }
        }
    }
}