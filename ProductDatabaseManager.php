<?php

class ProductDatabaseManager implements IProductDatabase {

    /**
     * @var object 
     */
    private $driver = '';

    /**
     * 
     * @param object $driver
     */
    public function __construct($driver) {
	$this->driver = $driver;
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception database driver not set
     */
    public function find($id) {

	switch (true) {
	    case $this->driver instanceof IElasticSearchDriver:
		$adapter = new ProductESAdapter($this->driver);
		break;
	    case $this->driver instanceof IMySQLDriver:
		$adapter = new ProductMySqlAdapter($this->driver);
		break;
	    default:
		throw new Exception('database driver not set');
	}

	return $adapter->find($id);
    }

}
