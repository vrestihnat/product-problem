<?php

class ProductController {

    /**
     * @var IElasticSearchDriver 
     */
    private $db;

    /**
     * @var IMyCacheDriver 
     */
    private $cache;

    /**
     * @param IElasticSearchDriver $db
     * @param IMyCacheDriver $cache
     */
    public function __construct(IElasticSearchDriver $db, IMyCacheDriver $cache) {
        $this->db = $db;
        $this->cache = $cache;
    }

    /**
     * @param string $id
     * @return string
     */
    public function detail($id) {
        $prdct = $this->cache->find($id);
        if (!$prdct) {
            $prdct = json_encode($this->db->findById($id));
            $this->cache->set($id, $prdct);
        }
        $this->cache->incry($id);
        return $prdct;
    }

}
