<?php

namespace App\Controllers;

use App\DTOs\Factories\CreateUserDataFactory;
use App\Services\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users.store', methods: ['POST'])]
    public function store(
        Request $request,
        CreateUserService $createUserService,
        SerializerInterface $serializer
    ): Response {
        $createUserData = CreateUserDataFactory::fromRequest($request);

        $user = $createUserService->execute($createUserData);

        $serializedContent = $serializer->serialize($user, 'json', [
            AbstractObjectNormalizer::GROUPS => ['create_user']
        ]);

        return new Response(
            $serializedContent,
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
