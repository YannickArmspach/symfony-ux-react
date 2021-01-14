<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YannickArmspach\UX\React\Builder;

use YannickArmspach\UX\React\Model\React;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 * @experimental
 */
class ReactBuilder implements ReactBuilderInterface
{
    public function createReact(string $type): React
    {
        return new React($type);
    }
}
