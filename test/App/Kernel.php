<?php

namespace BrandonlinU\DoctrineUtcBundle\Test\App;

use BrandonlinU\DoctrineUtcBundle\DoctrineUtcBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Liip\TestFixturesBundle\LiipTestFixturesBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    public function getProjectDir(): string
    {
        return __DIR__;
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new DoctrineFixturesBundle(),
            new LiipTestFixturesBundle(),
            new DoctrineUtcBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir() . '/config/services.xml');
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('doctrine', [
                'dbal' => [
                    'driver' => 'pdo_sqlite',
                    'path' => '%kernel.project_dir%/var/data.db',
                ],
                'orm' => [
                    'mappings' => [
                        'App' => [
                            'is_bundle' => false,
                            'type' => 'attribute',
                            'dir' => '%kernel.project_dir%/Entity',
                            'prefix' => 'BrandonlinU\DoctrineUtcBundle\Test\App\Entity',
                        ],
                    ],
                ],
            ]);
            $container->loadFromExtension('framework', [
                'secret' => '%env(APP_SECRET)%',
                'test' => true,
            ]);
        });
    }
}
