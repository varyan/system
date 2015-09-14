<?php


class Welcome extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model('user_model');
    }

    public function page($page = 'index'){

        if(!file_exists(VIEW_PATH.'pages/'.$page.EXT)){
            show_error();
        }

        $this->args['title'] = 'Welcome';
        $this->args['user'] = $this->user_model->get(1)[0];

        $this->view('pages/'.$page,$this->args);
    }
}