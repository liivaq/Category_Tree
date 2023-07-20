<?php declare(strict_types=1);

namespace App\Core;

use DI\ContainerBuilder;

class Container
{
    public static function build(): \DI\Container
    {
        $containerBuilder = new ContainerBuilder();
        return $containerBuilder->build();
    }
}

