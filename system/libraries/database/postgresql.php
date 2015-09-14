<?php

class Lib_PostgreSQL extends Database{

    public function connect(){
        if($connection = pg_connect("host=$this->host port=$this->port dbname=$this->name user=$this->user password=$this->pass")){
            pg_set_client_encoding($connection,$this->charset);
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

        $this->insert = " RETURNING id";
        $this->result = pg_exec($this->connection,$this->query);
        $this->inserted_id = $this->result;
        $this->error = pg_errormessage($this->connection);
        $this->affected_rows = pg_affected_rows($this->result);

        $this->select = '';$this->insert = '';$this->update = '';$this->delete = '';$this->create = '';
        $this->from = '';$this->join = '';$this->where = '';$this->group = '';$this->order = '';$this->limit = '';

        return $this;
    }

    public function result($type = 'object'){
        $result = [];
        while($row = pg_fetch_assoc($this->result)){
            $result[] = ($type == 'object') ? (object)$row : $row;
        }
        return $result;
    }
    /**
     *
     * */
    public function num_rows(){
        return pg_num_rows($this->result);
    }
}