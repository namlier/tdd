<?php


declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;


return (function () {
    $container = new ContainerBuilder();

    // Event Dispatcher's paths
    $container->addCompilerPass(new RegisterListenersPass());
    $container->setParameter('kernel.project_dir', __DIR__);

    // Yaml read services from
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
    $loader->load('services.yaml');

    // Php read services from
    $phpLoader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/config'));
    $phpLoader->load('services.php');

    $container->compile();

    return $container;
})();



