<?php declare(strict_types=1);

namespace App\Services\User\Requests;

class LoginUserRequest
{
    private string $password;
    private string $email;

    public function __construct(array $input)
    {
        $this->password = $input['password'];
        $this->email = $input['email'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

}