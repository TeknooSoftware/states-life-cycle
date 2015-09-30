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

namespace UniAlteri\States\LifeCycle\Scenario;

use UniAlteri\States\LifeCycle\Observing\ObservedInterface;
use UniAlteri\States\LifeCycle\Tokenization\Tokenizer;

/**
 * Class ScenarioBuilder
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class ScenarioBuilder implements ScenarioBuilderInterface
{
    /**
     * @var Tokenizer
     */
    private $tokenizer;

    /**
     * @var string[]
     */
    private $eventNamesList = [];

    /**
     * @var string
     */
    private $statedClassName;

    /**
     * @var ObservedInterface
     */
    private $observed;

    /**
     * @var string[]
     */
    private $neededStatesList = [];

    /**
     * @var string[]
     */
    private $forbiddenStatesList = [];

    /**
     * @var string[]
     */
    private $neededIncomingStatesList = [];

    /**
     * @var string[]
     */
    private $neededOutgoingStatesList = [];

    /**
     * @var callable
     */
    private $callable;

    /**
     * @param Tokenizer $tokenizer
     */
    public function __construct(Tokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    /**
     * {@inheritdoc}
     */
    public function when(\string $eventName): ScenarioBuilderInterface
    {
        $this->eventNamesList[] = $eventName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function towardStatedClass(\string $statedClassName): ScenarioBuilderInterface
    {
        $this->statedClassName = $statedClassName;
        $this->when($this->tokenizer->getStatedClassNameToken($statedClassName));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function towardObserved(ObservedInterface $observed): ScenarioBuilderInterface
    {
        $this->observed = $observed;
        $this->when($this->tokenizer->getStatedClassInstanceToken($observed->getObject()));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ifNotInState(\string $stateName): ScenarioBuilderInterface
    {
        $this->forbiddenStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ifInState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function onIncomingState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededIncomingStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function onOutgoingState(\string $stateName): ScenarioBuilderInterface
    {
        $this->neededOutgoingStatesList[$stateName] = $stateName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run(callable $callable): ScenarioBuilderInterface
    {
        $this->callable = $callable;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getEventNamesList()
    {
        return array_values($this->eventNamesList);
    }

    /**
     * @return string
     */
    public function getStatedClassName()
    {
        return $this->statedClassName;
    }

    /**
     * @return ObservedInterface
     */
    public function getObserved()
    {
        return $this->observed;
    }

    /**
     * @return \string[]
     */
    public function getForbiddenStatesList()
    {
        return array_values($this->forbiddenStatesList);
    }

    /**
     * @return \string[]
     */
    public function getNeededStatesList()
    {
        return array_values($this->neededStatesList);
    }

    /**
     * @return \string[]
     */
    public function getNeededIncomingStatesList()
    {
        return array_values($this->neededIncomingStatesList);
    }

    /**
     * @return \string[]
     */
    public function getNeededOutgoingStatesList()
    {
        return array_values($this->neededOutgoingStatesList);
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * {@inheritdoc}
     */
    public function build(ScenarioInterface $scenario): ScenarioInterface
    {
        $scenario->configure($this);

        return $scenario;
    }
}