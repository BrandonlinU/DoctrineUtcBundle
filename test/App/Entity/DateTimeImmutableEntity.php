<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\App\Entity;

use BrandonlinU\DoctrineUtcBundle\Orm\Entity\UtcDateTimeImmutable;
use BrandonlinU\DoctrineUtcBundle\Test\App\Repository\DateTimeImmutableEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateTimeImmutableEntityRepository::class)]
class DateTimeImmutableEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded]
    private UtcDateTimeImmutable $dateTime;

    public function __construct()
    {
        $this->dateTime = new UtcDateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime->getValue();
    }

    public function setDateTime(\DateTimeImmutable $dateTime): static
    {
        $this->dateTime->setValue($dateTime);

        return $this;
    }
}
