<?php declare(strict_types=1);

namespace App\Services;

use App\Core\Session;
use App\Core\Validator;
use App\Exceptions\ValidationException;

class ValidationService
{
    /**
     * @throws ValidationException
     */
    public function validateRegistration(array $input)
    {
        Validator::required('Email', $input['email']);
        Validator::required('Password', $input['password']);

        Validator::email($input['email']);
        Validator::exists($input['email']);
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