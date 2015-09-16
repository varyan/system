<?php
defined('SYS_PATH') OR exit('No direct script access allowed');
/*
 *---------------------------------------------------------------
 * default_controller rout will send empty url to the value of $rout['default_controller']
 *---------------------------------------------------------------
 */
$route['default_controller'] = 'welcome/page';
/*
 *---------------------------------------------------------------
 * default_controller rout will send any single value of url to the welcome controller page method
 *---------------------------------------------------------------
 */
$route['(.*)'] = 'welcome/page/$1';
/*
 *---------------------------------------------------------------
 * You cane use callback for routing
 * Example routing with callback
 * Return custom rout string depends on request method
 *---------------------------------------------------------------
 *
$route['(.*)'] = function(){

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        return 'welcome/page/$1';

    }elseif($_SERVER['REQUEST_METHOD'] == "POST"){

        return 'welcome/index';

    }
};
/*
 *---------------------------------------------------------------
 * Also You cane user three types of routing parameters
    * 1 (.*) cane be any value (string,number,....other)
    * 2 (.n) cane be number type parameter from 0-9
    * 3 (.s) cane be string type parameter from a-z and A-Z
 *
 * End of example routing routing
 *---------------------------------------------------------------
 */