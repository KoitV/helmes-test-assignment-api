<?php

namespace App\Controllers;

use App\DTOs\Factories\CreateUserDataFactory;
use App\DTOs\Factories\GetUserDataFactory;
use App\DTOs\Factories\UpdateUserDataFactory;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\CreateUserService;
use App\Services\UpdateUserService;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $format = 'json';

    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private $appSecret
    )
    {}

    #[Route('/users/{id}', name: 'users.show', methods: ['GET'])]
    public function show(
        UserRepositoryContract $userRepository,
        Request $request
    ): Response {
        $getUserData = GetUserDataFactory::fromRequest($request);

        $violations = $this->validator->validate($getUserData);

        if($violations->count() > 0)
        {
            return new Response(
                $this->serializer->serialize($violations, $this->format),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $user = $userRepository->get($getUserData);

        $serializedContent = $this->serializer->serialize($user, $this->format, [
            AbstractObjectNormalizer::GROUPS => ['get_user']
        ]);

        return new Response(
            $serializedContent,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route('/users', name: 'users.store', methods: ['POST'])]
    public function store(
        Request $request,
        CreateUserService $createUserService
    ): Response {
        $createUserData = CreateUserDataFactory::fromRequest($request);

        $violations = $this->validator->validate($createUserData);

        if($violations->count() > 0)
        {
            return new Response(
                $this->serializer->serialize($violations, $this->format),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $user = $createUserService->execute($createUserData);

        $payload = ['userId' => $user->getId()->toString()];

        $jwt = JWT::encode($payload, $this->appSecret);

        $serializedContent = $this->serializer->serialize($user, $this->format, [
            AbstractObjectNormalizer::GROUPS => ['create_user']
        ]);

        return new Response(
            $serializedContent,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $jwt)
            ]
        );
    }

    #[Route('/users/{id}', name: 'users.update', methods: ['PUT'])]
    public function update(
        Request $request,
        UpdateUserService $updateUserService
    ): Response {
        $updateUserData = UpdateUserDataFactory::fromRequest($request);

        if($request->headers->has('Authorization'))
        {
            $authorizationHeader = $request->headers->get('Authorization');
            $jwtString = str_replace('Bearer ', '', $authorizationHeader);

            $jwt = JWT::decode($jwtString, $this->appSecret, ['HS256']);

            $updateUserData->authenticatedUserId = Uuid::getFactory()->fromString($jwt->userId);
        }

        $violations = $this->validator->validate($updateUserData);

        if($violations->count() > 0)
        {
            return new Response(
                $this->serializer->serialize($violations, $this->format),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $user = $updateUserService->execute($updateUserData);

        $serializedContent = $this->serializer->serialize($user, $this->format, [
            AbstractObjectNormalizer::GROUPS => ['update_user']
        ]);

        return new Response(
            $serializedContent,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

}
