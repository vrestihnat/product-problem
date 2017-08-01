<?php

class ResourceFactory {

    public function create($config) {

        $sqlDriver = (new SQLDriverFactory())->create($config);
        return new Resource($sqlDriver);
    }

}
