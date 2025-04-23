<?php
class Pages extends Controller
{
    // Declare the property
    private $pagesModel;

    public function __construct()
    {
        $this->pagesModel = $this->model('M_Pages');
    }

    public function childindex() {
        // Load the book model to fetch books
        $bookModel = $this->model('M_Books');
        
        // Get featured books (limit to 6 for display)
        $books = $bookModel->getBooks(6);
        
        $data = [
            'books' => $books
        ];
    }
        
    public function index()
    {
        $data = [];

        $this->view('pages/v_index', $data);
    }
    public function aboutus()
    {
        $data = [];
        $this->view('pages/v_aboutus', $data);
    }

    public function contactus()
    {
        $data = [];
        $this->view('pages/v_contactus', $data);
    }
    public function services()
    {
        $data = [];
        $this->view('pages/v_services', $data);
    }
    public function whymuse()
    {
        $data = [];
        $this->view('pages/v_whymuse', $data);
    }
    public function about()
    {
        $user = $this->pagesModel->getUsers();
        $data = [
            'user' => $user

        ];
        $this->view('v_about', $data);
    }

    public function ambassadorView()
    {
        $data = [];
        $this->view('pages/ambassador/v_ambassadorhome', $data);
    }

    public function childView() {
        // Redirect to Child controller which properly loads book data
        redirect('pages/childindex');
    }
    public function parentView()
    {
        $data = [];
        $this->view('pages/parent/v_parenthome', $data);
    }

    public function parentProfileView()
    {
        $data = [];
        $this->view('pages/parent/v_userprofile', $data);
    }
    public function homeView(){
        $data=[];
        $this->view('pages/homeView',$data);
    }


}
