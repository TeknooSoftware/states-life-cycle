<?php

/**
 * States.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\States\LifeCycle\StatedClass\Automated\Assertion;

use UniAlteri\States\Proxy\ProxyInterface;

/**
 * class Callback
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Callback extends AbstractAssertion implements AssertionInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     * @return Callback
     */
    public function call(callable $callback): Callback
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @param ProxyInterface $proxy
     * @return bool
     */
    public function isValid(ProxyInterface $proxy): \bool
    {
        $callback = $this->callback;
        return $callback($proxy);
    }
}