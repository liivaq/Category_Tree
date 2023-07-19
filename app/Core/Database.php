<?php declare(strict_types=1);

namespace App\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Database
{
    public static function connect(): ?Connection
    {
        try {
            $connectionParams = [
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                'host' => $_ENV['DB_HOST'],
                'driver' => 'pdo_mysql',
            ];
            return DriverManager::getConnection($connectionParams);
        } catch (Exception $exception) {
            return null;
        }
    }
}