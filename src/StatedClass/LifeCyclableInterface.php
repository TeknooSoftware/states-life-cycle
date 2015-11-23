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

namespace Teknoo\States\LifeCycle\StatedClass;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\Proxy\ProxyInterface;

/**
 * Interface LifeCyclableInterface
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface LifeCyclableInterface extends ProxyInterface
{
    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObservedInterface $observed): LifeCyclableInterface;

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObservedInterface $observed): LifeCyclableInterface;

    /**
     * @return LifeCyclableInterface
     */
    public function notifyObserved(): LifeCyclableInterface;
}
