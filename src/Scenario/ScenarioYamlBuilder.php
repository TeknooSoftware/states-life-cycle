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

namespace Teknoo\States\LifeCycle\Scenario;

use Symfony\Component\Yaml\Parser;

/**
 * Class ScenarioYamlBuilder
 * Another implementation of scenario builder to allow developper to create scenarii from YAML files
 * about stated class instances.
 * A scenario can accept several conditions : each condition must be validated to execute the scenario. *.
 *
 * @copyright   Copyright (c) 2009-2017 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ScenarioYamlBuilder extends ScenarioBuilder
{
    /**
     * YAML parser to read the scenario.
     *
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var string
     */
    private $yamlScenario;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * To list options, in yaml, correspondence with builder's methods.
     *
     * @var array
     */
    private $yamlOptionsMap = [
        'when' => 'when',
        'class' => 'towardStatedClass',
        'notIn' => 'ifNotInState',
        'in' => 'ifInState',
        'incoming' => 'onIncomingState',
        'outgoing' => 'onOutgoingState',
        'run' => 'run',
    ];

    /**
     * @param Parser $yamlParser
     *
     * @return self
     */
    public function setYamlParser(Parser $yamlParser): ScenarioYamlBuilder
    {
        $this->yamlParser = $yamlParser;

        return $this;
    }

    /**
     * @param string $yamlContent
     *
     * @return array
     */
    private function parseYaml(string $yamlContent): array
    {
        return $this->yamlParser->parse($yamlContent);
    }

    /**
     * To parse options, detect parameters and replace them by parameter.
     *
     * @param $optionValues
     */
    private function parseParameter(&$optionValues)
    {
        if (!\is_callable($optionValues) && !empty($optionValues)) {
            if (\is_array($optionValues) && '$' === $optionValues[0][0]) {
                if (isset($this->parameters[$optionValues[0]])) {
                    $optionValues[0] = $this->parameters[$optionValues[0]];
                }
            } elseif (\is_string($optionValues) && '$' === $optionValues[0]) {
                if (isset($this->parameters[$optionValues])) {
                    $optionValues = $this->parameters[$optionValues];
                }
            }
        }
    }

    /**
     * @param array $scenario
     *
     * @return ScenarioYamlBuilder
     */
    private function configureBuilder(array $scenario): ScenarioYamlBuilder
    {
        foreach ($scenario as &$options) {
            foreach ($options as $optionName => $optionValues) {
                if (isset($this->yamlOptionsMap[$optionName])) {
                    $methodName = $this->yamlOptionsMap[$optionName];
                    if ('run' != $methodName) {
                        foreach ((array) $optionValues as $optionValue) {
                            $this->{$methodName}($optionValue);
                        }
                    } else {
                        if (!\is_callable($optionValues)) {
                            $this->parseParameter($optionValues);
                        }

                        $this->run($optionValues);
                    }
                } else {
                    throw new \RuntimeException('Unknow option '.$optionName);
                }
            }
        }

        return $this;
    }

    /**
     * To register a parameter to use during yaml parsing.
     *
     * @param string $parameterName
     * @param $object
     *
     * @return ScenarioYamlBuilder
     */
    public function setParameter(string $parameterName, $object): ScenarioYamlBuilder
    {
        $this->parameters['$'.$parameterName] = $object;

        return $this;
    }

    /**
     * To transform a yaml scenario to native scenario.
     *
     * @param string $scenario
     *
     * @return ScenarioYamlBuilder
     */
    public function loadScenario(string $scenario): ScenarioYamlBuilder
    {
        $this->yamlScenario = $scenario;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function build(ScenarioInterface $scenario): ScenarioInterface
    {
        $this->configureBuilder(
            $this->parseYaml(
                $this->yamlScenario
            )
        );

        return parent::build($scenario);
    }
}
