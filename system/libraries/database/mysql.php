<?php
/**
 * Class extends abstract Database class
 *
 * Required three abstract methods (connect,query,result)
 * */
class Lib_MySQL extends Database{

    /**
     * Constructor
     *
     * should use parent::__construct()
     * */
    public function __construct(){
        parent::__construct();
    }
    /**
     * connect method
     *
     * method required for all classes witch extends Database class
     * */
    public function connect(){
        if($connection = mysql_connect($this->host,$this->user,$this->pass)){
            if(!mysql_select_db($this->name)){
                mysql_query("CREATE DATABASE IF NOT EXISTS ".$this->name);
                if(!mysql_select_db($this->name)) {
                    trigger_error('Could not select Database ' . $this->name);
                    exit();
                }else{
                    mysql_set_charset($this->charset,$connection);
                    $this->connection = $connection;
                }
            }else{
                mysql_set_charset($this->charset,$connection);
                $this->connection = $connection;
            }
        }else{
            trigger_error('Could not connect to Database');
            exit();
        }
    }
    /**
     * query method
     *
     *@param string(when not chained from others) $string
     * @return object Lib_MySQL
     * method required for all classes witch extends Database class
     * */
    public function query($string = ''){
        if($string != '')
            $this->query = $this->escape($string);
        else
            $this->query =  $this->select.$this->insert.
                            $this->update.$this->delete.
                            $this->create.$this->from.
                            $this->join.$this->where.
                            $this->group.$this->order.$this->limit;

        $this->result = mysql_query($this->query,$this->connection);
        $this->last_id = mysql_insert_id($this->connection);

        $this->select = '';$this->insert = '';$this->update = '';$this->delete = '';$this->create = '';
        $this->from = '';$this->join = '';$this->where = '';$this->group = '';$this->order = '';$this->limit = '';

        return $this;

    }
    /**
     * query method
     *
     *@param string (array or object(admin)) $type
     * @return query result(as array or stdClass object)
     * method required for all classes witch extends Database class
     * */
    public function result($type = 'object'){
        $result = [];
        while($row = mysql_fetch_assoc($this->result)){
            $result[] = ($type == 'object') ? (object)$row : $row;
        }
        return $result;
    }
}