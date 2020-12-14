<?php


namespace App\Services;


use App\DTOs\CreateUserData;
use App\Entities\Sector;
use App\Entities\User;
use App\Exceptions\UserHasNotAgreedToTermsException;
use App\Repositories\Contracts\SectorRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
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
        $this->validate($createUserData);

        if(!$createUserData->hasAgreedToTerms)
            throw new UserHasNotAgreedToTermsException();

        $user = $this->userRepository->create($createUserData);

        foreach($createUserData->sectorIds as $sectorId)
        {
            $sector = $this->entityManager->getRepository(Sector::class)->find($sectorId);
            $user->addSector($sector);
        }


        $this->entityManager->flush();
        return $user;
    }

    private function validate(CreateUserData $createUserData)
    {
        $violations = $this->validator->validate($createUserData);

        // TODO Return all errors for all fields
        // https://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api#errors
        if($violations->count() > 0)
        {
            $firstViolation = $violations->get(0);
            throw new InvalidArgumentException($firstViolation->getMessage());
        }
    }
}