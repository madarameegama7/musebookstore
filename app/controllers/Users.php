<?php
class Users extends Controller{
    public function __construct(){

    }
    public function signup(){
        $data=[];
        $this->view('users/v_register',$data);


    }

}
?>