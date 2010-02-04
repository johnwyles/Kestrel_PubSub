<?php
/**
* Kestrel_PubSub: Tests
*
* @category Kestrel
* @package Kestrel_PubSub
* @subpackage Test
* @author John Wyles <john@johnwyles.com>
*/

// Call Kestrel_PubSubTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kestrel_PubSubTest::main');
}

/**
 * Test helper
 */
require_once dirname(dirname(__FILE__)) . '/TestHelper.php';

/**
 * Kestrel_PubSub
 */
require_once 'Kestrel/PubSub.php';

/**
 * Kestrel_PubSub: Tests
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @subpackage Test
 * @version $Id: $
 */
class Kestrel_PubSubTest extends PHPUnit_Framework_TestCase
{
    protected $_test;

    protected static $_minimalTargetRequired = false;

    public static function main()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kestrel_PubSubTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp()
    {
        Kestrel_PubSub::removeAllSubjectSubscribers();

        if (self::$_minimalTargetRequired === false) {
            require_once(dirname(__FILE__) . '/PubSub/_files/MinimalTarget.php');
            self::$_minimalTargetRequired = true;
        }
        
        $this->_test = new Kestrel_PubSub_MinimalTarget();
    }

    public function tearDown()
    {
        unset($this->_test);
    }

    /**
     * @covers Kestrel_PubSub::getAllSubjects
     */
    public function testGetAllSubjects()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        $subjects = Kestrel_PubSub::getAllSubjects();
        $subject = array_shift($subjects);
        $this->assertEquals('test', $subject);
    }

    /**
     * @covers Kestrel_PubSub::getAllSubjectSubscribers
     */
    public function testGetAllSubjectSubscribers()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        $subscribers = Kestrel_PubSub::getAllSubjectSubscribers();
        $target = array_shift(array_shift($subscribers['test']));
        $this->assertEquals($target, $this->_test);
    }

    /**
     * @covers Kestrel_PubSub::removeAllSubjectSubscribers
     */
    public function testRemoveAllSubjectSubscribers()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        Kestrel_PubSub::removeAllSubjectSubscribers('test');
        $subscribers = Kestrel_PubSub::getAllSubjectSubscribers();
        $this->assertTrue(empty($subscribers));
    }

    /**
     * @covers Kestrel_PubSub::getSubscribers
     */
    public function testGetSubscribers()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        $subscribers = Kestrel_PubSub::getSubscribers('test');
        $target = array_shift(array_shift($subscribers));
        $this->assertEquals($target, $this->_test);
    }

    /**
     * @covers Kestrel_PubSub::subscribe
     */
    public function testSubscribe()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        $testSubscribers = Kestrel_PubSub::getSubscribers('test');
        $target = array_shift(array_shift($testSubscribers));
        $this->assertEquals($target, $this->_test);
    }

    /**
     * @covers Kestrel_PubSub::removeSubscribers
     */
    public function testRemoveSubscribers()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        Kestrel_PubSub::removeSubscribers('test');
        $testSubscribers = Kestrel_PubSub::getSubscribers('test');
        $this->assertTrue(empty($testSubscribers));
    }

    /**
     * @covers Kestrel_PubSub::unsubscribe
     */
    public function testUnsubscribe()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        Kestrel_PubSub::unsubscribe('test', $this->_test, 'foo');
        $testSubscribers = Kestrel_PubSub::getSubscribers('test');
        $this->assertTrue(empty($testSubscribers));
    }

    /**
     * @covers Kestrel_PubSub::publish
     */
    public function testPublish()
    {
        $message = array(1, 2);
        Kestrel_PubSub::subscribe('test', $this->_test, 'foo');
        Kestrel_PubSub::subscribe('test', 'Kestrel_PubSub_MinimalTarget', 'bar');
        Kestrel_PubSub::subscribe('test', 'Kestrel_PubSub_MinimalTarget::bat');
        Kestrel_PubSub::subscribe('test', $this->_test, 'baz');
        Kestrel_PubSub::publish('test', $message);
        $this->assertTrue(Kestrel_PubSub_MinimalTarget::$data['foo']);
        $this->assertTrue(Kestrel_PubSub_MinimalTarget::$data['bar']);
        $this->assertTrue(Kestrel_PubSub_MinimalTarget::$data['bat']);
        $this->assertEquals(Kestrel_PubSub_MinimalTarget::$data['baz'], $message);
    }
}

// Call Kestrel_PubSubTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'Kestrel_PubSubTest::main') {
    Kestrel_PubSubTest::main();
}
