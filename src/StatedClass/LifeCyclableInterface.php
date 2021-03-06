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

namespace Teknoo\States\LifeCycle\StatedClass;

use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\Proxy\ProxyInterface;

/**
 * Interface LifeCyclableInterface
 * Interace to defining lifecyclable and tracable behaviors on your stated class.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface LifeCyclableInterface extends ProxyInterface
{
    /**
     * To register a new observer.
     *
     * @param ObservedInterface $observed
     *
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObservedInterface $observed): LifeCyclableInterface;

    /**
     * To unregister a previous registered observer.
     *
     * @param ObservedInterface $observed
     *
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObservedInterface $observed): LifeCyclableInterface;

    /**
     * To notify to observers that this instance has been changed.
     *
     * @return LifeCyclableInterface
     */
    public function notifyObserved(): LifeCyclableInterface;
}
