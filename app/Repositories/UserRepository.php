<?php declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class UserRepository
{
    private ?Connection $connection;

    public function __construct()
    {
        $this->connection = Database::connect();
    }

    /**
     * @throws Exception
     */
    public function store(User $user)
    {
        $password = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $this->connection
            ->createQueryBuilder()
            ->insert('users')
            ->values([
                'email' => ':email',
                'password' => ':password',
            ])
            ->setParameter('email', $user->getEmail())
            ->setParameter('password', $password)
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $email): ?User
    {
        $user = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->fetchAssociative();


        if (!$user) {
            return null;
        }

        return $this->buildModel((object)$user);
    }

    private function buildModel(\stdClass $user): User
    {
        return new User(
            $user->email,
            $user->password,
            $user->id
        );
    }

}