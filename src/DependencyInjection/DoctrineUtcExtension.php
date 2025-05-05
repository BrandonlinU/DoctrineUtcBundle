<?php

namespace BrandonlinU\DoctrineUtcBundle\DependencyInjection;

use BrandonlinU\DoctrineUtcBundle\Orm\Type\TimezoneType;
use BrandonlinU\DoctrineUtcBundle\Orm\Type\UtcDateTimeImmutableType;
use BrandonlinU\DoctrineUtcBundle\Orm\Type\UtcDateTimeType;
use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

final class DoctrineUtcExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        if (!isset($container->getExtensions()['doctrine'])) {
            trigger_error('Doctrine bundle is not registered. Nothing to do.', \E_USER_WARNING);

            return;
        }

        $container->prependExtensionConfig('doctrine', [
            'dbal' => [
                'types' => [
                    Types::TIMEZONE => TimezoneType::class,
                    Types::UTC_DATETIME => UtcDateTimeType::class,
                    Types::UTC_DATETIME_IMMUTABLE => UtcDateTimeImmutableType::class,
                ],
            ],
            'orm' => [
                'mappings' => [
                    'DoctrineUtcBundle' => [
                        'is_bundle' => true,
                        'type' => 'attribute',
                        'dir' => 'Orm/Entity',
                        'prefix' => 'BrandonlinU\\DoctrineUtcBundle\\Orm\\Entity',
                    ],
                ],
            ],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
