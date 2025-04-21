<?php
class Child extends Controller {
    private $childModel;
    private $bookModel;

    public function __construct() {
        // Check if logged in and correct role
        if(!isset($_SESSION['user_id'])) {
            redirect('users/login');
        } elseif($_SESSION['user_role'] !== 'child') {
            redirect('pages/index');
        }

        $this->childModel = $this->model('M_Child');
        $this->bookModel = $this->model('M_Books');
    }
    
    /**
     * Default index method - redirects to childHome
     */
    public function index() {
        redirect('child/childHome');
    }

    public function childHome() {
        // Get all books for the child to browse
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
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
    
    /**
     * Search for books by title, author, or genre
     */
    public function searchBooks() {
        // Get search query
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($query)) {
            redirect('child/childHome');
        }
        
        // Search for books matching the query
        $books = $this->bookModel->searchBooks($query);
        
        $data = [
            'books' => $books,
            'query' => $query
        ];
        
        // Reuse the same view but with search results
        $this->view('pages/child/v_childhome', $data);
    }

    // Request a book from parent
    public function requestBook($bookId = null) {
        // If no book ID provided, redirect back
        if(!$bookId) {
            flash('request_error', 'Invalid book selection', 'alert alert-danger');
            redirect('child/childHome');
        }

        // Process request
        $childId = $_SESSION['user_id'];
        
        if($this->childModel->requestBook($childId, $bookId)) {
            flash('request_success', 'Book request sent to your parent for approval', 'alert alert-success');
        } else {
            flash('request_error', 'Unable to request this book. Please try again.', 'alert alert-danger');
        }
        
        redirect('child/childHome');
    }

    // View my requests
    public function myRequests() {
        $childId = $_SESSION['user_id'];
        $requests = $this->childModel->getRequestsByChild($childId);
        
        $data = [
            'requests' => $requests
        ];
        
        $this->view('pages/child/v_my_requests', $data);
    }

    // View book details
    public function viewBook($bookId) {
        $book = $this->bookModel->getBooksById($bookId);
        
        if(!$book) {
            redirect('child/childHome');
        }
        
        // Check if this book has been requested by this child
        $childId = $_SESSION['user_id'];
        $request = $this->childModel->getBookRequestStatus($childId, $bookId);
        
        $data = [
            'book' => $book,
            'request' => $request
        ];
        
        $this->view('pages/child/v_book_detail', $data);
    }
}

?>
