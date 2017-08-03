<?php

class ProductCacheFS implements IProductCache {

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
     * Vraci v souboru ulozenou hodnotu na zaklade klice,
     * pokud soubor s nazvem klice neexistuje vraci prazdny retezec. 
     * @param string $key
     * @return array
     */
    public function find($key) {
	$res = '';
	$filename = $this->getFileName($key);
	if (file_exists($filename)) {
	    $res = unserialize(file_get_contents($filename)); //nacteni obsahu
	}
	return $res;
    }

    /**
     * Ulozi hodnotu do souboru def. klicem,
     * pokud ne vyhodi vyjimku
     * @param string $key
     * @param array $val
     * @throws Exception when failed to write cache file.
     */
    public function set($key, $val) {
	$filename = $this->getFileName($key);
	$str = serialize($val);
	//otevreni souboru pro zapis i cteni, pro cteni je to kvuli zamku
	if (!($fh = fopen($filename, 'a+'))) {
	    throw new \Exception('failed to write cache file');
	}
	flock($fh, LOCK_EX); //exkluzivni zamek, ostatni procesy musi pro cteni a zapis tohoto souboru cekat na uvolneni 
	fseek($fh, 0); //skok na zacatek souboru
	ftruncate($fh, 0); //oriznuti souboru
	if (fwrite($fh, $str) === false) {
	    throw new \Exception('failed to write cache file');
	}
	fclose($fh);
    }

    /**
     * Vraci nazev souboru vc. cesty. 
     * @param type $key
     * @return string
     * @throws Exception when key not found
     */
    private function getFileName($key) {
	if (!$key) {
	    throw new \Exception('key not found');
	}
//Pro jednoduchost predpokladam, ze ze vstupniho klice, pujde bez problemu vytvorit regularni nazev souboru.
//Jinak by se mohlo pouzit napr. md5($key).
	return $this->path . $key;
    }

}
