<?php
class ChildBooks extends Controller
{
    private $bookModel;
 

    public function __construct()
    {
        $this->bookModel = $this->model('M_Books');
     

    }
    public function loadView()
    {
        $data = [];
        $this->view('books/v_displaybooks', $data);
    }
    public function loadViewChild()
    {
        $data = [];
        $this->view('books/v_displaychildbooks', $data);
    }
    public function index()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
        $this->view('books/v_displaychildbooks', $data);
    }
    public function show()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
        $this->view('books/v_displaychildbooks', $data);


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
}