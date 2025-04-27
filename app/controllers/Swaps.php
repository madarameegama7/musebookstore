<?php
class Swaps extends Controller {

    private $bookModel;

    public function __construct()
    {
        $this->bookModel = $this->model('M_Books');

    }

public function chooseBook($bookId) {
    // Load user's own books to offer in swap
    $userId = $_SESSION['user_id'];
    $userBooks = $this->bookModel->getBooksByUserId($userId);

    $data = [
        'bookToSwapWith' => $bookId,
        'userBooks' => $userBooks
    ];

    $this->view('books/v_choosebooks', $data);
}
}