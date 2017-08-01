<?php

interface IMyCacheDriver {

    /**
     * @param string $key
     * @return string
     */
    public function find($key);

    /**
     * 
     * @param string $key
     * @param string $val
     * @return bool
     */
    public function set($key, $val);


    /**
     * @param string $key
     * @return bool
     */
    public function incry($key);
}
