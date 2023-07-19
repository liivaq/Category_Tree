<?php declare(strict_types=1);


return [
    ['GET', '/login' , ['App\Controllers\AuthorisationController', 'login']],
    ['POST', '/login' , ['App\Controllers\AuthorisationController', 'authorize']],

    ['POST', '/logout' , ['App\Controllers\AuthorisationController', 'logout']],

    ['GET', '/' , ['App\Controllers\RegistrationController', 'register']],
    ['GET', '/register' , ['App\Controllers\RegistrationController', 'register']],
    ['POST', '/register' , ['App\Controllers\RegistrationController', 'store']],

    ['GET', '/dashboard' , ['App\Controllers\HomeController', 'dashboard']],
];