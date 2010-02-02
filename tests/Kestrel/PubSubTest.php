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
require_once dirname(__FILE__) . '/../TestHelper.php';

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/TestHelper.php';

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
    
    public static function main()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kestrel_PubSubTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp()
    {
        Kestrel_PubSub::removeAllSubscribers();
        $this->_test = new Kestrel_PubSub_Test();
    }

    public function tearDown()
    {
        unset($this->_test);
    }

    /**
     * @covers Kestrel_PubSub::getAllSubjectSubscribers
     */
    public function testNoSubscribers()
    {
        $subscriptions = Kestrel_PubSub::getAllSubjectSubscribers();
        $this->assertTrue(empty($subscriptions));
    }

    /**
     * @covers Kestrel_PubSub::getAllSubjects
     */
    public function testNoSubjects()
    {
        $subscriptions = Kestrel_PubSub::getAllSubjects();
        $this->assertTrue(empty($subscriptions));
    }

    /**
     * @covers Kestrel_PubSub::getDefaultProfile
     * @covers Kestrel_PubSub::setDefaultProfile
     */
    public function testSubscribeObjectSubscribesToSubject()
    {
        Kestrel_PubSub::subscribe('test', $this->_test, 'bar');
        $testSubscribers = Kestrel_PubSub::getSubscribers('test');
        $this->assertEquals($testSubscribers, $this->_test);
    }
}

// Call Kestrel_PubSubTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'Kestrel_PubSubTest::main') {
    Kestrel_PubSubTest::main();
}
