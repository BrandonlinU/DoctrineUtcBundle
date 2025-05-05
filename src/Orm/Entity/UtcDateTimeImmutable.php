<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Entity;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UtcDateTimeImmutable
{
    #[ORM\Column(type: Types::UTC_DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $value;

    #[ORM\Column(type: Types::TIMEZONE)]
    private \DateTimeZone $timeZone;

    private bool $localized = false;

    public function getValue(): \DateTimeImmutable
    {
        if (!$this->localized) {
            $this->value = $this->value->setTimezone($this->timeZone);
        }

        return $this->value;
    }

    public function setValue(\DateTimeImmutable $value): static
    {
        $this->value = $value;
        $this->timeZone = $value->getTimezone();
        $this->localized = true;

        return $this;
    }
}
