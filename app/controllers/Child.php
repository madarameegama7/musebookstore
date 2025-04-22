<?php
class Child extends Controller {
    private $childModel;
    private $bookModel;
    private $commentModel;
    private $favoriteModel;
    private $articleModel;

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
        $this->favoriteModel = $this->model('M_Favorites');
        $this->articleModel = $this->model('M_Articles');
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

    /**
     * Edit a comment
     * @param int $commentId The comment ID to edit
     * @param int $bookId The book ID (for redirection)
     * @return void
     */
    public function editComment($commentId, $bookId) {
        // Get the comment to check if it belongs to the user
        $comment = $this->commentModel->getCommentById($commentId);
        
        if(!$comment || $comment->user_id != $_SESSION['user_id']) {
            flash('comment_error', 'You are not authorized to edit this comment', 'alert alert-danger');
            redirect('child/viewBook/' . $bookId);
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get form data
            $data = [
                'comment_id' => $commentId,
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
                // Update comment
                if($this->commentModel->updateComment($data['comment_id'], $data['user_id'], $data['comment'])) {
                    flash('comment_success', 'Your comment has been updated', 'alert alert-success');
                } else {
                    flash('comment_error', 'Something went wrong. Please try again.', 'alert alert-danger');
                }
                redirect('child/viewBook/' . $bookId);
            } else {
                flash('comment_error', $data['comment_err'], 'alert alert-danger');
                redirect('child/viewBook/' . $bookId);
            }
        } else {
            // Get the current comment text
            $data = [
                'comment_id' => $commentId,
                'book_id' => $bookId,
                'comment' => $comment->comment
            ];
            
            $this->view('pages/child/v_edit_comment', $data);
        }
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
        
        // Check if book is in favorites
        $isFavorited = $this->favoriteModel->isBookFavorited($childId, $bookId);
        
        // Get comments for this book
        $comments = $this->commentModel->getCommentsByBook($bookId);

        $data = [
            'book' => $book,
            'request' => $existingRequest,
            'comments' => $comments,
            'is_favorited' => $isFavorited
        ];

        $this->view('pages/child/v_book_detail', $data);
    }

    /**
     * Add a book to favorites
     * @param int $bookId The book ID
     * @return void
     */
    public function addToFavorites($bookId = null) {
        // If no book ID provided, redirect back
        if(!$bookId) {
            flash('favorite_error', 'Invalid book selection', 'alert alert-danger');
            redirect('pages/index');
        }

        // Add to favorites
        $userId = $_SESSION['user_id'];
        
        if($this->favoriteModel->addFavorite($userId, $bookId)) {
            flash('favorite_success', 'Book added to your favorites', 'alert alert-success');
        } else {
            flash('favorite_error', 'Unable to add this book to favorites. Please try again.', 'alert alert-danger');
        }
        
        // Redirect back to the book page
        redirect('child/viewBook/' . $bookId);
    }

    /**
     * Remove a book from favorites
     * @param int $bookId The book ID
     * @return void
     */
    public function removeFromFavorites($bookId = null) {
        // If no book ID provided, redirect back
        if(!$bookId) {
            flash('favorite_error', 'Invalid book selection', 'alert alert-danger');
            redirect('pages/index');
        }

        // Remove from favorites
        $userId = $_SESSION['user_id'];
        
        if($this->favoriteModel->removeFavorite($userId, $bookId)) {
            flash('favorite_success', 'Book removed from your favorites', 'alert alert-success');
        } else {
            flash('favorite_error', 'Unable to remove this book from favorites. Please try again.', 'alert alert-danger');
        }
        
        // Redirect back to the book page
        redirect('child/viewBook/' . $bookId);
    }

    /**
     * View favorite books
     * @return void
     */
    public function favorites() {
        $userId = $_SESSION['user_id'];
        $favoriteBooks = $this->favoriteModel->getFavoriteBooks($userId);
        
        $data = [
            'books' => $favoriteBooks,
            'page_title' => 'My Favorite Books'
        ];
        
        $this->view('pages/child/v_favorites', $data);
    }

    /**
     * View all articles written by children
     * @return void
     */
    public function articles() {
        // Get all published articles
        $articles = $this->articleModel->getAllArticles();
        
        $data = [
            'articles' => $articles,
            'page_title' => 'Child Articles'
        ];
        
        $this->view('pages/child/v_articles', $data);
    }

    /**
     * View my articles (articles written by the current child user)
     * @return void
     */
    public function myArticles() {
        $userId = $_SESSION['user_id'];
        $articles = $this->articleModel->getArticlesByUser($userId);
        
        $data = [
            'articles' => $articles,
            'page_title' => 'My Articles'
        ];
        
        $this->view('pages/child/v_my_articles', $data);
    }

    /**
     * View a single article
     * @param int $articleId The article ID
     * @return void
     */
    public function viewArticle($articleId = null) {
        if(!$articleId) {
            redirect('child/articles');
        }

        $article = $this->articleModel->getArticleById($articleId);

        if(!$article) {
            redirect('child/articles');
        }

        $data = [
            'article' => $article
        ];

        $this->view('pages/child/v_article_detail', $data);
    }

    /**
     * Create a new article
     * @return void
     */
    public function createArticle() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get form data
            $data = [
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'image_url' => isset($_POST['image_url']) ? trim($_POST['image_url']) : null,
                'title_err' => '',
                'content_err' => ''
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title';
            }
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter some content';
            }
            
            // Make sure there are no errors
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // Add article
                if($articleId = $this->articleModel->addArticle($_SESSION['user_id'], $data['title'], $data['content'], $data['image_url'])) {
                    flash('article_success', 'Your article has been published', 'alert alert-success');
                    redirect('child/viewArticle/' . $articleId);
                } else {
                    flash('article_error', 'Something went wrong. Please try again.', 'alert alert-danger');
                    $this->view('pages/child/v_create_article', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/child/v_create_article', $data);
            }
        } else {
            $data = [
                'title' => '',
                'content' => '',
                'image_url' => '',
                'title_err' => '',
                'content_err' => ''
            ];
            
            $this->view('pages/child/v_create_article', $data);
        }
    }

    /**
     * Edit an existing article
     * @param int $articleId The article ID
     * @return void
     */
    public function editArticle($articleId = null) {
        if(!$articleId) {
            redirect('child/myArticles');
        }
        
        // Check if article exists and belongs to user
        $article = $this->articleModel->getArticleById($articleId);
        
        if(!$article || $article->user_id != $_SESSION['user_id']) {
            flash('article_error', 'You are not authorized to edit this article', 'alert alert-danger');
            redirect('child/myArticles');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get form data
            $data = [
                'article_id' => $articleId,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'image_url' => isset($_POST['image_url']) ? trim($_POST['image_url']) : null,
                'title_err' => '',
                'content_err' => ''
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title';
            }
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter some content';
            }
            
            // Make sure there are no errors
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // Update article
                if($this->articleModel->updateArticle($articleId, $_SESSION['user_id'], $data['title'], $data['content'], $data['image_url'])) {
                    flash('article_success', 'Your article has been updated', 'alert alert-success');
                    redirect('child/viewArticle/' . $articleId);
                } else {
                    flash('article_error', 'Something went wrong. Please try again.', 'alert alert-danger');
                    $this->view('pages/child/v_edit_article', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/child/v_edit_article', $data);
            }
        } else {
            $data = [
                'article_id' => $articleId,
                'title' => $article->title,
                'content' => $article->content,
                'image_url' => $article->image_url,
                'title_err' => '',
                'content_err' => ''
            ];
            
            $this->view('pages/child/v_edit_article', $data);
        }
    }

    /**
     * Delete an article
     * @param int $articleId The article ID
     * @return void
     */
    public function deleteArticle($articleId = null) {
        if(!$articleId) {
            redirect('child/myArticles');
        }
        
        // Check if article exists and belongs to user
        $article = $this->articleModel->getArticleById($articleId);
        
        if(!$article || $article->user_id != $_SESSION['user_id']) {
            flash('article_error', 'You are not authorized to delete this article', 'alert alert-danger');
            redirect('child/myArticles');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->articleModel->deleteArticle($articleId, $_SESSION['user_id'])) {
                flash('article_success', 'Article deleted successfully', 'alert alert-success');
            } else {
                flash('article_error', 'Something went wrong. Please try again.', 'alert alert-danger');
            }
            
            redirect('child/myArticles');
        } else {
            // Confirmation page
            $data = [
                'article' => $article
            ];
            
            $this->view('pages/child/v_delete_article', $data);
        }
    }

    /**
     * View child user profile dashboard
     * @return void
     */
    public function profile() {
        $userId = $_SESSION['user_id'];
        
        // Get child user data
        $child = $this->childModel->getUserById($userId);
        
        // Get activity statistics
        $requests = $this->childModel->getRequestsByChild($userId);
        $favorites = $this->favoriteModel->getFavoriteBooks($userId);
        $articles = $this->articleModel->getArticlesByUser($userId);
        
        // Count comments (using comment model)
        $commentCount = $this->commentModel->getCommentCountByUser($userId);
        
        // Format data for view
        $data = [
            'child' => $child,
            'request_count' => count($requests),
            'approved_count' => array_reduce($requests, function($carry, $item) { 
                return $carry + ($item->status === 'approved' ? 1 : 0); 
            }, 0),
            'pending_count' => array_reduce($requests, function($carry, $item) { 
                return $carry + ($item->status === 'pending' ? 1 : 0); 
            }, 0),
            'favorite_count' => count($favorites),
            'article_count' => count($articles),
            'comment_count' => $commentCount
        ];
        
        $this->view('pages/child/v_profile', $data);
    }
}

?>
