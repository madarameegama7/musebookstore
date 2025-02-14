<?php
class Core{
    //URL format --> /controller/method/params
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $param = [];

    public function __construct(){
        //print_r($this->getURL());
        $url = $this->getURL();
        if(file_exists('../app/controllers/'.ucwords($url[0].'.php'))){
            //if controller exists
            $this->currentController = ucwords($url[0]);
            //unset the controller in the URL
            unset($url[0]);

            //call the controller
            require_once '../app/controllers/'.$this->currentController.'.php';

            //Instantiate the controller
            $this->currentController=new $this->currentController;

            //Check whether method exists in controller or not
            if(isset($url[1])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }

        }
        //get parameter list
        $this->param = $url ? array_values($url) : [];

        //call method and pass the parameter list
        call_user_func_array([$this->currentController, $this->currentMethod], $this->param);

        
    }

    }

    public function getURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;

        }
    }

}

?>