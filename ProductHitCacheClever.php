<?php

class ProductHitCacheClever implements IProductHitCache {

    /**
     * cesta k ulozisti
     * @var string  
     */
    private $path = './';

    /**
     * FW zajisti, ze je cesta k ulozisti z konfig. souboru predana konstruktorem
     * @param string $path
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * Prida hit do pole, 
     * kazdy hit prida do souboru def. klicem prave jeden znak o velikost 1B,
     * pocet hitu je tedy roven velikosti souboru
     * @param string $key
     * @throws Exception unable to open file
     */
    public function hit($key) {
        $filename = $this->path . $key;
        if (file_put_contents($filename, '+', FILE_APPEND | LOCK_EX) === false) {
            throw new \Exception('Nelze otevrit meta soubor.');
        }
    }
    /**
     * ziskani stat
     * ls -lS | tail -n +2 |  awk '{print $9,$5}'  | head -n 5|sed -e 's/\s\+/,/g'
     */

}
