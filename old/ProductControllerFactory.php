<?php

class ProductControllerFactory {

    /**
     * 
     * @param array $config
     * @return ProductController
     */
    public function create($config) {
        if(isset($config['db_ESConnector']) && $config['db_ESConnector']['enable'] === true){
            $db = (new ElasticSearchDriverFactory())->create($config);
        } else {
            $db = (new ResourceFactory())->create($config);
        }
        $driverClassFactory = $config['cacheDriver'];
        try {
            $cache = (new $driverClassFactory())->create($config);
        } catch (\Exception $e) {
            throw new Exception('cacheDriver property is missing in config or cache driver implementation doesn\'t exists');
        }
        return new ProductController($db, $cache);
    }

}
