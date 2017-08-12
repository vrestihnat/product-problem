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
     * Prida hit do souboru. 
     * kazdy hit prida do souboru def. klicem prave jeden znak o velikost 1B,
     * pocet hitu je tedy roven velikosti souboru
     * pro ziskani csv 10-ti nejnavstevovanejsich produktu lze napr. pouzit nasledujici bash prikaz
     * ls -lS | tail -n +2 | head -n 10 | awk '{print $9,$5}' | sed -e 's/\s\+/,/g'
     * mozna, ze by pro pripsani jen stacilo "echo '+' >> $filename" 
     * @param string $key
     * @throws Exception unable to open file
     */
    public function hit($key) {
	$filename = $this->path . $key;
	if (file_put_contents($filename, '+', FILE_APPEND | LOCK_EX) === false) {
	    throw new \Exception('unable to open file');
	}
    }

}
