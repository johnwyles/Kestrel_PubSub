<?php
/**
 * Kestrel_PubSub: Test helper for Kestrel_PubSub
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @subpackage Test
 * @author John Wyles <john@johnwyles.com>
 */

/**
 * Class helper for Kestrel_PubSub
 *
 * @package Kestrel_PubSub
 * @subpackage Test
 * @version $Id: $
 */
class Kestrel_PubSub_Test extends Kestrel_PubSub
{
    /**
     * Test method foo
     *
     * @return true
     */
    public function foo()
    {
        return true;
    }

    /**
     * Static test method bar
     *
     * @return true
     */
    public static function bar()
    {
        return true;
    }

    /**
     * Test method baz
     *
     * @return array 
     */
    public function baz($argumentOne, $argumentTwo)
    {
        return array($argumentOne, $argumentTwo);
    }
}
