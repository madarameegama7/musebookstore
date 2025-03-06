<?php
class Child extends Controller {
    private $childModel;

    public function __construct() {
        $this->childModel = $this->model('M_Child');
    }

    public function childHome() {
        $data = [];
        $this->view('pages/child/v_childhome', $data);
    }
     public function bookRelease(){
        $data = [];
        $this->view('pages/child/v_newbookrelease', $data);
     }
      public function childAuthourAward(){
        $data = [];
        $this->view('pages/child/v_childauthouraward', $data);
    }
     
      public function childAuto(){
        $data = [];
        $this->view('pages/child/v_childauto', $data);
    }
    public function childTopBooks(){
        $data = [];
        $this->view('pages/child/v_childtopbooks', $data);
    }
    public function childCreative(){
        $data = [];
        $this->view('pages/child/v_childtopbooks', $data);
    }
}

?>
