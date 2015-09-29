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

namespace UniAlteri\Tests\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Scenario\Scenario;

/**
 * Class ScenarioTest.
 *
 * @covers UniAlteri\States\LifeCycle\Scenario\Scenario
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ScenarioTest extends AbstractScenarioTest
{
    /**
     * @return Scenario
     */
    public function build()
    {
        $builder = $this->getMock('UniAlteri\States\LifeCycle\Scenario\ScenarioBuilder', [], [], '', false);
        $builder->expects($this->any())->method('getEventNamesList')->willReturn(['fooBar']);
        $builder->expects($this->any())->method('getNeededIncomingStatesList')->willReturn(['foo', 'bar']);
        $builder->expects($this->any())->method('getNeededOutgoingStatesList')->willReturn(['outstate']);
        $builder->expects($this->any())->method('getNeededStatesList')->willReturn(['foo', 'bar', 'state']);
        $builder->expects($this->any())->method('getStatedClassName')->willReturn('fooBarName');
        $observed = $this->getMock('UniAlteri\States\LifeCycle\Observing\ObservedInterface');
        $builder->expects($this->any())->method('getObserved')->willReturn($observed);
        $builder->expects($this->any())->method('getCallable')->willReturn(function () {});

        return new Scenario($builder);
    }
}
