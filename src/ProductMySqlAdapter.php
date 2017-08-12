<?php

class ProductMySqlAdapter implements IProductDatabaseAdapter {

    /**
     *
     * @var IMySQLDriver 
     */
    private $driver;

    /**
     * 
     * @param IMySQLDriver $driver
     */
    public function __construct(IMySQLDriver $driver) {
	$this->driver = $driver;
    }

    /**
     * 
     * @param type $id
     * @return array
     */
    public function find($id) {
	return $this->driver->findProduct($id);
    }

}
