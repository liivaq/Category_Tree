<?php declare(strict_types=1);

namespace App\Services\User\Requests;

class RegisterUserRequest
{
    private string $email;
    private string $password;

    public function __construct(array $input)
    {
        $this->email = $input['email'];
        $this->password = $input['password'];
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