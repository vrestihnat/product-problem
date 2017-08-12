<?php

interface IProductDatabaseAdapter {

    /**
     * @param string $id
     * @return array
     */
    public function find($id);
}
