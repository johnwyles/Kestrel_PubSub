<?php

// FOO

/**
 * Kestrel_PubSub: A very simple Publisher / Subscriber implementation
 *
 * @category Kestrel
 * @package Kestrel_PubSub
 * @author John Wyles <john@johnwyles.com>
 * @version Id:$
 */

/**
 * Kestrel_PubSub: Static class interface for the very simple Publisher / Subscriber pattern
 *
 * @package Kestrel_PubSub
 * @version $Id: $
 */
class Kestrel_PubSub
{
    /**
     * @var Kestrel_PubSub Singleton for the subscribed callbacks
     */
    protected static $_callbacks;

    /**
     * Publish to all subscribed callbacks of a subject
     *
     * @param string $subject The subject
     * @param array $arguments The arguments to pass to the subscribed callbacks of the subject
     * @return void
     */
    public static function publish($subject, $arguments=array())
    {
        if (!isset(self::$_callbacks[$subject])) {
            throw new Kestrel_PubSub_Exception('The subject [' . $subject . '] has not been setup');
        }

        foreach(self::$_callbacks[$subject] as $callback) {
            call_user_func_array($callback, $arguments);
        }
    }

    /**
     * Subscribe an subscribe to a particular subject
     *
     * @param string $subject The subject to subscribe to
     * @param string|object $motif The callback target for the subject (either a function or an object)
     * @param null|string $method The callback method (non-static) to call on publish
     * @return void
     */
    public static function subscribe($subject, $target, $method=null)
    {
        if (empty(self::$_callbacks[$subject])) {
            self::$_callbacks[$subject] = array();
        }

        $callback = $target;
        if (!empty($method)) {
            $callback = array($target, $method);
        }

        // Enforce subscription of only one callback
        $callbackIndex = array_search($callback, self::$_callbacks);
        if ($callbackIndex !== false) {
            return;
        }

        array_push(self::$_callbacks[$subject], $callback);
    }

    /**
     * Unsubscribe an object from a particular subject
     *
     * @param string $subject The subject to unsubscribe the 
     * @param string|object $target The subscribed target to unscribe from a particular subject
     * @param null|string $method The method to invoke on the target
     * @return void
     */
    public static function unsubscribe($subject, $target, $method=null)
    {
        if (!isset(self::$_callbacks[$subject])) {
            throw new Kestrel_PubSub_Exception('The subject [' . $subject . '] has not been setup');
        }
        
        $callback = $target;
        if (!empty($method)) {
            $callback = array($target, $method);
        }
        
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
     * @param string $subject The subject
     * @return void
     */
    public static function removeSubscribers($subject)
    {
        unset(self::$_callbacks[$subject]);
    }

    /**
     * Get all of the subjects
     *
     * @return array The subjects
     */
    public static function getAllSubjects()
    {
        return array_keys(self::$_callbacks);
    }

    /**
     * Get all of the subject subscribers
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
