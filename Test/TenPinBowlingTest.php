<?php
require 'TenPinBowling.php';

/**
 * Class TenPinBowlingTest
 */
class TenPinBowlingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var TenPinBowling
     */
    protected $_bowling;

    /**
     * @return array
     */
    public function bowlingScoreDataProvider()
    {
        return array(
            array('XXXXXXXXXXXX', 300),
            array('9-9-9-9-9-9-9-9-9-9-', 90),
            array('5/5/5/5/5/5/5/5/5/5/5', 150),
            array('3/4/1/XX4/9/X6/X33', 184),
            array('36158/174/X25361003', 91),
            array('----------', 0),
            array('', 0),
            array('81251381314252314051', 60),
        );
    }

    /**
     * @covers       TenPinBowling::scoreGame
     * @dataProvider bowlingScoreDataProvider
     */
    public function testScoreGame($rolls, $expectedScore)
    {
        $this->assertEquals($expectedScore, $this->_bowling->scoreGame($rolls), "Score should be $expectedScore");
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_bowling = new TenPinBowling;
    }
}
