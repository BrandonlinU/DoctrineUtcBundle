<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\App\Repository;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Test\App\Entity\DateTimeImmutableEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DateTimeImmutableEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateTimeImmutableEntity::class);
    }

    /**
     * @return array<int, DateTimeImmutableEntity>
     */
    public function findByDate(\DateTimeImmutable $dateTime): array
    {
        return $this->createQueryBuilder('dt')
            ->where('dt.dateTime.value = :date')
            ->setParameter('date', $dateTime, Types::UTC_DATETIME_IMMUTABLE)
            ->getQuery()
            ->getResult()
        ;
    }
}
