<?php


class Welcome extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model('main_model');
    }

    public function page($param){
        $this->args['title'] = 'Welcome';
        $this->view('pages/'.$param[0],$this->args);
    }
}