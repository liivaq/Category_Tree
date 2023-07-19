<?php declare(strict_types=1);

use App\Core\Router;

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();

(new Router)->route()->resolve();