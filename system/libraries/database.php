<?php
defined('SYS_PATH') OR exit('No direct script access allowed');


abstract class Database {
    /**
     * @param static $last_id
     * */
    public $last_id = 0;
    /**
     * abstract Database class
     * methods work`s like chain
     *
     *@params string and null
     *for connection and querying
     * */

    protected   $host       = 'localhost',  $user       = 'root',
                $pass       = '',           $name       = '',
                $charset    = 'utf8',       $connection = null,
                $select     = "",           $from       = "",
                $delete     = "",           $update     = "",
                $insert     = "",           $create     = "",
                $alter      = "",           $table      = "",
                $query      = null,         $where      = "",
                $join       = "",           $order      = "",
                $group      = "",           $limit      = "",
                $result     = null,         $drive      = "",
                $port       = null;
    /**
     * Constructor
     *
     * must be parented from child classes
     * */
    public function __construct($config = false){

        if($config){
            foreach($config as $key=>$value){
                $this->$key = $value;
            }
        }else {

            $config = get_config('database');

            $this->drive    = $config['drive'];
            $this->host     = $config['host'];
            $this->port     = $config['port'];
            $this->user     = $config['user'];
            $this->pass     = $config['pass'];
            $this->name     = $config['name'];
            $this->charset  = $config['charset'];
            $this->connect();
        }
    }
    /**
     * Database insert method
     *
     * @param string $table
     * @param array $data
     * @return object Database
     * */
    public function insert($table,$data){
        $this->insert .= " INSERT INTO ".$this->escape($table)." ";
        $rows = "("; $values = "("; $i = 0;
        foreach($data as $row=>$value){$i++;
            $rows .= $this->escape($row);
            $values .= "'".$this->escape($value)."'";
            if($i < count($data)){
                $rows .= ","; $values .= ",";
            }
        }
        $rows .= ")"; $values .= ")";
        $this->insert .= $rows." VALUES ".$values;
        return $this;
    }
    /**
     * Database update method
     *
     * @param string $table
     * @param array $data
     * @return object Database
     * */
    public function update($table,$data){
        $this->update .= " UPDATE ".$this->escape($table)." SET ";
        $i = 0;
        foreach($data as $row=>$value){$i++;
            $this->update .= $this->escape($row)." = '".$this->escape($value)."'";
            if($i < count($data)){
                $this->update .= ", ";
            }
        }
        $this->update .= " ";
        return $this;
    }
    /**
     * Database create_table method
     *
     * @param string $name
     * @param array $conditions
     * @param string $optional admin null (optional)
     * @return object Database
     * */
    public function create_table($name,$conditions,$optional = null){
        $this->create .= " CREATE TABLE IF NOT EXISTS ".$this->escape($name)." (";
        $i = 0;
        foreach($conditions as $row=>$condition){$i++;
            $this->create .= $this->escape($row)." ".$this->escape($condition);
            if($i < count($conditions)){
                $this->create .= ", ";
            }
        }
        if($optional != null){
            $this->create .= ", ".$this->escape($optional);
        }
        $this->create .= ");";
        return $this;
    }
    /**
     * Database delete method
     *
     * @param string $table
     * @return object Database
     * */
    public function delete($table){
        $this->delete .= " DELETE FROM ".$this->escape($table)." ";
        return $this;
    }
    /**
     * Database select method
     *
     * @param string $string
     * @param string $type
     * @return object Database
     * */
    public function select($string = "*",$type = ""){
        $this->select .= " SELECT ".$this->escape($type)." ".$this->escape($string)." ";
        return $this;
    }
    /**
     * Database from method
     *
     * @param string $table
     * @return object Database
     * */
    public function from($table){
        $this->from .= " FROM ".$this->escape($table)." ";
        $this->table = $this->escape($table);
        return $this;
    }
    /**
     * Database where method
     *
     * @param string (as table row name) or array (as table.row_name=>value) $row_or_array
     * @param string(as table row value) or null(admin) $value_if_key
     * @return object Database
     * */
    public function where($row_or_array,$value_if_row = null){
        $this->where .= " WHERE ";
        if($value_if_row != null){
            $this->where .= $this->escape($row_or_array)." = '".$this->escape($value_if_row)."' ";
        }else{$i = 0;
            foreach($row_or_array as $row=>$value){$i++;
                $this->where .= $this->escape($row)." = '".$this->escape($value)."'";
                if($i < count($row_or_array))
                    $this->where .= " and ";
            }
            $this->where .= " ";
        }
        return $this;
    }
    /**
     * Database join method
     *
     * @param string $table
     * @param string $side
     * @param string(as query join after ON keyword) or array(as tb1.row=>tb2.row without tables and dot only row) $string_or_array
     * @return object Database
     * */
    public function join($table,$string_or_array,$side = 'left'){
        $this->join .= ucfirst($this->escape($side)) . " JOIN " . $this->escape($table) . " ON ";
        if(is_string($string_or_array)) {
            $this->join .= $this->escape($string_or_array) . " ";
        }else{$i = 0;
            foreach($string_or_array as $tb1_row=>$tb2_row){$i++;
                $this->join .= $this->escape($this->table).".".$this->escape($tb1_row)." = ".$this->escape($table).".".$this->escape($tb2_row);
                if($i < count($string_or_array)){
                    $this->join .= " and ";
                }
            }
            $this->join .= " ";
        }
        return $this;
    }
    /**
     * Database limit method
     *
     * @param integer $start
     * @param integer $results
     * @return object Database
     * */
    public function limit($start,$results){
        $this->limit .= " LIMIT ".$start.",".$results;
        return $this;
    }
    /**
     * Database order method
     *
     * @param string(as row name) or array(as row_name=>order_type) $row_or_array
     * @param string $value_if_row (as order type ) admin(null)
     * @return object Database
     * */
    public function order($row_or_array, $value_if_row = null){
        $this->order .= " ORDER BY ";
        if($value_if_row != null){
            $this->order .= $this->escape($row_or_array)." ".$this->escape($value_if_row);
        }else{$i = 0;
            foreach($row_or_array as $row=>$value){$i++;
                $this->order .= $this->escape($row)." ".$this->escape($value);
                if($i < count($row_or_array))
                    $this->order .= ",";
            }
        }
        return $this;
    }
    /**
     * Database group method
     *
     * @param string (like row_1,row_2,row_3....row_n) $fields
     * @return object Database
     * */
    public function group($fields){
        $this->group .= " GROUP BY ".$fields." ";
        return $this;
    }
    /**
     * Database escape method
     *
     * @param string $data
     * @return escaped param
     * */
    protected function escape($data){
        switch($this->drive){
            case "mysql":
                if(function_exists('mysql_real_escape_string')){
                    $data = mysql_real_escape_string(trim($data));
                    $data = strip_tags($data);
                }
                break;
            case "mysqli":
                if(function_exists('mysqli_real_escape_string')){
                    $data = mysqli_real_escape_string($this->connection,trim($data));
                    $data = strip_tags($data);
                }
                break;
            case "postgresql":
                if(function_exists('pg_escape_string')){
                    $data = pg_escape_string($this->connection,trim($data));
                    $data = strip_tags($data);
                }
                break;
            case "sqlite":
                if(method_exists($this->connection,'escapeString')){
                    $data = $this->connection->escapeString($data);
                    $data = strip_tags($data);
                }
                break;
            case "sql":

                break;
        }
        return $data;
    }
    /**
     * Database connect abstract method
     *
     * every child must have this method
     * */
    abstract protected function connect();
    /**
     * Database query abstract method
     *
     * every child must have this method
     * */
    abstract protected function query();
    /**
     * Database result abstract method
     *
     * every child must have this method
     * */
    abstract protected function result();
}