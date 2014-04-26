<?php

namespace Feedtags\ApplicationBundle\Tests;

use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

trait ProphecyTestTrait
{
    /**
     * @var Prophet
     */
    private $prophecy;

    protected function up()
    {
    }

    protected function down()
    {
    }

    final protected function setUp()
    {
        parent::setUp();

        $this->prophecy = new Prophet();

        $this->up();
    }

    final protected function tearDown()
    {
        $this->down();

        $this->prophecy->checkPredictions();

        parent::tearDown();
    }

    /**
     * @param  string $classOrInterface
     *
     * @return ObjectProphecy
     */
    protected function prophesize($classOrInterface)
    {
        return $this->prophecy->prophesize($classOrInterface);
    }

    /**
     * @param  string $classOrInterface
     *
     * @return object
     */
    protected function dummy($classOrInterface)
    {
        return $this->prophesize($classOrInterface)->reveal();
    }
}
