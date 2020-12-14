<?php


namespace App\Services;


use App\DTOs\CreateUserData;
use App\Entities\User;
use App\Exceptions\UserHasNotAgreedToTermsException;
use App\Repositories\Contracts\SectorRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepositoryContract $userRepository,
        private SectorRepositoryContract $sectorRepository,
        private ValidatorInterface $validator
    )
    {}

    /**
     * @param CreateUserData $createUserData
     * @return User
     * @throws UserHasNotAgreedToTermsException
     */
    public function execute(CreateUserData $createUserData): User
    {
        if(!$createUserData->hasAgreedToTerms)
            throw new UserHasNotAgreedToTermsException();

        $user = $this->userRepository->create($createUserData);

        $sectors = $this->sectorRepository->findAllByIds($createUserData->sectorIds);
        $user->setSectors($sectors);

        $this->entityManager->flush();
        return $user;
    }
}