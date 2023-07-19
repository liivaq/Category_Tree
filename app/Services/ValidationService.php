<?php declare(strict_types=1);

namespace App\Services;

use App\Core\Session;
use App\Core\Validator;
use App\Exceptions\ValidationException;
use App\Repositories\UserRepository;

class ValidationService
{
    private UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws ValidationException
     */
    public function validateRegistration(array $input)
    {
        Validator::required('Email', $input['email']);
        Validator::required('Password', $input['password']);
        Validator::required('Username', $input['username']);

        Validator::max('Username', $input['username'], 20);
        Validator::min('Username', $input['username'], 2);

        Validator::email($input['email']);
        Validator::password($input['password']);

        $errors = Validator::$errors;

        if(!empty($errors)){

            Session::flash('errors', $errors);
            Session::flash('old', $input);

            throw new ValidationException();
        }
    }

    /**
     * @throws ValidationException
     */
    public function validateLogin(array $input)
    {
        Validator::required('Email', $input['email']);
        Validator::required('Password', $input['password']);

        Validator::email($input['email']);

        $errors = Validator::$errors;

        if(!empty($errors)){

            Session::flash('errors', $errors);
            Session::flash('old', $input);

            throw new ValidationException();
        }
    }
}