<?php


namespace App\Normalizers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UuidNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array()): UuidInterface
    {
        return Uuid::fromString($data);
    }

    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return is_string($data) && is_a($type, UuidInterface::class, true) && Uuid::isValid($data);
    }

    public function normalize($object, $format = null, array $context = array()): float|array|\ArrayObject|bool|int|string|null
    {
        return $object->toString();
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof UuidInterface;
    }
}