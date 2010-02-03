<?php
/**
 * Kestrel_PubSub: A very simple Publish / Subscribe implementation
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @author John Wyles <john@johnwyles.com>
 * @version $Id: $
 */

/**
 * Kestrel_PubSub: Static class interface for the very simple Publish / Subscribe pattern
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @version $Id: $
 */
class Kestrel_PubSub
{
    /**
     * @var array Singleton for the subscribed callbacks
     */
    protected static $_callbacks = array();

    /**
     * Publish to all subscribed callbacks of a subject
     *
     * @param string $subject The subject to publish to
     * @param array $arguments The arguments to pass to the subscribed callbacks of the subject
     * @return void
     */
    public static function publish($subject, $arguments=array())
    {
        // Nothing is subscribed to the subject we would like to publish
        if (empty(self::$_callbacks[$subject])) {
            return;
        }

        // Publish to each of the subscribers of the subject
        foreach(self::$_callbacks[$subject] as $callback) {
            call_user_func_array($callback, $arguments);
        }
    }

    /**
     * Subscribe a target to a particular subject
     *
     * @param string $subject The subject to subscribe to
     * @param string|object $target The callback target for the subject (either a function or an object)
     * @param null|string $method The callback method to call on the target (null if target is static or a function)
     * @return void
     */
    public static function subscribe($subject, $target, $method=null)
    {
        // Initialize the subject
        if (empty(self::$_callbacks[$subject])) {
            self::$_callbacks[$subject] = array();
        }

        // Determine the callback
        $callback = $target;
        if (!empty($method)) {
            $callback = array($target, $method);
        }

        // Enforce subscription of only one callback
        $callbackIndex = array_search($callback, self::$_callbacks);
        if ($callbackIndex !== false) {
            return;
        }

        // Add the callback to the stack
        array_push(self::$_callbacks[$subject], $callback);
    }

    /**
     * Unsubscribe a target from a particular subject
     *
     * @param string $subject The subject to unsubscribe from
     * @param string|object $target The callback target for the subject (either a function or an object)
     * @param null|string $method The callback method to call on the target (null if target is static or a function)
     * @return void
     */
    public static function unsubscribe($subject, $target, $method=null)
    {
        // Nothing is subscribed to the subject we would like to publish
        if (empty(self::$_callbacks[$subject])) {
            return;
        }

        // Determine the callback
        $callback = $target;
        if (!empty($method)) {
            $callback = array($target, $method);
        }

        // If the callback exists in the subscribers for the subject remove it
        $subscriberIndex = array_search($callback, self::$_callbacks[$subject]);
        if ($subscriberIndex !== false) {
            unset(self::$_callbacks[$subject][$subscriberIndex]);
        }
    }

    /**
     * Get all of the subscribers for a particular subject
     *
     * @param string $subject The subject
     * @return array $_callbacks[$subject] The subscribers for a particular subject
     */
    public static function getSubscribers($subject)
    {
        if (!empty(self::$_callbacks[$subject])) {
            return self::$_callbacks[$subject]; 
        }

        return array();
    }

    /**
     * Remove the subscribers for a particular subject
     *
     * @param string $subject The subject to remove all subscribers from
     * @return void
     */
    public static function removeSubscribers($subject)
    {
        unset(self::$_callbacks[$subject]);
    }

    /**
     * Get all of the subjects
     *
     * @return array All subjects subscribed to
     */
    public static function getAllSubjects()
    {
        return array_keys(self::$_callbacks);
    }

    /**
     * Get all of the subjects subscribers
     *
     * @return array $_callbacks All subscribers for all subjects
     */
    public static function getAllSubjectSubscribers()
    {
        return self::$_callbacks;
    }

    /**
     * Remove all subscribers for all subjects
     *
     * @return void
     */
    public static function removeAllSubjectSubscribers()
    {
        self::$_callbacks = array();
    }
}
