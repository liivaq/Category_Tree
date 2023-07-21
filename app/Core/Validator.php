<?php declare(strict_types=1);

namespace App\Core;

use App\Repositories\UserRepository;

class Validator
{
    public static array $errors = [];


    public static function email(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$errors['email'][] = "Invalid email format";
        }
    }

    public static function password(string $password)
    {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
            self::$errors['password'][] =
                'Password must contain at least one uppercase and one lowercase letter and one number';
        }
    }

    public static function required(string $label, string $input)
    {
        if(trim($input) === ''){
            self::$errors[strtolower($label)][] = $label.' is required' ;
        }
    }

    public static function max(string $label, string $input, int $maxLength)
    {
        if(strlen(trim($input)) > $maxLength){
            self::$errors[strtolower($label)][] = $label.' can not be more than '.$maxLength.' characters' ;
        }
    }

    public static function min(string $label, string $input, int $minLength)
    {
        if(strlen(trim($input)) < $minLength){
            self::$errors[strtolower($label)][] = $label.' has to be at least '.$minLength.' characters' ;
        }
    }

    public static function exists(string $email)
    {
        $userRepository = new UserRepository();
        if($userRepository->findByEmail($email)){
            self::$errors['email'][] = 'Email is already taken';
        }
    }

}