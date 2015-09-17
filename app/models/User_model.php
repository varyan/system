<?php
defined('SYS_PATH') OR exit('No direct script access allowed');


class User_model extends Model{
    /*
     *---------------------------------------------------------------
     * _constructor method
     *---------------------------------------------------------------
     */
    public function __construct(){
        parent::__construct('users');
    }

    public function get_join($join_table){
        $this->database ->select()
                        ->from($this->get_table())
                        ->join($join_table,[
                            "id"=>"user_id"
                        ]);

        return $this->database->query()->result();
    }
}