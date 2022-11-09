<?php

namespace CoddTech\Bap;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Log
 *
 * @method static void emergency(string $message, array $context = array())
 * @method static void alert(string $message, array $context = array())
 * @method static void critical(string $message, array $context = array())
 * @method static void error(string $message, array $context = array())
 * @method static void warning(string $message, array $context = array())
 * @method static void notice(string $message, array $context = array())
 * @method static void info(string $message, array $context = array())
 * @method static void debug(string $message, array $context = array())
 */
class Log
{
    /**
     * Logger instance
     *
     * @var LoggerInterface
     */
    protected static $logger;

    public static function initialize(LoggerInterface $logger = null)
    {
        self::$logger = $logger ?: new NullLogger();
    }

    /**
     * Handle any logging method call.
     *
     * @param string $name
     * @param array  $arguments
     */
    public static function __callStatic($name, array $arguments)
    {
        if (self::$logger === null)
            return;

        call_user_func_array(array(self::$logger, $name), $arguments);
    }
}
