<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Model{
    /*
    *---------------------------------------------------------------
    * $table variable
    *---------------------------------------------------------------
    */
    private $table;
    /*
    *---------------------------------------------------------------
    * __construct method
    * @param boolean/string $table (default false)
    *---------------------------------------------------------------
    */
    public function __construct($table = false){
        if($table !== false) $this->table = $table;
        $this->library('database');
    }
    /*
    *---------------------------------------------------------------
    * __select method
    * @param integer $id (default false)
    *---------------------------------------------------------------
    */
    public function get($id = false){
        if($id !== false) $this->database->where('id',$id);
        $query = $this->database ->select()
                        ->from($this->table)
                        ->query();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }
    /*
    *---------------------------------------------------------------
    * __insert method
    * @param $data array
    *---------------------------------------------------------------
    */
    public function insert($data){
        $query = $this->database->insert($this->table,$data)
                                ->query();
        return ($query->affected_rows > 0) ? $query->last_id : false;
    }
    /*
    *---------------------------------------------------------------
    * __update method
    * @param integer $id
    * @param array $data
    *---------------------------------------------------------------
    */
    public function update($id,$data){
        $query = $this->database->where('id',$id)
                                ->update($this->table,$data)
                                ->query();
        return ($query->affected_rows > 0) ? true : false;
    }
    /*
    *---------------------------------------------------------------
    * __delete method
    * @param integer $id
    *---------------------------------------------------------------
    */
    public function delete($id){
        $query = $this->database->where('id',$id)
                                ->delete($this->table);
        return ($query->affected_rows > 0) ? true : false;
    }
    public function get_table(){
        return $this->table;
    }
    /*
    *---------------------------------------------------------------
    * __library method
    * @param string $file
    * @param array $args
    *---------------------------------------------------------------
    */
    protected function library($file, $args = []){
        if(is_dir(APP_PATH.'libraries')){
            if(file_exists(APP_PATH.'libraries/'.$file.EXT)){
                if(is_dir(APP_PATH.'libraries/'.$file)){
                    $config = get_config($file);
                    require_once APP_PATH.'libraries/'.$file.EXT;
                    $class = ($args != null) ? $args['drive'] : $config['drive'];
                    if(file_exists(APP_PATH.'libraries/'.$file.'/'.$class.EXT)){
                        require_once APP_PATH.'libraries/'.$file.'/'.$class.EXT;
                        $class = "Lib_".ucfirst($class);
                        $this->$file = new $class($args);
                    }
                }else {
                    require_once APP_PATH . 'libraries/' . $file . EXT;
                    $this->$file = new $file($args);
                }
            }else{
                if(is_dir(SYS_PATH.'libraries/'.$file)){
                    $config = get_config($file);
                    require_once SYS_PATH.'libraries/'.$file.EXT;
                    $class = ($args != null) ? $args['drive'] : $config['drive'];
                    if(file_exists(SYS_PATH.'libraries/'.$file.'/'.$class.EXT)){
                        require_once SYS_PATH.'libraries/'.$file.'/'.$class.EXT;
                        $class = "Lib_".ucfirst($class);
                        $this->$file = new $class($args);
                    }
                }else {
                    require_once SYS_PATH . 'libraries/' . $file . EXT;
                    $this->$file = new $file($args);
                }
            }
        }else{
            if(is_dir(SYS_PATH.'libraries/'.$file)){
                $config = get_config($file);
                require SYS_PATH.'libraries/'.$file.EXT;
                $class = ($args != null) ? $args['drive'] : $config['drive'];
                if(file_exists(SYS_PATH.'libraries/'.$file.'/'.$class.EXT)){
                    require SYS_PATH.'libraries/'.$file.'/'.$class.EXT;
                    $class = "Lib_".ucfirst($class);
                    $this->$file = new $class($args);
                }
            }else {
                require SYS_PATH . 'libraries/' . $file . EXT;
                $this->$file = new $file($args);
            }
        }
    }
}