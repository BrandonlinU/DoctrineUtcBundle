<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Entity;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Util\TimeZone;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UtcDateTime
{
    #[ORM\Column(type: Types::UTC_DATETIME)]
    private ?\DateTime $value = null;

    #[ORM\Column(length: 180)]
    private ?string $timeZone = null;

    private bool $localized = false;

    public function getValue(): ?\DateTime
    {
        if ($this->value && !$this->localized) {
            $this->value = $this->value->setTimezone(TimeZone::get($this->timeZone));
            $this->localized = true;
        }

        return $this->value;
    }

    public function setValue(\DateTime $value): static
    {
        $this->value = $value;
        $this->timeZone = $value->getTimezone()->getName();
        $this->localized = true;

        return $this;
    }
}
