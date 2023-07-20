<?php declare(strict_types=1);

return [
    ['GET', '/login' , ['App\Controllers\AuthorisationController', 'login']],
    ['POST', '/login' , ['App\Controllers\AuthorisationController', 'authorize']],

    ['POST', '/logout' , ['App\Controllers\AuthorisationController', 'logout']],

    ['GET', '/' , ['App\Controllers\RegistrationController', 'register']],
    ['GET', '/register' , ['App\Controllers\RegistrationController', 'register']],
    ['POST', '/register' , ['App\Controllers\RegistrationController', 'store']],

    ['GET', '/dashboard' , ['App\Controllers\SectionController', 'index']],

    ['POST', '/section/add' , ['App\Controllers\SectionController', 'store']],
    ['POST', '/section/edit' , ['App\Controllers\SectionController', 'update']],
    ['POST', '/section/delete/{id}' , ['App\Controllers\SectionController', 'delete']],
];