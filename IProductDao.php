<?php

interface IProductDao {

    /**
     * @param string $id
     * @return array
     */
    public function find($id);
}
