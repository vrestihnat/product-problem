<?php

interface IProductHitCache {

    /**
     * @param string $key
     */
    public function hit($key);
}

