<?php


namespace App\DTOs\Factories;


use App\DTOs\UpdateUserData;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserDataFactory
{
    public static function fromRequest(Request $request): UpdateUserData
    {
        return new UpdateUserData(
            id: Uuid::fromString($request->get('id')),
            firstName: $request->get('firstName'),
            lastName: $request->get('lastName'),
            hasAgreedToTerms: $request->get('hasAgreedToTerms'),
            sectorIds: $request->get('sectorIds')
        );
    }
}