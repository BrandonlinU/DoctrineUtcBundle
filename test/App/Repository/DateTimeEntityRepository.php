<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\App\Repository;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Test\App\Entity\DateTimeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DateTimeEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateTimeEntity::class);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return array<int, DateTimeEntity>
     */
    public function findByDate(\DateTimeInterface $dateTime): array
    {
        return $this->createQueryBuilder('dt')
            ->where('dt.dateTime.value = :date')
            ->setParameter('date', $dateTime, Types::UTC_DATETIME)
            ->getQuery()
            ->getResult()
        ;
    }
}
