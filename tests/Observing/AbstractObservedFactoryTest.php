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
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */

namespace Teknoo\Tests\States\LifeCycle\Observing;

use Teknoo\States\LifeCycle\Observing\ObservedFactoryInterface;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Observing\ObserverInterface;
use Teknoo\States\LifeCycle\StatedClass\LifeCyclableInterface;

/**
 * Class AbstractObservedFactoryTest.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractObservedFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return ObservedFactoryInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testCreateBadObserver()
    {
        $this->build()->create(new \stdClass(), $this->createMock(LifeCyclableInterface::class));
    }

    /**
     * @expectedException \TypeError
     */
    public function testCreateBadInstance()
    {
        $this->build()->create($this->createMock(ObserverInterface::class), new \stdClass());
    }

    public function testCreate()
    {
        $factory = $this->build();

        self::assertInstanceOf(
            ObservedInterface::class,
            $factory->create(
                $this->createMock(ObserverInterface::class),
                $this->createMock(LifeCyclableInterface::class)
            )
        );
    }
}
