<?php declare(strict_types=1);

namespace App\Core\Response;

class Redirect implements Response
{
    private string $location;

    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public function redirect()
    {
        header('Location: '.$this->location);
        exit();
    }

}