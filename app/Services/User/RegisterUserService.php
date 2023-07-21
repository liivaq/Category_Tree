<?php declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\Requests\RegisterUserRequest;
use Doctrine\DBAL\Exception;

class RegisterUserService
{
    private UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        $user = new User(
            $request->getEmail(),
            $request->getPassword(),
        );

        $this->userRepository->store($user);
    }


}