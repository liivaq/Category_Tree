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
use Doctrine\DBAL\Exception;

class AuthorisationController
{
    private ValidationService $validationService;
    private LoginUserService $loginUserService;

    public function __construct(
        LoginUserService  $loginUserService,
        ValidationService $validationService
    )
    {
        $this->loginUserService = $loginUserService;
        $this->validationService = $validationService;
    }

    public function login(): Response
    {
        if (Session::has('user_id')) {
            return new Redirect ('/dashboard');
        }

        return new View('login');
    }

    public function authorize(): Redirect
    {
        try {

            $this->validationService->validateLogin($_POST);
            $this->loginUserService->execute(new LoginUserRequest($_POST));

        } catch (ValidationException | InvalidCredentialsException $validationException) {

            Session::flash('old', $_POST);
            return new Redirect('/login');

        } catch (Exception $e) {

            Session::flash('database_error', 'Sorry, there was a problem connecting with the database!');
            return new Redirect('/login');

        }

        return new Redirect('/dashboard');

    }

    public function logout(): Redirect
    {
        Session::destroy();
        return new Redirect('/login');
    }

}