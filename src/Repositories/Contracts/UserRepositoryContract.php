<?php


namespace App\Repositories\Contracts;


use App\DTOs\CreateUserData;
use App\Entities\User;

interface UserRepositoryContract
{
    public function create(CreateUserData $createUserData): User;
}