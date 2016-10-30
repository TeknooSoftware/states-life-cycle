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
namespace Teknoo\Tests\States\LifeCycle\Tokenization;

use Teknoo\States\LifeCycle\Event\EventInterface;
use Teknoo\States\LifeCycle\Tokenization\TokenizerInterface;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class AbstractTokenizerTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
abstract class AbstractTokenizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TokenizerInterface
     */
    abstract public function build();

    /**
     * @expectedException \TypeError
     */
    public function testGetTokenBadArgument()
    {
        $this->build()->getToken(new \stdClass());
    }

    public function testGetToken()
    {
        /*
         * @var EventInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $instance = $this->createMock(EventInterface::class);
        $instance->expects(self::any())->method('getObject')->willReturn(new Acme());
        self::assertTrue(is_array($this->build()->getToken($instance)));
    }
}
