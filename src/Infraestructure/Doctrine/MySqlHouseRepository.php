<?php

declare(strict_types=1);

namespace App\Infraestructure\Doctrine;

use App\Domain\House;
use App\Domain\HouseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


final class MySqlHouseRepository implements HouseRepository
{
    private const MAX_RESULTS = 20;
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(House::class);
    }

    public function search(int $houseId)
    {
        return $this->repository->find($houseId);
    }

    public function searchAll($sortedBy = null): array
    {
        $qb = $this->repository->createQueryBuilder('house');

        $this->sortBy($qb, $sortedBy);

        return $qb
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
    }

    public function save(House $house)
    {
        $this->entityManager->persist($house);
        $this->entityManager->flush($house);
    }

    private function sortBy(QueryBuilder $qb, $field): void
    {
        if(null === $field) {
            return ;
        }

        $qb->orderBy('house.'.$field);
    }
}