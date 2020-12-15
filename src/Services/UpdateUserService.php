<?php


namespace App\Services;


use App\DTOs\UpdateUserData;
use App\Entities\User;
use App\Exceptions\UserHasNotAgreedToTermsException;
use App\Repositories\Contracts\SectorRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UpdateUserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepositoryContract $userRepository,
        private SectorRepositoryContract $sectorRepository
    )
    {}

    public function execute(UpdateUserData $updateUserData)
    {
        if($updateUserData->authenticatedUserId === null || $updateUserData->authenticatedUserId->toString() !== $updateUserData->id->toString())
            throw new AccessDeniedHttpException('You don\'t have permission to edit this user.');

        if($updateUserData->hasAgreedToTerms !== null && !$updateUserData->hasAgreedToTerms)
            throw new UserHasNotAgreedToTermsException();

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->find($updateUserData->id);
        $user = $this->userRepository->update($user, $updateUserData);

        if($updateUserData->sectorIds !== null)
        {
            $sectors = $this->sectorRepository->findAllByIds($updateUserData->sectorIds);
            $user->setSectors($sectors);
        }

        $this->entityManager->flush();
        return $user;
    }
}