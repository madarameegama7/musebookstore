<?php
class Child extends Controller {
    private $childModel;
    private $bookModel;
    private $commentModel;

    public function __construct() {
        // Check if logged in and correct role
        if(!isset($_SESSION['user_id'])) {
            redirect('users/login');
        } elseif($_SESSION['user_role'] !== 'child') {
            redirect('pages/index');
        }

        $this->childModel = $this->model('M_Child');
        $this->bookModel = $this->model('M_Books');
        $this->commentModel = $this->model('M_Comments');
    }
    
    /**
     * Default index method - redirects to childHome
     */
    public function index() {
        redirect('pages/index');
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
            redirect('pages/index');
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
            redirect('pages/index');
        }

        // Process request
        $childId = $_SESSION['user_id'];
        
        if($this->childModel->requestBook($childId, $bookId)) {
            flash('request_success', 'Book request sent to your parent for approval', 'alert alert-success');
        } else {
            flash('request_error', 'Unable to request this book. Please try again.', 'alert alert-danger');
        }
        
        redirect('pages/index');
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
    
    /**
     * Add a comment to a book
     * @param int $bookId The book ID
     * @return void
     */
    public function addComment($bookId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get form data
            $data = [
                'book_id' => $bookId,
                'user_id' => $_SESSION['user_id'],
                'comment' => trim($_POST['comment']),
                'comment_err' => ''
            ];
            
            // Validate comment
            if(empty($data['comment'])) {
                $data['comment_err'] = 'Please enter a comment';
            }
            
            // Make sure there are no errors
            if(empty($data['comment_err'])) {
                // Add comment
                if($this->commentModel->addComment($data['book_id'], $data['user_id'], $data['comment'])) {
                    flash('comment_success', 'Your comment has been added', 'alert alert-success');
                } else {
                    flash('comment_error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }
            } else {
                flash('comment_error', $data['comment_err'], 'alert alert-danger');
            }
            
            redirect('child/viewBook/' . $bookId);
        } else {
            redirect('child/viewBook/' . $bookId);
        }
    }
    
    /**
     * Delete a comment
     * @param int $commentId The comment ID
     * @param int $bookId The book ID (for redirection)
     * @return void
     */
    public function deleteComment($commentId, $bookId) {
        if($this->commentModel->deleteComment($commentId, $_SESSION['user_id'])) {
            flash('comment_success', 'Comment deleted', 'alert alert-success');
        } else {
            flash('comment_error', 'Could not delete comment', 'alert alert-danger');
        }
        
        redirect('child/viewBook/' . $bookId);
    }

    // View book details
    public function viewBook($bookId = null) {
        if(!$bookId) {
            redirect('pages/index');
        }

        $book = $this->bookModel->getBooksById($bookId);

        if(!$book) {
            redirect('pages/index');
        }

        // Check if this book has already been requested by the child
        $childId = $_SESSION['user_id'];
        $existingRequest = $this->childModel->getBookRequestStatus($childId, $bookId);
        
        // Get comments for this book
        $comments = $this->commentModel->getCommentsByBook($bookId);

        $data = [
            'book' => $book,
            'request' => $existingRequest,
            'comments' => $comments
        ];

        $this->view('pages/child/v_book_detail', $data);
    }
}

?>
