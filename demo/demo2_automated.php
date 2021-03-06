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

namespace demo;

use demo\AutomatedAcme\AutomatedAcme;

include dirname(__DIR__).'/vendor/autoload.php';

echo PHP_EOL.' Create new automated instance';
$automatedAcme = new AutomatedAcme();

echo PHP_EOL.'No enabled states :';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());

echo PHP_EOL.'Set foo property at bar, not call updateStates, states must stay unchanged';
$automatedAcme->setFoo('bar');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
echo PHP_EOL.'Call updateStates, change states, enable state 1';
$automatedAcme->updateStates();
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());

echo PHP_EOL.'Set foo1 property at bar1, not call updateStates, states must stay unchanged';
$automatedAcme->setFoo1('bar1')->setFoo2(123);
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
echo PHP_EOL.'Call updateStates, change states, state1 must stay enabled';
$automatedAcme->updateStates();
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());

echo PHP_EOL.'Set foo1 property at bar1 and foo2 to null, not call updateStates, states must stay unchanged';
$automatedAcme->setFoo1('bar1')->setFoo2(null);
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
$automatedAcme->updateStates();
echo PHP_EOL.'Call updateStates, change states, state1 must stay enabled, state 2 must be enabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());

echo PHP_EOL.'Set foo property at empty, not call updateStates, states must stay unchanged';
$automatedAcme->setFoo('');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
$automatedAcme->updateStates();
echo PHP_EOL.'Call updateStates, change states, state1 must be disabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());

echo PHP_EOL.'Set foo1 property at empty, not call updateStates, states must stay unchanged';
$automatedAcme->setFoo1('');
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
$automatedAcme->updateStates();
echo PHP_EOL.'Call updateStates, change states, all states are disabled';
echo PHP_EOL.'Enabled states : '.implode(', ', $automatedAcme->listEnabledStates());
