<?php declare(strict_types=1);

namespace App\Services\User;

use App\Core\Session;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\Requests\LoginUserRequest;
use Doctrine\DBAL\Exception;

class LoginUserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws InvalidCredentialsException
     * @throws Exception
     */
    public function execute(LoginUserRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->getEmail());
        $this->login($user, $request);
    }

    /**
     * @throws InvalidCredentialsException
     */
    private function login(?User $user, LoginUserRequest $request)
    {
        if (!$user || !password_verify($request->getPassword(), $user->getPassword())) {
            Session::flash('errors', ['email' => ['Invalid Credentials']]);
            throw new InvalidCredentialsException();
        }

        Session::put('user_id', (string)$user->getId());
    }

}