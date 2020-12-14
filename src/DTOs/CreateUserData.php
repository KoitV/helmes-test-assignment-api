<?php


namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserData implements DtoInterface
{
    public function __construct(

        /**
         * @Assert\NotBlank(
         *     message="First name is required."
         * )
         */
        public string $firstName,

        /**
         * @Assert\NotBlank(
         *     message="Last name is required."
         * )
         */
        public string $lastName,

        /**
         * @Assert\NotNull
         */
        public bool $hasAgreedToTerms,

        /**
         * @Assert\Count(
         *     min = 1,
         *     minMessage = "You must select at least one sector."
         * )
         */
        public array $sectorIds
    )
    {}
}