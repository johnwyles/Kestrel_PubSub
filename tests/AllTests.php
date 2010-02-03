<?php
/**
 * Kestrel
 *
 * @category Kestrel
 * @package Kestrel
 * @subpackage Test
 * @author John Wyles <john@johnwyles.com>
 * @version $Id: $
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}

/**
* Test helper
*/
require_once dirname(__FILE__) . '/TestHelper.php';

/**
* @see Kestrel_AllTests
*/
require_once 'Kestrel/AllTests.php';

/**
 * Kestrel: AllTests
 *
 * @category Kestrel
 * @package Kestrel
 * @subpackage Test
 * @version $Id: $
 */
class AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite(), array());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kestrel');

        $suite->addTest(Kestrel_AllTests::suite());

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}
