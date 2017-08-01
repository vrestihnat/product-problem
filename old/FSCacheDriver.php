<?php

class FSCacheDriver implements IMyCacheDriver {

    const COUNTER_NAME = 'counters.csv';

    /**
     *
     * @var string  
     */
    private $path = './';

    /**
     * 
     * @param string $path
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * @param string $key
     * @return string
     */
    public function find($key) {
        if (!$key) {
            return '';
        } else if (!$res = file_get_contents($this->path . $key)) {
            return '';
        }
        return $res;
    }

    /**
     * @param string $key
     * @param string $val
     * @return bool
     */
    public function set($key, $val) {

        return file_put_contents($this->path . $key, $val);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function incry($key) {
        $output = fopen($this->path . 'tmp_' . self::COUNTER_NAME, 'w');
        $input = fopen($this->path . self::COUNTER_NAME, 'r');
        $insert = true;
        while (($data = fgetcsv($input)) !== false) {
            if ($data[0] == $key) {
                $insert = false;
                $data[1] += 1;
            }
            fputcsv($output, $data);
        }
        if ($insert) {
            $data = [$key, 1];
            fputcsv($output, $data);
        }
        fclose($input);
        fclose($output);
        unlink($this->path . self::COUNTER_NAME);
        return rename($this->path . 'tmp_' . self::COUNTER_NAME, $this->path . self::COUNTER_NAME);
    }

}
