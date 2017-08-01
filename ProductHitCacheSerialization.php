<?php

class ProductHitCacheSerialization implements IProductHitCache {

    /**
     * soubor pro serializaci
     * @var string  
     */
    private $filename = './counters';

    /**
     * FW zajisti, ze je nazev souboru pro ulozeni hitu z konfig. souboru predana konstruktorem
     * @param string $filename
     */
    public function __construct($filename) {
        $this->filename = $filename;
    }

    /**
     * Prida hit do pole, 
     * ktere je serializovano na FS
     * @param string $key
     * @throws Exception unable to open file
     */
    public function hit($key) {
        $filename = $this->filename;
        if (!($output = fopen($filename, 'a+'))) {
            throw new \Exception('Nelze otevrit meta soubor.');
        }
        flock($output, LOCK_EX); //exkluzivni zamek, ostatni procesy musi pro cteni a zapis tohoto souboru cekat na uvolneni 
        $content = file_get_contents($filename);
        if (!($content !== false && ($source = unserialize($content)))) {
            $source = [];
        }
        $insert = true;
        foreach ($source as $k => $hit) {
            if ($k == $key) {
                $insert = false;
                $source[$k] += 1;
            }
        }
        if ($insert) { //pokud se klic nenasel, pridame ho
            $source[$key] = 1;
        }
        fseek($output, 0);
        ftruncate($output, 0);
        fwrite($output, serialize($source));
        fclose($output);
    }

}
