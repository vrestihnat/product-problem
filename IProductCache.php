<?php

interface IProductCache {

    /**
     * @param string $key
     * @return string
     */
    public function find($key);

    /**
     * 
     * @param string $key
     * @param string $val
     */
    public function set($key, $val);
}
