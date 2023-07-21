<?php declare(strict_types=1);

namespace App\Models;

class User
{
    private string $email;
    private string $password;
    private ?int $id;

    public function __construct(
        string $email,
        string $password,
        ?int $id = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}