<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YannickArmspach\UX\React\Twig;

use YannickArmspach\UX\React\Model\React;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 * @experimental
 */
class ReactTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_react', [$this, 'renderReact'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function renderReact(Environment $env, React $react, array $attributes = []): string
    {
        $react->setAttributes(array_merge($react->getAttributes(), $attributes));

        $html = '
            <div
                data-controller="'.trim($react->getDataController().' @yannickarmspach/symfony-ux-react/react').'"
                data-view="'.twig_escape_filter($env, json_encode($react->createView()), 'html_attr').'"
        ';

        foreach ($react->getAttributes() as $name => $value) {
            if ('data-controller' === $name) {
                continue;
            }

            if (true === $value) {
                $html .= $name.'="'.$name.'" ';
            } elseif (false !== $value) {
                $html .= $name.'="'.$value.'" ';
            }
        }

        return trim($html).'></div>';
    }
}
