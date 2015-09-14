<?php

namespace System\Library\Database;
defined('SYS_PATH') OR exit('No direct script access allowed');

class Lib_Mongo extends Database{

    public function connect(){

        if($connection = new Mongo("mongodb://$this->host")) {
            $this->connection = $connection->{$this->name};
        }
    }

    public function insert(){

    }

    public function create_table(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function select(){

    }

    public function query(){

    }

    public function result(){

    }
}