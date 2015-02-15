<?php namespace SlimBase;

/**
 * Interface iSession
 * @package SlimBase
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */

interface iSession
{

    public function has($key);

    public function get($key);

    public function set($key, $value);

    public function del($key);

}