<?php


namespace App\DTOs;

use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\UuidInterface;

class GetUserData implements DtoInterface
{

    public function __construct(
        /**
         * @Assert\Uuid
         */
        public UuidInterface $id
    )
    {}

}