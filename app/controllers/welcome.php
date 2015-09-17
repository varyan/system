<?php
defined('SYS_PATH') OR exit('No direct script access allowed');

class Welcome extends Controller{
    /*
     *---------------------------------------------------------------
     * _constructor method
     *---------------------------------------------------------------
     */
    public function __construct(){
        parent::__construct();
        $this->model('user_model');
    }
    /*
     *---------------------------------------------------------------
     * page method
     * @param string $page (default value 'index')
     *---------------------------------------------------------------
     */
    public function page($page = 'index'){

        if(!file_exists(VIEW_PATH.'pages/'.$page.EXT)){
            show_error();
        }

        debug_print($this->user_model->get_join('user_info'));
        $this->args['title'] = 'Welcome';

        $this->view('includes/header',$this->args);
        $this->view('pages/'.$page,$this->args);
        $this->view('includes/footer',$this->args);
    }
}