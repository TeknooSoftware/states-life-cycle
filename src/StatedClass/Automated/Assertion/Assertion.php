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
 * to richarddeloge@gmail.com so we can send you a copy immediately.
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
 * Class Assertion
 * Implementation of AssertionInterface to determine states list from stated class instance's values.
 * All assertions defined with the method with() must be valid to get the assertion as valid.
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
     * @var array|callable
     */
    private $propertiesAssertions = [];

    /**
     * To register an assertion on a property. $exceptedValue can be the excepted value or a invokable object
     * Some invokable class are available in Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property.
     *
     * @param string $property
     * @param mixed  $exceptedValue
     *
     * @return Assertion
     */
    public function with(string $property, $exceptedValue): Assertion
    {
        $this->propertiesAssertions[$property] = $exceptedValue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(ProxyInterface $proxy): bool
    {
        $asserted = true;

        $reflectionObject = new \ReflectionObject($proxy);
        //Browse properties assertion
        foreach ($this->propertiesAssertions as $property => $exceptedValue) {
            if (null !== $exceptedValue && \property_exists($proxy, $property)) {
                //If the property exists, get it's value via the Reflection api (properties are often not accessible for public)
                $reflectionProperty = $reflectionObject->getProperty($property);
                $reflectionProperty->setAccessible(true);
                $propertyValue = $reflectionProperty->getValue($proxy);

                if (!\is_callable($exceptedValue)) {
                    //Not a callable, perform a equal test
                    $asserted &= $exceptedValue == $propertyValue;
                } else {
                    $asserted &= $exceptedValue($propertyValue);
                }
            } else {
                //If the property does not existn the assertion fail
                $asserted = false;
            }

            if (!$asserted) {
                //Stop at first fail
                break;
            }
        }

        return $asserted;
    }
}
