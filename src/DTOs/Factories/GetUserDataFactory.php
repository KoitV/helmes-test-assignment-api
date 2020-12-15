<?php


namespace App\DTOs\Factories;


use App\DTOs\GetUserData;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class GetUserDataFactory
{
    public static function fromRequest(Request $request): GetUserData
    {
        return new GetUserData(
            id: Uuid::fromString($request->get('id'))
        );
    }
}