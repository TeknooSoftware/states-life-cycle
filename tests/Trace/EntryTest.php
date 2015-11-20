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

namespace Teknoo\Tests\States\LifeCycle\Trace;

use Teknoo\States\LifeCycle\Trace\Entry;
use Teknoo\States\LifeCycle\Trace\EntryInterface;

/**
 * Class EntityTest.
 *
 * @covers Teknoo\States\LifeCycle\Trace\Entry
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class EntryTest extends AbstractEntryTest
{
    /**
     * @param $observedInterface
     * @param $enabledStatesList
     * @param $previous
     *
     * @return EntryInterface
     */
    public function build($observedInterface, $enabledStatesList, $previous = null)
    {
        return new Entry($observedInterface, $enabledStatesList, $previous);
    }
}
