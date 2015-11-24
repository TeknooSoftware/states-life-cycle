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

namespace Teknoo\States\LifeCycle\Scenario;

use Gaufrette\Filesystem;
use Symfony\Component\Yaml\Parser;

/**
 * Class ScenarioYamlBuilder
 * Another implementation of scenario builder to allow developper to create scenarii from YAML files
 * about stated class instances.
 * A scenario can accept several conditions : each condition must be validated to execute the scenario. *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ScenarioYamlBuilder extends ScenarioBuilder
{
    /**
     * YAML parser to read the scenario
     * @var Parser
     */
    private $yamlParser;

    /**
     * To read scenario file
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $yamlScenario;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * To list options, in yaml, correspondence with builder's methods
     * @var array
     */
    protected $yamlOptionsMap = [
        'when' => 'when',
        'class' => 'towardStatedClass',
        'notIn' => 'ifNotInState',
        'in' => 'ifInState',
        'incoming' => 'onIncomingState',
        'outgoing' => 'onOutgoingState',
        'run' => 'run'
    ];

    /**
     * @param Parser $yamlParser
     * @return self
     */
    public function setYamlParser($yamlParser): ScenarioYamlBuilder
    {
        $this->yamlParser = $yamlParser;

        return $this;
    }

    /**
     * @param Filesystem $filesystem
     * @return self
     */
    public function setFilesystem($filesystem): ScenarioYamlBuilder
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * @param string $fileName
     * @return string
     */
    protected function getScenarioContent(\string $fileName): \string
    {
        return $this->filesystem->read($fileName);
    }

    /**
     * @param string $yamlContent
     * @return array
     */
    protected function parseYaml(\string $yamlContent): array
    {
        return $this->yamlParser->parse($yamlContent);
    }

    /**
     * To parse options, detect parameters and replace them by parameter
     * @param $optionValues
     */
    protected function parseParameter(&$optionValues)
    {
        if (!is_callable($optionValues) && !empty($optionValues)) {
            if (is_array($optionValues) && '$' === $optionValues[0][0]) {
                if (isset($this->parameters[$optionValues[0]])) {
                    $optionValues[0] = $this->parameters[$optionValues[0]];
                }
            } elseif (is_string($optionValues) && '$' === $optionValues[0]) {
                if (isset($this->parameters[$optionValues])) {
                    $optionValues = $this->parameters[$optionValues];
                }
            }
        }
    }

    /**
     * @param array $scenario
     * @return ScenarioYamlBuilder
     */
    protected function configureBuilder(array &$scenario): ScenarioYamlBuilder
    {
        foreach ($scenario as $scenarioName=>&$options) {
            foreach ($options as $optionName=>$optionValues) {
                if (isset($this->yamlOptionsMap[$optionName])) {
                    $methodName = $this->yamlOptionsMap[$optionName];
                    if ('run' != $methodName) {
                        foreach ((array)$optionValues as $optionValue) {
                            $this->{$methodName}($optionValue);
                        }
                    } else {
                        if (!is_callable($optionValues)) {
                            $this->parseParameter($optionValues);
                        }

                        $this->run($optionValues);
                    }
                } else {
                    throw new \RuntimeException('Unknow option '.$optionName);
                }
            }
        }
    }

    /**
     * To register a parameter to use during yaml parsing
     * @param string $parameterName
     * @param $object
     * @return ScenarioYamlBuilder
     */
    public function setParameter(\string $parameterName, $object): ScenarioYamlBuilder
    {
        $this->parameters['@'.$parameterName] = $object;

        return $this;
    }

    /**
     * To transform a yaml scenario to native scenario
     * @param string $fileName
     * @return ScenarioYamlBuilder
     */
    public function loadScenario(\string $fileName): ScenarioYamlBuilder
    {
        $this->yamlScenario = $fileName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function build(ScenarioInterface $scenario): ScenarioInterface
    {

        return $this->configureBuilder(
            $this->parseYaml(
                $this->getScenarioContent($this->yamlScenario)
            )
        );

        return parent::build($scenario);
    }
}
