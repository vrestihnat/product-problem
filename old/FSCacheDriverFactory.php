<?php

class FSCacheDriverFactory {

    const FSPATH = 'cacheFSPath';

    /**
     * 
     * @param array $config
     * @return FSCacheDriver
     */
    public function create($config) {
        $path = $config[self::FSPATH];
        return new FSCacheDriver($path);
    }

}
