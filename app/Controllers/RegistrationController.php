<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\ValidationException;
use App\Services\User\LoginUserService;
use App\Services\User\RegisterUserService;
use App\Services\User\Requests\LoginUserRequest;
use App\Services\User\Requests\RegisterUserRequest;
use App\Services\ValidationService;
use Doctrine\DBAL\Exception;

class RegistrationController
{
    private RegisterUserService $registerUserService;
    private LoginUserService $loginUserService;
    private ValidationService $validationService;

    public function __construct(
        RegisterUserService $registerUserService,
        LoginUserService    $loginUserService,
        ValidationService   $validationService)
    {
        $this->registerUserService = $registerUserService;
        $this->loginUserService = $loginUserService;
        $this->validationService = $validationService;
    }

    public function register(): Response
    {
        if (Session::has('user_id')) {
            return new Redirect ('/dashboard');
        }

        return new View('register');
    }

    public function store(): Redirect
    {
        try {

            $this->validationService->validateRegistration($_POST);
            $this->registerUserService->execute(new RegisterUserRequest($_POST));
            $this->loginUserService->execute(new LoginUserRequest($_POST));

        } catch (ValidationException|InvalidCredentialsException $validationException) {

            return new Redirect('/');

        } catch (Exception $databaseException) {

            Session::flash('database_error', 'Sorry, there was a problem connecting with the database!');
            return new Redirect('/');
        }

        return new Redirect('/dashboard');
    }
}