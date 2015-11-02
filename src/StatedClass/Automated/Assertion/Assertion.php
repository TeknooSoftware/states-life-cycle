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
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\States\LifeCycle\StatedClass\Automated\Assertion;

use Teknoo\States\Proxy\ProxyInterface;

/**
 * class Assertion
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class Assertion extends AbstractAssertion implements AssertionInterface
{
    /**
     * @var array
     */
    private $propertiesAssertions = [];

    /**
     * @param string $property
     * @param mixed $exceptedValue
     * @return Assertion
     */
    public function with(\string $property, $exceptedValue): Assertion
    {
        $this->propertiesAssertions[$property] = $exceptedValue;

        return $this;
    }

    /**
     * @param ProxyInterface $proxy
     * @return bool
     */
    public function isValid(ProxyInterface $proxy): \bool
    {
        $asserted = true;

        foreach ($this->propertiesAssertions as $property=>$exceptedValue) {
            if (null !== $exceptedValue && property_exists($this, $property)) {
                if (!is_callable($exceptedValue)) {
                    $asserted |= $exceptedValue == $this->{$property};
                } else {
                    $asserted |= $exceptedValue($this->{$property});
                }
            }

            if (!$asserted) {
                break;
            }
        }

        return $asserted;
    }
}