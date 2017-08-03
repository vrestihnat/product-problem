<?php

interface IProductCache {

    /**
     * @param string $key
     * @return array
     */
    public function find($key);

    /**
     * @param string $key
     * @param array $val
     */
    public function set($key, $val);
}
