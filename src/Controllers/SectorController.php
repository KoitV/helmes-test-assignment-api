<?php


namespace App\Controllers;


use App\Repositories\Contracts\SectorRepositoryContract;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class SectorController extends AbstractController
{
    #[Route('/sectors', name: 'sectors.all', methods: ['GET'])]
    public function all(
        SectorRepositoryContract $sectorRepository,
        SerializerInterface $serializer
    ): Response {
        $sectors = $sectorRepository->allToplevelWithChildren();


        $serializedContent = $serializer->serialize($sectors, 'json', context: [
            AbstractObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object, $format, $context){
                return $object->getId();
            },
        ]);

        return new Response(
            $serializedContent,
            200,
            ['Content-Type' => 'application/json']
        );
    }
}