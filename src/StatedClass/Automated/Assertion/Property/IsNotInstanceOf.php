<?php

declare(strict_types=1);

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

namespace Teknoo\States\LifeCycle\StatedClass\Automated\Assertion\Property;

/**
 * class IsNotInstanceOf
 * Invokable class to use with Teknoo\States\LifeCycle\StatedClass\Automated\Assertion to check if a propery
 * is not an instance of the excepted class name.
 *
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class IsNotInstanceOf
{
    /**
     * @var string
     */
    private $exceptedClassName;

    /**
     * IsNotInstanceOf constructor.
     *
     * @param string $exceptedClassName
     */
    public function __construct(string $exceptedClassName)
    {
        $this->exceptedClassName = $exceptedClassName;
    }

    /**
     * @param mixed &$property
     *
     * @return bool
     */
    public function __invoke($property): bool
    {
        return !($property instanceof $this->exceptedClassName);
    }
}
