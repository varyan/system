<?php

class Lib_MySQLi extends Database{

    public function __construct(){
        parent::__construct();
    }

    public function connect(){
        if($connection = mysqli_connect($this->host,$this->user,$this->pass,$this->name,$this->port)){
            mysqli_set_charset($connection,$this->charset);
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
            $this->query =  $this->select.$this->insert.$this->update.$this->delete.$this->create.$this->from.
                            $this->join.$this->where.$this->group.$this->order.$this->limit;

        $this->result = mysqli_query($this->connection,$this->query);
        $this->last_id = mysqli_insert_id($this->connection);

        $this->select = '';$this->insert = '';$this->update = '';$this->delete = '';$this->create = '';
        $this->from = '';$this->join = '';$this->where = '';$this->group = '';$this->order = '';$this->limit = '';

        return $this;

    }

    public function result($type = 'object'){
        $result = [];
        while($row = mysqli_fetch_assoc($this->result)){
            $result[] = ($type == 'object') ? (object)$row : $row;
        }
        return $result;
    }
}