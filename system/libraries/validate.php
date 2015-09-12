<?php

class Validate {
    private $status = 'success',$message = '';
    /**
     *Variable to send as checker
     * @var array $report
     * */
    private $report = [];
    /**
     * Parameter to save validate value
     * @var any not array/object $data
     * */
    private $data;
    /**
     * Set validate item
     *
     * @var any not array/object $data
     * @return Object
     * */
    public function set($data){
        $this->data = $data;
        return $this;
    }
    /**
     * Ip address validate ip function
     *
     * @return Object
     * */
    public function ip(){
        $this->data = filter_var($this->data, FILTER_VALIDATE_IP);
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' is not valid ip address'.'. <br>';
        }
        return $this;
    }
    /**
     * String validate function
     *
     * @return Object
     * */
    public function string(){
        $this->data = (is_string($this->data)) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' is not valid string'.'. <br>';
        }
        return $this;
    }
    /**
     * Email validate function
     *
     * @return Object
     * */
    public function email(){
        $this->data = filter_var($this->data, FILTER_VALIDATE_EMAIL);
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' is not valid email'.'. <br>';
        }
        return $this;
    }

    /**
     * Boolean validate function
     *
     * @return Object
     * */
    public function bool(){
        $this->data = filter_var($this->data, FILTER_VALIDATE_BOOLEAN);
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' is not valid boolean'.'. <br>';
        }
        return $this;
    }
    /**
     * Password validate function
     *
     * @return Object
     * */
    public function pass(){
        $this->data = (preg_match("#[0-9]+#",$this->data)) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' must contain at less one integer character'.'. <br>';
        }
        $this->data = (preg_match("#[A-Z]+#",$this->data)) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' must contain at less one capital later'.'. <br>';
        }
        $this->data = (preg_match("#[a-z]+#",$this->data)) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' must contain at less one small later'.'. <br>';
        }
        return $this;
    }
    /**
     * Max length validate function
     *
     * @var integer $length
     * @return Object
     * */
    public function max($length = 16){
        $this->data = (intval(strlen($this->data)) > $length) ? false : $this->data;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' characters length must be at maximum '.$length.' symbols. <br>';
        }
        return $this;
    }
    /**
     * Min length validate function
     *
     * @var integer $length
     * @return Object
     * */
    public function min($length = 6){
        $this->data = (intval(strlen($this->data)) < $length) ? false : $this->data;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= " characters length must be at minimum ".$length.' symbols. <br>';
        }
        return $this;
    }
    /**
     * Between validate function
     *
     * @var integer $start
     * @var integer $end
     * @return Object
     * */

    public function between($start = 6, $end = 16){
        $this->data = (strlen($this->data) > $start && strlen($this->data) < $end) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' characters length must be great then '.$start.' and less then '.$end.'. <br>';
        }
        return $this;
    }
    /**
     * Not between validate function
     *
     * @var integer $start
     * @var integer $end
     * @return Object
     * */
    public function not_between($start = 6, $end = 16){
        $this->data = (strlen($this->data) < $start || strlen($this->data) > $end) ? $this->data : false;
        if(!$this->data){
            $this->status = 'error';
            $this->message .= ' characters length must be less then '.$start.' or grate then '.$end.'. <br>';
        }
        return $this;
    }
    /**
     * Run validate function
     *
     * @return validated array $this->report
     * */
    public function test(){
        $this->report = [
            'status'=>$this->status,
            'message'=>$this->message,
            'data'=>trim($this->data),
        ];
        $this->message = '';
        $this->status = 'success';
        return $this->report;
    }
}