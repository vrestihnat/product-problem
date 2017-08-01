<?php

class Resource implements IElasticSearchDriver {

    /**
     *
     * @var IMySQLDriver 
     */
    private $sqldb;

    public function __construct(IMySQLDriver $sqldb) {
        $this->sqldb = $sqldb;
    }

    public function findById($id) {
        return $this->sqldb->findProduct($id);
    }

}
