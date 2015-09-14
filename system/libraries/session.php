<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Session
{
    /**
     * Constructor.
     *
     * @var $args (must be an associative array with two parameters [
     *      'encryption_key'=>'(at less 32 characters string)',
     *      'expire_time'   =>integer
     * ]);
     */
    public function __construct($args = null){
        /**
         * Getting the session configuration file from active application config folder
         * */
        $config = get_config('session');
        /**
         * Checking if arguments passed with __constructor method
         *
         * if true we going to set session parameters from passed args
         * */
        $config = ($args != null) ? $args : $config;

        /**
         * Checking the encryption key
         * */
        if(strlen($config['encryption_key']) < 32)
            exit('To use session you must set encryption key at less 32 symbols');
        /**
         * Starting session
         * */
        session_start();
        /**
         * Checking is session id set
         *
         * if true registering session
         * */
        if(!isset($_SESSION['session_id']))
            $this->register($config['expire_time'], $config['encryption_key']);

        /**
         * Checking session registered and expire time
         *
         * if false destroying session
         * */
        if(!$this->isRegistered() || $this->isExpired()) $this->end();
    }
    /**
     * Destructor.
     */
    public function __destruct(){
        unset($this);
    }
    /**
     * Register the session.
     *
     * @param integer $time.
     */
    static protected function register($time = 60,$id = null){
        if($time == 0) $time = (60*60*24*100);
        $_SESSION['session_id'] = ($id != null) ? $id : session_id();
        $_SESSION['session_time'] = intval($time);
        $_SESSION['session_start'] = self::newTime();
    }
    /**
     * Checks to see if the session is registered.
     *
     * @return  True if it is, False if not.
     */
    static public function isRegistered(){
        if (! empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Set key/value in session.
     *
     * @param mixed $key_or_keys
     * @param mixed $value
     * @return boolean
     */
    static public function set($key_or_keys, $value = null){
        if($value != null) {
            $_SESSION[$key_or_keys] = $value;
        }else{
            if(!is_array($key_or_keys))
                exit('<hr>For session set method you must pus first parameter as array (key=>val) or both parameters first key second value');
            foreach($key_or_keys as $key=>$value){
                $_SESSION[$key] = $value;
            }
        }
        return true;
    }
    /**
     * Get value stored in session by key.
     * @var string $key
     * @retrun $_SESSION or boolean
     */
    static public function get($key){
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }
    /**
     * Retrieve the global session variable.
     *
     * @return array
     */
    static public function getSession(){
        return $_SESSION;
    }
    /**
     * Gets the id for the current session.
     *
     * @return integer - session id
     */
    static public function getSessionId()
    {
        return $_SESSION['session_id'];
    }
    /**
     * Checks to see if the session is over based on the amount of time given.
     *
     * @return boolean
     */
    static public function isExpired()
    {
        if ($_SESSION['session_start'] < self::timeNow()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Renews the session when the given time is not up and there is activity on the site.
     */
    static public function renew()
    {
        $_SESSION['session_start'] =self::newTime();
    }
    /**
     * Returns the current time.
     *
     * @return unix timestamp
     */
    static private function timeNow()
    {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
    }
    /**
     * Generates new time.
     *
     * @return unix timestamp
     */
    static private function newTime()
    {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear);
    }
    /**
     * Remove special key from session array
     *
     * @param string $key
     * */
    static public function forget($key){
        unset($_SESSION[$key]);
    }
    /**
     * Destroys the session.
     */
    static public function end()
    {
        session_destroy();
        $_SESSION = array();
    }
}