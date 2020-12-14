<?php


namespace App\Repositories\Contracts;


use App\DTOs\CreateUserData;
use App\DTOs\UpdateUserData;
use App\Entities\User;

interface UserRepositoryContract
{
    public function create(CreateUserData $createUserData): User;
    public function update(User $user, UpdateUserData $updateUserData): User;
}