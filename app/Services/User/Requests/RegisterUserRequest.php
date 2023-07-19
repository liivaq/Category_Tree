<?php declare(strict_types=1);

namespace App\Services\User\Requests;

class RegisterUserRequest
{
    private string $username;
    private string $email;
    private string $password;

    public function __construct(array $input)
    {
        $this->username = $input['username'];
        $this->email = $input['email'];
        $this->password = $input['password'];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}