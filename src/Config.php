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
    static $config;

    /**
     * Set method.
     *
     * @param string $index
     * @param string $value
     */
    static public function set($index, $value)
    {
        self::$config[$index] = $value;
    }

    /**
     * Set method.
     *
     * @param string $index
     * @return mixed
     */
    static public function get($index)
    {
        return self::$config[$index];
    }

    /**
     * Load method.
     *
     * @param array $array
     */
    static public function load(array $array)
    {
        self::$config = $array;
    }
}