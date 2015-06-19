<?php

/*
 * This file is part of Arrounded
 *
 * (c) Madewithlove <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('app_path')) {
    function app_path($path = null)
    {
        return __DIR__.'/../src/'.$path;
    }
}

if (!defined('public_path')) {
    function public_path($path = null)
    {
        return app_path($path);
    }
}
