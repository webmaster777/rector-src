<?php

declare(strict_types=1);

use Rector\DowngradePhp72\Rector\Class_\DowngradeParameterTypeWideningRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(DowngradeParameterTypeWideningRector::class);
};
