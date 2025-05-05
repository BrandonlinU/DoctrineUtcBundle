<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\Integration;

use BrandonlinU\DoctrineUtcBundle\Test\App\Entity\DateTimeEntity;
use BrandonlinU\DoctrineUtcBundle\Test\App\Entity\DateTimeImmutableEntity;
use BrandonlinU\DoctrineUtcBundle\Test\App\Repository\DateTimeEntityRepository;
use BrandonlinU\DoctrineUtcBundle\Test\App\Repository\DateTimeImmutableEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTest extends KernelTestCase
{
    private AbstractDatabaseTool $databaseTool;

    private EntityManagerInterface $em;

    private DateTimeEntityRepository $dateTimeRepository;

    private DateTimeImmutableEntityRepository $dateTimeImmutableRepository;

    public function testDateTime(): void
    {
        $this->databaseTool->loadFixtures([]);

        $dateTime = new \DateTime('2025-01-02 10:00:00', new \DateTimeZone('America/Monterrey'));
        $utcDateTime = new \DateTime('2025-01-02 10:00:00', new \DateTimeZone('UTC'));

        $testEntity = new DateTimeEntity();
        $testEntity->setDateTime($dateTime);
        $this->em->persist($testEntity);
        $this->em->flush();

        $this->assertCount(1, $this->dateTimeRepository->findByDate($dateTime));
        $this->assertCount(0, $this->dateTimeRepository->findByDate($utcDateTime));
    }

    public function testDateTimeImmutable(): void
    {
        $this->databaseTool->loadFixtures([]);

        $dateTime = new \DateTimeImmutable('2025-01-02 10:00:00', new \DateTimeZone('America/Monterrey'));
        $utcDateTime = new \DateTimeImmutable('2025-01-02 10:00:00', new \DateTimeZone('UTC'));

        $testEntity = new DateTimeImmutableEntity();
        $testEntity->setDateTime($dateTime);
        $this->em->persist($testEntity);
        $this->em->flush();

        $this->assertCount(1, $this->dateTimeImmutableRepository->findByDate($dateTime));
        $this->assertCount(0, $this->dateTimeImmutableRepository->findByDate($utcDateTime));
    }
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->em = static::getContainer()->get('doctrine.orm.entity_manager');
        $this->dateTimeRepository = $this->em->getRepository(DateTimeEntity::class);
        $this->dateTimeImmutableRepository = $this->em->getRepository(DateTimeImmutableEntity::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->databaseTool, $this->em, $this->dateTimeRepository, $this->dateTimeImmutableRepository);
    }
}
