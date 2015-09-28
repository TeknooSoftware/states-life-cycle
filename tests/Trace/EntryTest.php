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
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\States\LifeCycle\Trace;

use UniAlteri\States\LifeCycle\Trace\Entry;
use UniAlteri\States\LifeCycle\Trace\EntryInterface;

/**
 * Class EntityTest.
 *
 * @covers UniAlteri\States\LifeCycle\Trace\Entry
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
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
