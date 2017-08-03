<?php

class ProductController {

    /**
     * @var IProductDao
     */
    private $productDao;

    /**
     * @var IProductHitDao 
     */
    private $productHitDao;

    /**
     * @param IProductDao $productDao
     * @param IProductHitDao $productHitDao
     */
    public function __construct(IProductDao $productDao, IProductHitDao $productHitDao) {
	$this->productDao = $productDao;
	$this->productHitDao = $productHitDao;
    }

    /**
     * @param string $id
     * @return string
     */
    public function detail($id) {
	$prdct = json_encode($this->productDao->find($id)); // ziska produkt z uloziste
	$this->productHitDao->hit($id); // zaznamena zobrazeni stranky s detailem produktu
	return $prdct;
    }

}
