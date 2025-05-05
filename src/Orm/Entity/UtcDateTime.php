<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Entity;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UtcDateTime
{
    #[ORM\Column(type: Types::UTC_DATETIME)]
    private \DateTimeInterface $value;

    #[ORM\Column(type: Types::TIMEZONE)]
    private \DateTimeZone $timeZone;

    private bool $localized = false;

    public function getValue(): \DateTimeInterface
    {
        if (!$this->localized) {
            $this->value = $this->value->setTimezone($this->timeZone);
            $this->localized = true;
        }

        return $this->value;
    }

    public function setValue(\DateTimeInterface $value): static
    {
        $this->value = $value;
        $this->timeZone = $value->getTimezone();
        $this->localized = true;

        return $this;
    }
}
