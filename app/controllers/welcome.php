<?php


class Welcome extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model('main_model');
        $this->library('database');
    }

    public function page($page = 'index'){
        $this->args['title'] = 'Welcome';
        $this->view('pages/'.$page,$this->args);
    }
}