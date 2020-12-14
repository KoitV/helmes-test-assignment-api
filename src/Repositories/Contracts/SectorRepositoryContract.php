<?php


namespace App\Repositories\Contracts;


use Doctrine\Common\Collections\Collection;

interface SectorRepositoryContract
{
    public function allToplevelWithChildren(): Collection;
    public function findAllByIds(array $ids): Collection;
}