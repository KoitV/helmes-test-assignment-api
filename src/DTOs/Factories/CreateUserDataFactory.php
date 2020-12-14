<?php


namespace App\DTOs\Factories;


use App\DTOs\CreateUserData;
use Symfony\Component\HttpFoundation\Request;

class CreateUserDataFactory
{
    public static function fromRequest(Request $request): CreateUserData
    {
        return new CreateUserData(
            firstName: $request->get('firstName'),
            lastName: $request->get('lastName'),
            hasAgreedToTerms: $request->get('hasAgreedToTerms'),
            sectorIds: $request->get('sectorIds')
        );
    }
}