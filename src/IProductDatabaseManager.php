<?php

interface IProductDatabaseManager {

    /**
     * @param string $id
     * @return array
     * @throws Exception database driver not set
     */
    public function find($id);
}
