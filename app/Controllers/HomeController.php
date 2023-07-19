<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;

class HomeController
{
    public function dashboard(): Response
    {
        if(!Session::has('user_id')){
            return new Redirect('/');
        }

        return new View('dashboard');
    }
}