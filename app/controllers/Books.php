<?php
class Books extends Controller
{
    private $bookModel;
    private $transactionModel;
    private $notificationModel;

    public function __construct()
    {
        $this->bookModel = $this->model('M_Books');
        $this->transactionModel =  $this->model('M_Transactions');
        $this->notificationModel =  $this->model('M_Notifications');

    }
    public function loadView()
    {
        $data = [];
        $this->view('books/v_displaybooks', $data);
    }
    public function index()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
        $this->view('books/v_displaybooks', $data);
    }

    public function bookhistory() {
        // Assuming the user is logged in and userId is stored in session
        $userId = $_SESSION['user_id']; // Adjust key if needed
    
        $transactions = $this->transactionModel->getTransaction($userId);
    
        $data = [
            'transactions' => $transactions
        ];
    
        // Load the view and pass the data to it
        $this->view('books/v_bookhistory', $data);
    }
    public function create()
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'book_image'=> $_FILES['book_image'],
                'book_image_name'=> time().'_'.$_FILES['book_image']['name'],
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),

                'book_image_err' => '',
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => ''



            ];

                //validate book image and upload
                if(uploadImage($data['book_image']['tmp_name'], $data['book_image_name'], '/img/bookImgs/')){
                    //done
                }
                else{
    
                    $data['book_image_err'] = 'Book image uploaded unsuccesfully';
                }
    

            //validation
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";

            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";

            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please enter genre";

            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";

            }
            if (empty($data['price'])) {
                $data['book_price_err'] = "Please enter a price";

            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";

            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";

            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";

            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";

            }


            if (
                empty($data['book_image_err'])&&
                empty($data['book_title_err']) &&
                empty($data['book_author_err']) &&
                empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) &&
                empty($data['book_price_err']) &&
                empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) &&
                empty($data['book_year_err']) &&
                empty($data['book_isbn_err'])
            ) {

                if ($this->bookModel->create($data)) {
                    flash('post_msg', 'Book added successfully!');
                    redirect('books/index');

                } else {
                    die("Something went wrong");
                }
            } else {
                //load errros with view
                $this->view('books/v_create', $data);
            }


        } else {
            $data = [
                'book_image'=> '',
                'book_image_name'=> '',
                'booktitle' => '',
                'author' => '',
                'genre' => '',
                'bookcondition' => '',
                'price' => '',
                'bookoption' => '',
                'publisher' => '',
                'year' => '',
                'isbn' => '',

                'book_image_err' => '',
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => ''


            ];

            $this->view('books/v_create', $data);
        }



    }
    public function show()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
        $this->view('books/v_displaybooks', $data);


    }
    public function myBooks()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'books' => $books
        ];
        $this->view('books/v_parentownedbooks', $data);


    }

    public function edit($book_id)
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'bookid' => $book_id,
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),

                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => ''


            ];

            //validation
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";

            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";

            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please enter genre";

            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";

            }
            if (empty($data['price'])) {
                $data['book_price_err'] = "Please enter a price";

            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";

            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";

            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";

            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";

            }
            if (
                empty($data['book_title_err']) &&
                empty($data['book_author_err']) &&
                empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) &&
                empty($data['book_price_err']) &&
                empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) &&
                empty($data['book_year_err']) &&
                empty($data['book_isbn_err'])
            ) {
                if ($this->bookModel->update($data)) {
                    flash('post_msg', 'Book is updated');
                    redirect('books/index');

                } else {
                    die("Something went wrong");
                }
            } else {
                //load errros with view
                $this->view('books/v-editbooks', $data);
            }


        } else {

            $book = $this->bookModel->getBooksById($book_id);

            //check the onwer
            if ($book->book_owner_id != $_SESSION['user_id']) {
                redirect('Pages/parentView');
            }
            $data = [
                'bookid' => $book_id,
                'booktitle' => $book->book_title,
                'author' => $book->book_author,
                'genre' => $book->book_genre,
                'bookcondition' => $book->book_condition,
                'price' => $book->book_price,
                'bookoption' => $book->listing_type,
                'publisher' => $book->book_publisher,
                'year' => $book->book_published_year,
                'isbn' => $book->book_ISBN,


                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => ''


            ];

            $this->view('books/v_editbooks', $data);
        }



    }

    public function delete($book_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //get book from model
            $book = $this->bookModel->getBooksById($book_id);

            //check if the book belongs to the logged in user
            if ($book->book_owner_id != $_SESSION['user_id']) {
                redirect('Pages/parentView');
            }
            if ($this->bookModel->delete($book_id)) {
                flash('post_msg', 'Book deleted successfully!');
                redirect('books/index');
            } else {
                die("Something went wrong while deleting this book");
            }
        } else {
            redirect('books/index');
        }
    }

    public function search()
    {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';

        $books = $this->bookModel->searchBooks($query);

        // Set a flash message if no books found
        if (empty($books)) {
            flash('post-msg', 'No books found matching your search.');
        }

        $data = [
            'books' => $books,
            'search_query' => $query
        ];

        $this->view('books/v_searchbooks', $data);
    }

    public function category()
    {
        $category = isset($_GET['name']) ? trim($_GET['name']) : '';

        $books = $this->bookModel->getBooksByCategory($category);

        $data = [
            'books' => $books,
            'category' => $category
        ];

        $this->view('books/v_categorybooks', $data);
    }
    public function book_preview($book_id) {
        // Fetch the book by its ID
        $book = $this->bookModel->getBooksById($book_id);
        $userId = $_SESSION['user_id'] ?? null;
        $transaction = null;
    
        // Fetch the transaction if the user is logged in
        if ($userId) {
            // Pass the book_id, not the entire $book object
            $transaction = $this->transactionModel->getTransactionByBookAndUser($book_id, $userId);
        }
    
        // Prepare the data to be passed to the view
        $data = [
            'books' => $book,
            'transactions' => $transaction
        ];
    
        // Load the view
        $this->view('books/v_previewbooks', $data);
    }
    
    public function swapbook($bookId) {
        // Get book owner (receiver) ID
        $book = $this->bookModel->getBooksById($bookId);
        $receiverId = $book->book_owner_id;
        $bookTitle = $this->bookModel->getBookTitleByBookId($bookId)->book_title;
    
        // Insert into transaction table
        $newTransactionId = $this->transactionModel->createSwapTransaction(
            $bookId,
            $_SESSION['user_id'], // buyer/swap initiator
            $receiverId
        );
    
        // Add to notification table
        $message = $_SESSION['user_name'] . " has requested to swap the book titled '" . $bookTitle . "' with you.";
        $this->notificationModel->createNotification([
            'user_id' => $receiverId,
            'message' => $message,
            'transaction_id' => $newTransactionId,
        ]);
    
        flash('post_msg', 'Book swap request sent successfully!');
        redirect('books/v_previewbooks');
    }

    public function acceptswaprequest($book_id, $transaction_id){
        //approve selected transaction
        $approve=$this->bookModel->acceptSwapRequest($book_id, $transaction_id);

        //decline other transaction for same book
        $decline=$this->bookModel->deleteSwapRequest($book_id, $transaction_id);

        //mark book as unavailable
        $unavailable=$this->bookModel->updateBookStatusSwapRequest($book_id);

        //notify requester

        //redirect

        $data = [
            'approve' => $approve,
            'decline' => $decline,
            'unavailable' => $unavailable
        ];
    
        flash('post_msg', 'Swap request accepted and other requests declined.');
        $this->view('users/notifications', $data);
       
    }

    public function deleteswaprequest(){
        
    }
    







}

?>