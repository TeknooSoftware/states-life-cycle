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
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\States\LifeCycle\StatedClass;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;

/**
 * Class LifeCyclableTrait
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
trait LifeCyclableTrait
{
    /**
     * @var ObservedInterface[]
     */
    private $observedList = [];

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function registerObserver(ObservedInterface $observed): LifeCyclableInterface
    {
        $this->observedList[spl_object_hash($observed)] = $observed;

        return $this;
    }

    /**
     * @param ObservedInterface $observed
     * @return LifeCyclableInterface
     */
    public function unregisterObserver(ObservedInterface $observed): LifeCyclableInterface
    {
        $observedHash = spl_object_hash($observed);

        if (isset($this->observedList[$observedHash])) {
            unset($this->observedList[$observedHash]);
        }

        return $this;
    }

    /**
     * @return LifeCyclableInterface
     */
    public function notifyObserved(): LifeCyclableInterface
    {
        foreach ($this->observedList as $observed) {
            $observed->observeUpdate();
        }

        return $this;
    }
}