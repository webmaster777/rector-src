<?php

declare(strict_types=1);

namespace Rector\Core\DependencyInjection\Loader;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class ConfigurableCallValuesCollectingPhpFileLoader extends PhpFileLoader
{
    public function __construct(
        ContainerBuilder $containerBuilder,
        FileLocatorInterface $fileLocator,
        private ConfigureCallValuesCollector $configureCallValuesCollector
    ) {
        parent::__construct($containerBuilder, $fileLocator);
    }

    /**
     * @param mixed $resource
     * @param null|string $type
     */
    public function load($resource, $type = null): void
    {
        // this call collects root values
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();

        parent::load($resource, $type);

        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
    }

    public function import(
        $resource,
        $type = null,
        $ignoreErrors = false,
        $sourceResource = null,
        $exclude = null
    ): void {
        // this call collects root values
        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();

        parent::import($resource, $type, $ignoreErrors, $sourceResource, $exclude);

        $this->collectConfigureCallsFromJustImportedConfigurableRectorDefinitions();
    }

    private function collectConfigureCallsFromJustImportedConfigurableRectorDefinitions(): void
    {
        foreach ($this->container->getDefinitions() as $class => $definition) {
            /** @var string $class */
            if (! is_a($class, ConfigurableRectorInterface::class, true)) {
                continue;
            }

            $this->configureCallValuesCollector->collectFromServiceAndClassName($class, $definition);
        }
    }
}
