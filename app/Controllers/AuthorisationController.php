<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\ValidationException;
use App\Services\User\LoginUserService;
use App\Services\User\Requests\LoginUserRequest;
use App\Services\ValidationService;

class AuthorisationController
{ private ValidationService $validationService;
    private LoginUserService $loginUserService;

    public function __construct()
    {
        $this->loginUserService = new LoginUserService();
        $this->validationService = new ValidationService();
    }
    public function login(): Response
    {
        if (Session::has('user_id')){
            return new Redirect ('/dashboard');
        }

        return new View('login');
    }

    public function authorize()
    {
        try {

            $this->validationService->validateLogin($_POST);
            $this->loginUserService->execute(new LoginUserRequest($_POST));

        } catch (ValidationException | InvalidCredentialsException $validationException) {
            return new Redirect('/login');
        }

        return new Redirect('/dashboard');

    }

    public function logout(){
        Session::destroy();
        return new Redirect('/');
    }

}