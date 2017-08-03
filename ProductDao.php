<?php

class ProductDao implements IProductDao {

    /**
     * @var IProductDatabaseManager 
     */
    private $dbManager;

    /**
     *
     * @var IProductCache 
     */
    private $cache;

    /**
     * 
     * @param IProductDatabaseManager $dbManager
     * @param IProductCache $cache
     */
    public function __construct(IProductDatabaseManager $dbManager, IProductCache $cache) {
	$this->dbManager = $dbManager;
	$this->cache = $cache;
    }

    /**
     * @param string $id
     * @return array
     */
    public function find($id) {
	$prdct = $this->cache->find($id);
	if (!($prdct && is_array($prdct))) {
	    $prdct = $this->dbManager->find($id);
	    $this->cache->set($id, $prdct);
	}
	return $prdct;
    }

}
