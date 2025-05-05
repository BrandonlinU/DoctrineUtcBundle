<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\App\Entity;

use BrandonlinU\DoctrineUtcBundle\Orm\Entity\UtcDateTime;
use BrandonlinU\DoctrineUtcBundle\Test\App\Repository\DateTimeEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateTimeEntityRepository::class)]
class DateTimeEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded]
    private UtcDateTime $dateTime;

    public function __construct()
    {
        $this->dateTime = new UtcDateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime->getValue();
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime->setValue($dateTime);

        return $this;
    }
}
