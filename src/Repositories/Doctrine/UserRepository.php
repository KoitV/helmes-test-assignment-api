<?php


namespace App\Repositories\Doctrine;


use App\DTOs\CreateUserData;
use App\DTOs\UpdateUserData;
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

    public function update(User $user, UpdateUserData $updateUserData): User
    {
        if($updateUserData->firstName !== null)
            $user->setFirstName($updateUserData->firstName);

        if($updateUserData->lastName !== null)
            $user->setLastName($updateUserData->lastName);

        if($updateUserData->hasAgreedToTerms !== null)
        {
            if($updateUserData->hasAgreedToTerms)
                $user->agreeToTerms();
            else
                $user->disagreeToTerms();
        }

        $this->entityManager->persist($user);

        return $user;
    }
}