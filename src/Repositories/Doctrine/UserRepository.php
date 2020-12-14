<?php


namespace App\Repositories\Doctrine;


use App\DTOs\CreateUserData;
use App\Entities\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryContract
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {}

    public function create(CreateUserData $createUserData): User
    {
        $user = new User();
        $user->setFirstName($createUserData->firstName);
        $user->setLastName($createUserData->lastName);

        if($createUserData->hasAgreedToTerms)
            $user->agreeToTerms();

        $this->entityManager->persist($user);

        return $user;
    }
}