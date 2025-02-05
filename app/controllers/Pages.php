<?php
class Pages extends Controller {
    // Declare the property
    private $pagesModel;

    public function __construct() {
        $this->pagesModel = $this->model('M_Pages');
    }

    public function index() {
        // Example usage (optional)
        // $data = $this->pagesModel->getData();
        // $this->view('v_home', $data);
    }

    public function about() {
        $users = $this->pagesModel->getUsers();
        $data = [
            'users'=>$users
            
        ];
        $this->view('v_about', $data);
    }
}
?>
