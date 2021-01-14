<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YannickArmspach\UX\React\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use YannickArmspach\UX\React\Builder\ReactBuilder;
use YannickArmspach\UX\React\Builder\ReactBuilderInterface;
use YannickArmspach\UX\React\Twig\ReactTwigExtension;
use Twig\Environment;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class ReactExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition('react.builder', new Definition(ReactBuilder::class))
            ->setPublic(false)
        ;

        $container
            ->setAlias(ReactBuilderInterface::class, 'react.builder')
            ->setPublic(false)
        ;

        if (class_exists(Environment::class)) {
            $container
                ->setDefinition('react.twig_extension', new Definition(ReactTwigExtension::class))
                ->addTag('twig.extension')
                ->setPublic(false)
            ;
        }
    }
}
