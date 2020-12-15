<?php


namespace App\Repositories\Doctrine;


use App\DTOs\CreateUserData;
use App\DTOs\GetUserData;
use App\DTOs\UpdateUserData;
use App\Entities\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;

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

    public function get(GetUserData $getUserData): User
    {
        $query = $this->entityManager->createQuery('SELECT user, sector FROM App\Entities\User JOIN user.sectors sector WHERE user.id = :id');

        $query->setParameters(new ArrayCollection([
            new Parameter('id', $getUserData->id, 'uuid_binary_ordered_time')
        ]));

        return $this->entityManager->getRepository(User::class)->find($getUserData->id);
    }
}