<?php

class Lib_Sql extends Database{

    public function connect(){
        if($connection = sqlsrv_connect($this->host,[
                'UID'=>$this->user,
                'PWD'=>$this->pass,
                'Database'=>$this->name,
            ])){$this->connection = $connection;
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

        $this->result = mssql_query($this->query,$this->connection);

        $this->select = '';$this->insert = '';$this->update = '';$this->delete = '';$this->create = '';
        $this->from = '';$this->join = '';$this->where = '';$this->group = '';$this->order = '';$this->limit = '';

        return $this;
    }

    public function result($type = 'object'){
        $result = [];
        while($row = mssql_fetch_assoc($this->result)){
            $result[] = ($type == 'object') ? (object)$row : $row;
        }
        return $result;
    }
}