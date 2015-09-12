<?php

class Lib_SQLite extends Database{

    public function connect(){
        if($connection = new SQLite3(APP_PATH.'localDB/'.$this->name.'.sqlite')){
            $this->connection = $connection;
        }else{
            trigger_error('Could not connect to Database');
            exit();
        }
    }

    public function query($string = ''){
        if($string != '')
            $this->query = $this->escape($string);
        else
            $this->query =  $this->select.$this->insert.
                $this->update.$this->delete.
                $this->create.$this->from.
                $this->join.$this->where.
                $this->group.$this->order.$this->limit;

        $this->result = $this->connection->query($this->query);

        $this->select = '';$this->insert = '';$this->update = '';$this->delete = '';$this->create = '';
        $this->from = '';$this->join = '';$this->where = '';$this->group = '';$this->order = '';$this->limit = '';

        return $this;
    }

    public function result($type = 'object'){
        $result = [];
        while($row = $this->result->fetchArray(SQLITE3_ASSOC)){
            $result[] = ($type == 'object') ? (object)$row : $row;
        }
        return $result;
    }
}