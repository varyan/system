<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

$route = array(
    'default_controller'=>'welcome',
    '(.*)'=>function(){
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            return 'welcome/page/$1';
        }elseif($_SERVER['REQUEST_METHOD'] == "POST"){
            return 'welcome/index';
        }
    },
);