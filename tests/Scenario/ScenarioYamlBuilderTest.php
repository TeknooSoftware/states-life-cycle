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

namespace Teknoo\Tests\States\LifeCycle\Scenario;

use Gaufrette\Filesystem;
use Symfony\Component\Yaml\Parser;
use Teknoo\States\LifeCycle\Observing\ObservedInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ScenarioYamlBuilderTest.
 *
 * @covers \Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/states Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class ScenarioYamlBuilderTest extends AbstractScenarioBuilderTest
{
    /**
     * @var Tokenizer
     */
    protected $tokenizer;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Tokenizer
     */
    public function getTokenizerMock()
    {
        if (!$this->tokenizer instanceof Tokenizer) {
            $this->tokenizer = $this->createMock(Tokenizer::class);
        }

        return $this->tokenizer;
    }

    /**
     * @return ScenarioYamlBuilder
     */
    public function build()
    {
        return new ScenarioYamlBuilder(
            $this->getTokenizerMock()
        );
    }

    public function testWhenValue()
    {
        $service = $this->build();
        self::assertEquals($service, $service->when('eventName'));
        self::assertEquals(['eventName'], $service->getEventNamesList());
    }

    public function testTowardStatedClassValue()
    {
        $service = $this->build();
        $this->getTokenizerMock()->expects(self::once())->method('getStatedClassNameToken')->with('my\Stated\CustomClass')->willReturn('my_stated_customclass');
        self::assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
        self::assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        self::assertEquals('my\Stated\CustomClass', $service->getStatedClassName());
    }

    public function testTowardObservedValue()
    {
        /**
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->createMock(ObservedInterface::class);
        $acme = new Acme();
        $observed->expects(self::once())->method('getObject')->willReturn($acme);
        $service = $this->build();
        $this->getTokenizerMock()->expects(self::once())->method('getStatedClassInstanceToken')->with($acme)->willReturn('my_stated_customclass');
        self::assertEquals($service, $service->towardObserved($observed));
        self::assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        self::assertEquals($observed, $service->getObserved());
    }

    public function testIfInStateValueValue()
    {
        $service = $this->build();
        self::assertEquals($service, $service->ifInState('stateName'));
        self::assertEquals(['stateName'], $service->getNeededStatesList());
    }

    public function testIfNotInStateValueValue()
    {
        $service = $this->build();
        self::assertEquals($service, $service->ifNotInState('stateName'));
        self::assertEquals(['stateName'], $service->getForbiddenStatesList());
    }

    public function testOnIncomingStateValue()
    {
        $service = $this->build();
        self::assertEquals($service, $service->onIncomingState('stateName'));
        self::assertEquals(['stateName'], $service->getNeededIncomingStatesList());
    }

    public function testOnOutgoingStateValue()
    {
        $service = $this->build();
        self::assertEquals($service, $service->onOutgoingState('stateName'));
        self::assertEquals(['stateName'], $service->getNeededOutgoingStatesList());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetYamlParserBadParser()
    {
        $this->build()->setYamlParser(null);
    }

    public function testSetYamlParser()
    {
        $builder = $this->build();
        self::assertEquals($builder, $builder->setYamlParser($this->createMock('Symfony\Component\Yaml\Parser')));
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetFilesystemBadFilesystem()
    {
        $this->build()->setFilesystem(null);
    }

    public function testSetFilesystem()
    {
        $builder = $this->build();
        self::assertEquals($builder, $builder->setFilesystem($this->createMock(Filesystem::class, [], [], '', false)));
    }

    /**
     * @expectedException \TypeError
     */
    public function testLoadScenarioBadArg()
    {
        $this->build()->loadScenario(null);
    }

    public function testLoadScenario()
    {
        $builder = $this->build();
        self::assertEquals($builder, $builder->loadScenario('fooBar'));
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetParameterBadArg()
    {
        $this->build()->setParameter(null, new \stdClass());
    }

    public function testSetParameter()
    {
        $builder = $this->build();
        self::assertEquals($builder, $builder->setParameter('fooBar', new \stdClass()));
    }

    public function testBuild()
    {
        $builder = $this->build();
        /**
         * @var ScenarioInterface
         */
        $scenario = $this->createMock(ScenarioInterface::class);
        $scenario->expects(self::once())->method('configure')->with($builder)->willReturnSelf();

        $yamlContent = 'scenario4:
  class: \'demo\NonExistant\Class\'
  incoming: [\'State3\']
  outgoing: [\'State2\']
  notIn: [\'StateDefault\']
  run: [\'$instanceB\', \'switchToStateDefault\']
';

        $filesystem = $this->createMock(Filesystem::class, [], [], '', false);
        $builder->setFilesystem($filesystem);
        $filesystem->expects(self::once())
            ->method('read')
            ->with('file/scenario.yaml')
            ->willReturn($yamlContent);

        $parser = $this->createMock(Parser::class);
        $builder->setYamlParser($parser);
        $parser->expects(self::once())
            ->method('parse')
            ->with($yamlContent)
            ->willReturn([
                'scenario4' => [
                    'class' => 'demo\NonExistant\Class',
                    'incoming' => ['State3'],
                    'outgoing' => ['State2'],
                    'notIn' => ['StateDefault'],
                    'run' => ['$instanceB', 'switchToStateDefault'],
                ],
            ]);

        $builder->setParameter('instanceB', new class() {
            public function switchToStateDefault()
            {
                return true;
            }
        });

        $builder->loadScenario('file/scenario.yaml');
        self::assertInstanceOf(
            ScenarioInterface::class,
            $builder->build(
                $scenario
            )
        );
    }
}
