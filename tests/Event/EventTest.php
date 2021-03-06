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

namespace Teknoo\Tests\States\LifeCycle\Event;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Event\EventTrait;

/**
 * Class EventTest.
 *
 * @covers \Teknoo\States\LifeCycle\Event\EventTrait
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class EventTest extends AbstractEventTest
{
    /**
     * @param $observed
     * @param $incomingState
     * @param $outGoingState
     *
     * @return EventTrait
     */
    public function build($observed, $incomingState, $outGoingState)
    {
        return new class($observed, $incomingState, $outGoingState) implements EventInterface {
            use EventTrait;
        };
    }
}
