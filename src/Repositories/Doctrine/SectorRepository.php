<?php


namespace App\Repositories\Doctrine;


use App\Entities\Sector;
use App\Repositories\Contracts\SectorRepositoryContract;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Ramsey\Uuid\Uuid;

class SectorRepository implements SectorRepositoryContract
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

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

    public function findAllByIds(array $ids): Collection
    {
        $parameters = new ArrayCollection();
        $names = new ArrayCollection();

        foreach($ids as $index => $id)
        {
            $uuid = Uuid::getFactory()->fromString($id);

            $name = sprintf('id%d', $index);
            $names->add(sprintf(':%s', $name));

            $parameters->add(new Parameter($name, $uuid, 'uuid_binary_ordered_time'));
        }

        $query = $this->entityManager->createQueryBuilder()
            ->select('sector')
            ->from(Sector::class, 'sector')
            ->where(sprintf('sector.id IN (%s)', implode(',', $names->toArray())))
            ->setParameters($parameters);

        return new ArrayCollection($query->getQuery()->getResult());
    }
}