<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YannickArmspach\UX\React\Tests;

use PHPUnit\Framework\TestCase;
use YannickArmspach\UX\React\Builder\ReactBuilderInterface;
use YannickArmspach\UX\React\Model\React;
use YannickArmspach\UX\React\Tests\Kernel\TwigAppKernel;
use Twig\Environment;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class ReactExtensionTest extends TestCase
{
    public function testRenderReact()
    {
        $kernel = new TwigAppKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer()->get('test.service_container');

        /** @var ReactBuilderInterface $builder */
        $builder = $container->get('test.react.builder');

        $react = $builder->createReact(React::TYPE_LINE);

        $react->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $react->setOptions([
            'showLines' => false,
        ]);

        $rendered = $container->get('test.react.twig_extension')->renderReact(
            $container->get(Environment::class),
            $react,
            ['data-controller' => 'mycontroller', 'class' => 'myclass']
        );

        $this->assertSame(
            '<canvas
                data-controller="mycontroller yannickarmspach--symfony-ux-react--react"
                data-view="&#x7B;&quot;type&quot;&#x3A;&quot;line&quot;,&quot;data&quot;&#x3A;&#x7B;&quot;labels&quot;&#x3A;&#x5B;&quot;January&quot;,&quot;February&quot;,&quot;March&quot;,&quot;April&quot;,&quot;May&quot;,&quot;June&quot;,&quot;July&quot;&#x5D;,&quot;datasets&quot;&#x3A;&#x5B;&#x7B;&quot;label&quot;&#x3A;&quot;My&#x20;First&#x20;dataset&quot;,&quot;backgroundColor&quot;&#x3A;&quot;rgb&#x28;255,&#x20;99,&#x20;132&#x29;&quot;,&quot;borderColor&quot;&#x3A;&quot;rgb&#x28;255,&#x20;99,&#x20;132&#x29;&quot;,&quot;data&quot;&#x3A;&#x5B;0,10,5,2,20,30,45&#x5D;&#x7D;&#x5D;&#x7D;,&quot;options&quot;&#x3A;&#x7B;&quot;showLines&quot;&#x3A;false&#x7D;&#x7D;"
        class="myclass"></canvas>',
            $rendered
        );
    }
}
