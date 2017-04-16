<?php

namespace Helsinque;

/**
 * Interface ValidatorsInterface.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com">
 */
abstract class Config
{
    /**
     * @var Array $config
     */
    private static $config;

    /**
     * Set method.
     *
     * @param string $index
     * @param string $value
     */
    public static function set($index, $value)
    {
        self::$config[$index] = $value;
    }

    /**
     * Set method.
     *
     * @param  string $index
     * @return mixed
     */
    public static function get($index)
    {
        return self::$config[$index];
    }

    /**
     * Load method.
     *
     * @param array $array
     */
    public static function load(array $array)
    {
        self::$config = $array;
    }
}
