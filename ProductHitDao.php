<?php

class ProducHitDao implements IProductHitDao {

    /**
     * @var IProductHitCache
     */
    private $driver;

    /**
     * 
     * @param IProductHitCache $driver
     */
    public function __construct(IProductHitCache $driver) {
	$this->driver = $driver;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function hit($id) {

	$this->driver->hit($id);
    }

}
