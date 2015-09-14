<?php


class Welcome extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model('main_model');
        $this->library('database');
    }

    public function page($page = 'index'){
        $this->args['title'] = 'Welcome';
        $user = $this->database ->select('*','distinct')
                                ->where(array(
                                    'users.role'=>'user'
                                ))
                                ->order('users.id','desc')
                                ->limit(0,1)
                                ->join('user_info','users.id = user_info.user_id')
                                ->from('users')
                                ->query()
                                ->result();

        debug_print($user);

        $this->view('pages/'.$page,$this->args);
    }
}