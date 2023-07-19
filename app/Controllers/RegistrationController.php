<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;
use App\Exceptions\ValidationException;
use App\Services\User\RegisterUserService;
use App\Services\User\Requests\RegisterUserRequest;
use App\Services\ValidationService;

class RegistrationController
{
    private ValidationService $validationService;
    private RegisterUserService $registerUserService;

    public function __construct()
    {
        $this->registerUserService = new RegisterUserService();
        $this->validationService = new ValidationService();
    }

    public function index(): Response
    {
        if (Session::has('user_id')){
            return new Redirect ('/dashboard');
        }

        return new View('register');
    }


    public function register(): Response
    {
        if (Session::has('user_id')){
            return new Redirect ('/dashboard');
        }

        return new View('register');
    }

    public function store(): Redirect
    {
        try {
            $this->validationService->validateRegistration($_POST);
            $this->registerUserService->execute(new RegisterUserRequest($_POST));
        } catch (ValidationException $validationException) {
            return new Redirect('/');
        }

        return new Redirect('/dashboard');
    }
}