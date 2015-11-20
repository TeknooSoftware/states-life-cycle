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
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\States\LifeCycle\StatedClass\Automated\Assertion;

use Teknoo\States\Proxy\ProxyInterface;

/**
 * class Assertion
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
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

        $reflectionObject = new \ReflectionObject($proxy);
        foreach ($this->propertiesAssertions as $property=>$exceptedValue) {
            if (null !== $exceptedValue && property_exists($proxy, $property)) {
                $reflectionProperty = $reflectionObject->getProperty($property);
                $reflectionProperty->setAccessible(true);
                $propertyValue = $reflectionProperty->getValue($proxy);

                if (!is_callable($exceptedValue)) {
                    $asserted &= $exceptedValue == $propertyValue;
                } else {
                    $asserted &= $exceptedValue($propertyValue);
                }
            } else {
                $asserted = false;
            }

            if (!$asserted) {
                break;
            }
        }

        return $asserted;
    }
}