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
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;

/**
 * Class ScenarioYamlBuilder
 *
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
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var Filesystem
     */
    private $filesystem;

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
     * @param array $scenario
     * @return ScenarioYamlBuilder
     */
    protected function configureBuilder(array &$scenario): ScenarioYamlBuilder
    {
        foreach ($scenario as $scenarioName=>&$options) {
            foreach ($options as $optionName=>$optionValues) {
                if (isset($this->yamlOptionsMap[$optionName])) {
                    $methodName = $this->yamlOptionsMap[$optionName];
                    foreach ((array) $optionValues as $optionValue) {
                        $this->{$methodName}($optionValue);
                    }
                } else {
                    throw new \RuntimeException('Unknow option '.$optionName);
                }
            }
        }
    }

    /**
     * @param string $fileName
     * @return ScenarioYamlBuilder
     */
    public function loadScenario(\string $fileName)
    {
        return $this->configureBuilder(
            $this->parseYaml(
                $this->getScenarioContent($fileName)
            )
        );
    }
}