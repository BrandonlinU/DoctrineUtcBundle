<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\Integration;

use BrandonlinU\DoctrineUtcBundle\DoctrineUtcBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineUtcBundleTest extends KernelTestCase
{
    public function testRegistration(): void
    {
        $kernel = self::bootKernel();
        $bundle = $kernel->getBundle('DoctrineUtcBundle');

        $this->assertInstanceOf(DoctrineUtcBundle::class, $bundle);
    }
}
