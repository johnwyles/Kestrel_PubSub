<?php
/**
 * Kestrel_PubSub: All Tests
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @subpackage Test
 * @author John Wyles <john@johnwyles.com>
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kestrel_AllTests::main');
}

/**
* Test helper
*/
require_once dirname(__FILE__) . '/../TestHelper.php';

require_once 'PubSubTest.php';

/**
 * Kestrel_PubSub: All Tests
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @subpackage Test
 * @version $Id: $
 */
class Kestrel_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kestrel - All Tests');

        $suite->addTestSuite('Kestrel_PubSubTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kestrel_AllTests::main') {
    Kestrel_AllTests::main();
}
