<?php

declare(strict_types=1);

/*
 * This file is part of the Demo project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Security\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class OmedSecurityExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $locator  = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new XmlFileLoader(
            $container,
            $locator
        );

        $loader->load('services.xml');
    }

}
