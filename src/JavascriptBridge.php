<?php

/*
 * This file is part of Arrounded
 *
 * (c) Madewithlove <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arrounded\Assets;

use Illuminate\Contracts\Support\Jsonable;

class JavascriptBridge
{
    /**
     * A module to namespace the variables in.
     *
     * @var string
     */
    protected static $namespace;

    /**
     * And array of data to pass to Javascript.
     *
     * @var array
     */
    protected static $data = [];

    /**
     * @param string $namespace
     */
    public static function setNamespace($namespace)
    {
        self::$namespace = $namespace;
    }

    //////////////////////////////////////////////////////////////////////
    //////////////////////////////// DATA ////////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Add data to pass.
     *
     * @param array $data
     */
    public static function add(array $data)
    {
        // Filter and merge data
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });
        $data = array_merge(static::$data, $data);

        static::$data = $data;
    }

    /**
     * Purge the held data.
     */
    public static function purge()
    {
        static::$data = [];
    }

    /**
     * Get the data.
     *
     * @return array
     */
    public static function getData()
    {
        return static::$data;
    }

    /**
     * Render to JS.
     *
     * @return string
     */
    public static function render()
    {
        $rendered = '';
        if (static::$namespace) {
            $rendered .= "\tvar ".static::$namespace.' = {};'.PHP_EOL;
        }

        foreach (static::$data as $key => $value) {
            $encoded = $value instanceof Jsonable ? $value->toJson() : json_encode($value);
            $key = static::$namespace ? static::$namespace.'.'.$key : 'var '.$key;
            $rendered .= sprintf("\t%s = %s;".PHP_EOL, $key, $encoded);
        }

        return $rendered;
    }
}
