<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

abstract class Email {
    private     $host       = "",
                $port       = "",
                $to         = "",
                $from       = "Administrator",
                $subject    = "",
                $message    = "",
                $headers    = null,
                $params     = null,
                $charset    = 'utf-8',
                $auth       = false,
                $user       = null,
                $pass       = null;
    /**
     * Constructor method
     * @param boolean/array $config (default value false)
     * */
    public function __construct($config = false){
        $email_config = ($config) ? $config : get_config('database');
        foreach($email_config as $key => $value){
            $this->$key = $value;
        }
    }
    /**
     * Send method
     * @param string/array to
     */
    public function send($to){
        if(is_array($to)) {
            for ($i = 0; $i < count($to); $i++) {
                $this->send_email($to[$i]);
            }
        }else
            $this->send_email($to);
    }
    /**
     *
     */
    private function send_email($to){
        mail($this->to,$this->subject,$this->message,$this->headers,$this->params);
    }
}