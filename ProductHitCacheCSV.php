<?php

class ProductHitCacheCSV implements IProductHitCache {

    /**
     * csv soubor pro ulozeni
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
     * Prida hit do CSV:
     * vytvorime docasny soubor, do ktereho kopirujeme radky ze zdrojoveho souboru,
     * pokud narazime na klic, zvysime hodnotu, jinak klic pridame,
     * nakonec smazeme zdroj a prejmenujeme docasny soubor na zdrojovy
     * @param string $key
     * @throws Exception unable to open meta file
     * @throws Exception unable to create meta file
     */
    public function hit($key) {
        $filename = $this->filename;
        $temp = $filename . '.tmp';
        if (!file_exists($filename) && !touch($filename)) { //osetreni existence zdrojoveho souboru
            throw new \Exception('Nelze vytvorit meta soubor.');
        }
        if (!($output = fopen($temp, 'a+'))) { //otevreni docasneho souboru
            throw new \Exception('Nelze otevrit meta soubor.');
        }
        flock($output, LOCK_EX); //exkluzivni zamek, ostatni procesy musi pro cteni a zapis tohoto souboru cekat na uvolneni 
        fseek($output, 0);
        ftruncate($output, 0);
        if (!($input = fopen($filename, 'r'))) { //otevreni zdrojoveho souboru
            throw new \Exception('Nelze otevrit meta soubor.');
        }
        $insert = true;
        while (($data = fgetcsv($input)) !== false) {
            if ($data[0] == $key) {
                $insert = false;
                $data[1] += 1;
            }
            fputcsv($output, $data);
        }
        if ($insert) { //pokud se klic ve zdrojovem souboru nenasel, pridame ho
            $data = [$key, 1];
            fputcsv($output, $data);
        }
        fclose($input);
        fclose($output);
        unlink($filename); //smazani zdrojoveho souboru
        rename($temp, $filename); //prejmenovani docasneho na zdrojovy soubor
    }

}
