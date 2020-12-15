<?php


namespace App\DTOs;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserData implements DtoInterface
{
    public function __construct(
        /**
         * @Assert\Uuid
         */
        public UuidInterface $id,

        /**
         * @Assert\NotBlank(allowNull=true)
         */
        public ?string $firstName,

        /**
         * @Assert\NotBlank(allowNull=true)
         */
        public ?string $lastName,

        /**
         * @Assert\NotBlank(allowNull=true)
         */
        public ?bool $hasAgreedToTerms,

        /**
         * @Assert\Count(
         *     min = 1,
         *     minMessage = "You must select at least one sector."
         * )
         */
        public ?array $sectorIds,

        /**
         * @Assert\Uuid
         */
        public ?UuidInterface $authenticatedUserId = null
    )
    {}
}