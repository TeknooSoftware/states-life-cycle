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

use Teknoo\States\LifeCycle\Scenario\ScenarioInterface;
use Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder;
use Teknoo\States\LifeCycle\Tokenization\Tokenizer;
use Teknoo\Tests\States\LifeCycle\StatedClass\Support\Acme\Acme;

/**
 * Class ScenarioYamlBuilderTest.
 *
 * @covers Teknoo\States\LifeCycle\Scenario\ScenarioYamlBuilder
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
            $this->tokenizer = $this->createMock('Teknoo\States\LifeCycle\Tokenization\Tokenizer');
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
        $this->assertEquals($service, $service->when('eventName'));
        $this->assertEquals(['eventName'], $service->getEventNamesList());
    }

    public function testTowardStatedClassValue()
    {
        $service = $this->build();
        $this->getTokenizerMock()->expects($this->once())->method('getStatedClassNameToken')->with('my\Stated\CustomClass')->willReturn('my_stated_customclass');
        $this->assertEquals($service, $service->towardStatedClass('my\Stated\CustomClass'));
        $this->assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        $this->assertEquals('my\Stated\CustomClass', $service->getStatedClassName());
    }

    public function testTowardObservedValue()
    {
        /*
         * @var ObservedInterface|\PHPUnit_Framework_MockObject_MockObject
         */
        $observed = $this->createMock('Teknoo\States\LifeCycle\Observing\ObservedInterface');
        $acme = new Acme();
        $observed->expects($this->once())->method('getObject')->willReturn($acme);
        $service = $this->build();
        $this->getTokenizerMock()->expects($this->once())->method('getStatedClassInstanceToken')->with($acme)->willReturn('my_stated_customclass');
        $this->assertEquals($service, $service->towardObserved($observed));
        $this->assertEquals(['my_stated_customclass'], $service->getEventNamesList());
        $this->assertEquals($observed, $service->getObserved());
    }

    public function testIfInStateValueValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifInState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededStatesList());
    }

    public function testIfNotInStateValueValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->ifNotInState('stateName'));
        $this->assertEquals(['stateName'], $service->getForbiddenStatesList());
    }

    public function testOnIncomingStateValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onIncomingState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededIncomingStatesList());
    }

    public function testOnOutgoingStateValue()
    {
        $service = $this->build();
        $this->assertEquals($service, $service->onOutgoingState('stateName'));
        $this->assertEquals(['stateName'], $service->getNeededOutgoingStatesList());
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
        $this->assertEquals($builder, $builder->setYamlParser($this->createMock('Symfony\Component\Yaml\Parser')));
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
        $this->assertEquals($builder, $builder->setFilesystem($this->createMock('Gaufrette\Filesystem', [], [], '', false)));
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
        $this->assertEquals($builder, $builder->loadScenario('fooBar'));
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
        $this->assertEquals($builder, $builder->setParameter('fooBar', new \stdClass()));
    }

    public function testBuild()
    {
        $builder = $this->build();
        /**
         * @var ScenarioInterface
         */
        $scenario = $this->createMock('Teknoo\States\LifeCycle\Scenario\ScenarioInterface');
        $scenario->expects($this->once())->method('configure')->with($builder)->willReturnSelf();

        $yamlContent = 'scenario4:
  class: \'demo\NonExistant\Class\'
  incoming: [\'State3\']
  outgoing: [\'State2\']
  notIn: [\'StateDefault\']
  run: [\'$instanceB\', \'switchToStateDefault\']
';

        $filesystem = $this->createMock('Gaufrette\Filesystem', [], [], '', false);
        $builder->setFilesystem($filesystem);
        $filesystem->expects($this->once())
            ->method('read')
            ->with('file/scenario.yaml')
            ->willReturn($yamlContent);

        $parser = $this->createMock('Symfony\Component\Yaml\Parser');
        $builder->setYamlParser($parser);
        $parser->expects($this->once())
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

        $builder->setParameter('instanceB', new class()
        {
            public function switchToStateDefault()
            {
                return true;
            }
        });

        $builder->loadScenario('file/scenario.yaml');
        $this->assertInstanceOf(
            'Teknoo\States\LifeCycle\Scenario\ScenarioInterface',
            $builder->build(
                $scenario
            )
        );
    }
}
