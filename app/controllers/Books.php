<?php
class Books extends Controller
{
    private $bookModel;
    private $transactionModel;
    private $notificationModel;
    private $userModel;
    private $paymentModel;

    public function __construct()
    {
        $this->bookModel = $this->model('M_Books');
        $this->transactionModel =  $this->model('M_Transactions');
        $this->notificationModel =  $this->model('M_Notifications');
        $this->userModel=$this->model('M_Users');
        $this->paymentModel=$this->model('M_Payments');

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

    public function booktoken(){
        $userid = $_SESSION['user_id'];
        $token=null;
        $token = $this->userModel->getTokenCount($userid);
    
        $data = [
            'token' => $token
        ];
        $this->view('books/v_booktoken', $data);

    }
    public function tokenpayment(){
        $data = [];
        $this->view('books/v_booktokenpay', $data);

    }
   
    public function payherenotify() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Initialize payments model
                $paymentModel = $this->model('M_Payments');
    
                // Retrieve and sanitize data
                $paymentData = [
                    'merchant_id' => trim($_POST["merchant_id"] ?? ''),
                    'order_id' => trim($_POST["order_id"] ?? ''),
                    'user_id' => trim($_POST["user_id"] ?? ''),
                    'payment_id' => trim($_POST["payment_id"] ?? ''),
                    'amount' => (float)($_POST["payhere_amount"] ?? 0),
                    'currency' => trim($_POST["payhere_currency"] ?? 'LKR'),
                    'status_code' => (int)($_POST["status_code"] ?? 0),
                    'status' => trim($_POST["status"] ?? 'Pending'),
                    'md5sig' => trim($_POST["md5sig"] ?? '')
                ];
    
                // Get merchant secret from model
                $merchantSecret = $paymentModel->getMerchantSecret();
    
                // Validate hash
                $localHash = $this->generatePayhereHash(
                    $paymentData['merchant_id'],
                    $paymentData['order_id'],
                    $paymentData['amount'],
                    $paymentData['currency'],
                    $paymentData['status_code'], // Include status code
                    
                );
    
                if ($this->validateSignature($localHash, $paymentData['md5sig'])) {
                    if ($paymentData['status_code'] === 2) {
                        $paymentRecord = [
                            'order_id' => $paymentData['order_id'],
                            'payment_id' => $paymentData['payment_id'],
                            'user_id' => $paymentData['user_id'],
                            'amount' => $paymentData['amount'],
                            'currency' => $paymentData['currency'],
                            'status' => $paymentData['status']
                        ];

                    }
                    http_response_code(200);
                } else {
                    error_log("Hash mismatch. Received: {$paymentData['md5sig']} | Calculated: $localHash");
                    http_response_code(403);
                }
            } catch (Exception $e) {
                error_log("Payment error: " . $e->getMessage());
                http_response_code(500);
            }
        } else {
            http_response_code(405);
        }
    }
    
    private function generatePayhereHash($merchant_id, $order_id, $amount, $currency, $merchant_secret) {
        return strtoupper(md5(
            $merchant_id .
            $order_id .
            number_format($amount, 2, '.', '') .
            $currency .
            strtoupper(md5($merchant_secret))
        ));
    }
    
    private function validateSignature($generated, $received) {
        return hash_equals($generated, $received);
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
                'childsafe' => trim($_POST['childsafe']),

                'book_image_err' => '',
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'childsafe_err' => ''



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
            if (empty($data['price']) || !is_numeric($data['price'])) {
                $data['book_price_err'] = "Please enter a price";

            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";

            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";

            }
            if (empty($data['year']) || !preg_match('/^\d{4}$/',$data['year']) ) {
                $data['book_year_err'] = "Please enter a valid 4-digit year";

            }elseif(!empty($data['year']) && ($data['year'] < 1500 || $data['year'] > date('Y'))){
                $data['book_year_err'] = "Please enter realistic published year";

            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";

            }
            if (empty($data['childsafe'])) {
                $data['childsafe_err'] = "Please select child safe or not";

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
                empty($data['book_isbn_err']) &&
                empty($data['childsafe_err'])
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
                'childsafe' => '',

                'book_image_err' => '',
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'childsafe_err' => ''


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
            if ($book->owner_id != $_SESSION['user_id']) {
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
            if ($book->owner_id != $_SESSION['user_id']) {
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
        $owner=$this->userModel->findUserByBookId($book_id);
    
        // Fetch the transaction if the user is logged in
        if ($userId) {
            // Pass the book_id, not the entire $book object
            $transaction = $this->transactionModel->getTransactionByBookAndUser($book_id, $userId);
        }
    
        // Prepare the data to be passed to the view
        $data = [
            'books' => $book,
            'transactions' => $transaction,
            'owner'=>$owner
        ];
    
        // Load the view
        $this->view('books/v_previewbooks', $data);
    }
    
    public function swapbook($bookId) {
        // Get book owner (receiver) ID
        $book = $this->bookModel->getBooksById($bookId);
        $receiverId = $book->owner_id;
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
            'requester_id'=>$_SESSION['user_id'],
            'transaction_id' => $newTransactionId,
        ]);
    
        flash('post_msg', 'Book swap request sent successfully!');
        redirect('books/v_previewbooks');
    }
    public function accept($book_id, $transaction_id){
        // Get the transaction details to identify requester and owner
        $transaction = $this->transactionModel->getTransactionDetails($transaction_id);
    
        if ($transaction) {
            $requester_id = $transaction->requester_id;
            $owner_id = $transaction->owner_id;

            echo "<pre>Requester: $requester_id | Owner: $owner_id</pre>";
    
            // Deduct 1 token from requester and owner
            $this->transactionModel->deductToken($requester_id);
            $this->transactionModel->deductToken($owner_id);
        }
    
        // Approve selected transaction
        $approve = $this->bookModel->acceptSwapRequest($book_id, $transaction_id);
    
        // Decline other transactions for same book
        $decline = $this->bookModel->deleteSwapRequest($book_id, $transaction_id);
    
        // Mark book as unavailable
        $unavailable = $this->bookModel->updateBookStatusSwapRequest($book_id);
    
        // Redirect with message
        $data = [
            'approve' => $approve,
            'decline' => $decline,
            'unavailable' => $unavailable
        ];
    
        flash('post_msg', 'Swap request accepted. Tokens deducted and other requests declined.');
        $this->view('books/v_booknotifications', $data);
    }
   public function cancel($transaction_id) {
    // Get transaction details
    $transaction = $this->transactionModel->getTransactionDetails($transaction_id);

    if (!$transaction) {
        flash('post_msg', 'Transaction not found', 'alert alert-danger');
        redirect('books/bookhistory');
    }

    // Ensure the logged-in user is the requester
    if ($transaction->requester_id != $_SESSION['user_id']) {
        flash('post_msg', 'You can only cancel your own requests', 'alert alert-danger');
        redirect('books/bookhistory');
    }

    // Allow cancellation only if status is pending
    if ($transaction->status !== 'pending') {
        flash('post_msg', 'Only pending requests can be cancelled', 'alert alert-warning');
        redirect('books/bookhistory');
    }

    // Cancel the request by updating the status to 'declined'
    if ($this->transactionModel->cancelRequest($transaction_id)) {
        flash('post_msg', 'Request cancelled successfully', 'alert alert-success');
    } else {
        flash('post_msg', 'Failed to cancel the request', 'alert alert-danger');
    }

    redirect('users/notifications');
}
public function withdraw($transaction_id) {
    // Get transaction details
    $transaction = $this->transactionModel->getTransactionDetails($transaction_id);

    if (!$transaction) {
        flash('post_msg', 'Transaction not found', 'alert alert-danger');
        redirect('books/bookhistory');
    }

    // Ensure the logged-in user is the requester
    if ($transaction->requester_id != $_SESSION['user_id']) {
        flash('post_msg', 'You can only cancel your own requests', 'alert alert-danger');
        redirect('books/bookhistory');
    }

    // Allow cancellation only if status is pending
    if ($transaction->status !== 'pending') {
        flash('post_msg', 'Only pending requests can be cancelled', 'alert alert-warning');
        redirect('books/bookhistory');
    }

    // Cancel the request by updating the status to 'cancelled'
    if ($this->transactionModel->withdrawRequest($transaction_id)) {
        flash('post_msg', 'Request cancelled successfully', 'alert alert-success');
    } else {
        flash('post_msg', 'Failed to cancel the request', 'alert alert-danger');
    }

    redirect('books/bookhistory');
}


    public function makePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'cardname' => trim($_POST['cardname']),
                'cardnumber' => trim($_POST['cardnumber']),
                'cvn' => trim($_POST['cvn']),
                'amount' => 200.00,
                'user_id' => $_SESSION['user_id'],
                'currency' => 'LKR',
                'status' => 'completed',
    
                // Error fields
                'cardnameError' => '',
                'cardnumberError' => '',
                'cvnError' => '',
                'amountError' => ''
            ];
    
            // Validate Card Name
            if (empty($data['cardname'])) {
                $data['cardnameError'] = 'Please enter the cardholder\'s name.';
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $data['cardname'])) {
                $data['cardnameError'] = 'Card name can only contain letters and spaces.';
            }
    
            // Validate Card Number
            if (empty($data['cardnumber'])) {
                $data['cardnumberError'] = 'Please enter the card number.';
            } elseif (!preg_match("/^[0-9]{16}$/", $data['cardnumber'])) {
                $data['cardnumberError'] = 'Card number must be exactly 16 digits.';
            }
    
            // Validate CVN
            if (empty($data['cvn'])) {
                $data['cvnError'] = 'Please enter the CVN.';
            } elseif (!preg_match("/^[0-9]{3}$/", $data['cvn'])) {
                $data['cvnError'] = 'CVN must be exactly 3 digits.';
            }
    
            // Check if there are no errors
            if (empty($data['cardnameError']) && empty($data['cardnumberError']) && empty($data['cvnError']) && empty($data['amountError'])) {
                if ($this->paymentModel->addPayment($data)) {
                    $tokenRecord = $this->paymentModel->getTokenByUserId($data['user_id']);
                
                    if ($tokenRecord) {
                        // If record exists -> update
                        $this->paymentModel->updateToken($data['user_id'], 5, $data['amount']);
                    } else {
                        // If not -> insert new
                        $this->paymentModel->addToken($data['user_id'], 5, $data['amount']);
                    }
                
                    flash('payment_message', 'Payment successful!');
                    $this->view('books/v_booktoken', $data);
                } else {
                    die('Something went wrong while saving the payment.');
                }
            } else {
                // Reload the form with error messages
                $this->view('books/v_booktokenpay', $data);
            }
        } else {
            $data = [
                'cardname' => '',
                'cardnumber' => '',
                'cvn' => '',
                'amount' => '',
                'cardnameError' => '',
                'cardnumberError' => '',
                'cvnError' => '',
                'amountError' => ''
            ];
            $this->view('books/v_booktokenpay', $data);
        }
    }
    
    
    public function paymentSuccess()
{
    $this->view('books/paymentSuccess');
}

    
    
    







}

?>