<?php


namespace App\Repositories\Doctrine;


use App\Entities\Sector;
use App\Repositories\Contracts\SectorRepositoryContract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class SectorRepository implements SectorRepositoryContract
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function allToplevelWithChildren(): Collection
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select(['sector', 'children'])
            ->from(Sector::class, 'sector')
            ->join('sector.children', 'children')
            ->where('sector.parent IS NULL')
            ->getQuery();

        $sectors = $query->getResult();

        return new ArrayCollection($sectors);
    }
}