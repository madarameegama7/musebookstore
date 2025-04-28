<?php

require_once __DIR__ . '/../Admin.php';

class BookAdminController extends Admin
{

    // Book Management
    public function manageBooks()
    {
        // This method handles the page load and search via GET parameter.
        $searchTerm = $_GET['search'] ?? null;
        $books = [];

        if ($searchTerm) {
            $searchTerm = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
            // Trim the search term
            $searchTerm = trim($searchTerm);
            // Only search if the trimmed term is not empty
            if (!empty($searchTerm)) {
                $books = $this->adminModel->searchBooks($searchTerm);
            } else {
                // If search term is empty after trimming, show all books
                $books = $this->adminModel->getAllBooks();
                $searchTerm = null; // Reset searchTerm to null if it was just whitespace
            }
        } else {
            $books = $this->adminModel->getAllBooks();
        }

        $data = [
            'title' => 'Manage Books',
            'books' => $books,
            'searchTerm' => $searchTerm
        ];
        $this->view('pages/admin/v_manage_books', $data);
    }

    // View Book Details
    public function viewBook($bookId)
    {
        $book = $this->adminModel->getBookById($bookId);
        if (!$book) {
            Alert_Helper::error('Book not found', 'The requested book does not exist.');
            redirect('admin/book/manageBooks');
        }
        $data = [
            'title' => 'View Book: ' . ($book->book_title ?? 'N/A'),
            'book' => $book
        ];
        $this->view('pages/admin/v_view_book', $data);
    }

    // Show Edit Book Form
    public function editBook($bookId)
    {
        $book = $this->adminModel->getBookById($bookId);
        if (!$book) {
            Alert_Helper::error('Book not found', 'The requested book does not exist.');
            redirect('admin/book/manageBooks');
        }

        $data = [
            'title' => 'Edit Book: ' . $book->book_title,
            'bookid' => $bookId,
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
        $this->view('pages/admin/v_edit_book', $data);
    }

    // Handle Update Book Submission
    public function updateBook($bookId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Fetch original book data in case of errors
            $originalBook = $this->adminModel->getBookById($bookId);
            if (!$originalBook) {
                Alert_Helper::error('Book not found', 'The requested book does not exist.');
                redirect('admin/book/manageBooks');
                return;
            }

            $data = [
                'bookid' => $bookId,
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),
                'title' => 'Edit Book: ' . $originalBook->book_title, // Keep title for view reload
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

            // Validation (similar to Books controller create/edit)
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";
            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";
            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please select genre";
            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";
            }
            if (empty($data['price']) && $data['price'] !== '0') {
                $data['book_price_err'] = "Please enter a price";
            } // Allow 0 price?
            elseif (!is_numeric($data['price']) || $data['price'] < 0) {
                $data['book_price_err'] = "Please enter a valid price";
            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";
            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";
            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";
            } elseif (!is_numeric($data['year']) || strlen($data['year']) != 4) {
                $data['book_year_err'] = "Please enter a valid year (YYYY)";
            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";
            }
            // Add more specific ISBN validation if needed

            // If no errors, attempt update
            if (
                empty($data['book_title_err']) && empty($data['book_author_err']) && empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) && empty($data['book_price_err']) && empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) && empty($data['book_year_err']) && empty($data['book_isbn_err'])
            ) {

                if ($this->adminModel->updateBook($data)) {
                    Alert_Helper::success('Success', 'Book details updated successfully.');
                    redirect('admin/book/manageBooks'); // Or redirect('admin/book/viewBook/' . $bookId);
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update book details.');
                    $this->view('pages/admin/v_edit_book', $data); // Reload form with error
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_edit_book', $data);
            }
        } else {
            // Not a POST request, redirect
            redirect('admin/book/manageBooks');
        }
    }

    // Show Add Book Form (GET) / Handle Add Book Submission (POST)
    public function createBook()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition' => trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher' => trim($_POST['publisher']),
                'year' => trim($_POST['year']),
                'isbn' => trim($_POST['isbn']),
                'owner_id' => trim($_POST['owner_id']), // Get owner from form
                'title' => 'Add New Book',
                'users' => $this->adminModel->getAllUsers(), // For owner dropdown reload on error
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'owner_id_err' => ''
            ];

            // Validation (similar to editBook/Books controller)
            if (empty($data['booktitle'])) {
                $data['book_title_err'] = "Please enter a title";
            }
            if (empty($data['author'])) {
                $data['book_author_err'] = "Please enter author name";
            }
            if (empty($data['genre'])) {
                $data['book_genre_err'] = "Please select genre";
            }
            if (empty($data['bookcondition'])) {
                $data['book_condition_err'] = "Please select book condition";
            }
            if (empty($data['price']) && $data['price'] !== '0') {
                $data['book_price_err'] = "Please enter a price";
            } elseif (!is_numeric($data['price']) || $data['price'] < 0) {
                $data['book_price_err'] = "Please enter a valid price";
            }
            if (empty($data['bookoption'])) {
                $data['book_option_err'] = "Please select an option";
            }
            if (empty($data['publisher'])) {
                $data['book_publisher_err'] = "Please enter publisher name";
            }
            if (empty($data['year'])) {
                $data['book_year_err'] = "Please enter published year";
            } elseif (!is_numeric($data['year']) || strlen($data['year']) != 4) {
                $data['book_year_err'] = "Please enter a valid year (YYYY)";
            }
            if (empty($data['isbn'])) {
                $data['book_isbn_err'] = "Please enter ISBN";
            }
            if (empty($data['owner_id'])) {
                $data['owner_id_err'] = "Please select an owner";
            } else {
                // Optional: Validate owner exists
                $ownerUser = $this->adminModel->getUserById($data['owner_id']);
                if (!$ownerUser) {
                    $data['owner_id_err'] = 'Invalid owner selected';
                }
            }

            // If no errors, attempt create
            if (
                empty($data['book_title_err']) && empty($data['book_author_err']) && empty($data['book_genre_err']) &&
                empty($data['book_condition_err']) && empty($data['book_price_err']) && empty($data['book_option_err']) &&
                empty($data['book_publisher_err']) && empty($data['book_year_err']) && empty($data['book_isbn_err']) && empty($data['owner_id_err'])
            ) {

                if ($this->adminModel->createBook($data)) {
                    Alert_Helper::success('Success', 'New book added successfully.');
                    redirect('admin/book/manageBooks');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add book.');
                    $this->view('pages/admin/v_add_book', $data); // Reload form with error
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_add_book', $data);
            }
        } else {
            // Display empty form (GET request)
            $users = $this->adminModel->getAllUsers(); // Fetch users for owner dropdown
            $data = [
                'booktitle' => '',
                'author' => '',
                'genre' => '',
                'bookcondition' => '',
                'price' => '',
                'bookoption' => '',
                'publisher' => '',
                'year' => '',
                'isbn' => '',
                'owner_id' => '',
                'title' => 'Add New Book',
                'users' => $users, // Pass users to the view
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => '',
                'book_publisher_err' => '',
                'book_year_err' => '',
                'book_isbn_err' => '',
                'owner_id_err' => ''
            ];
            $this->view('pages/admin/v_add_book', $data);
        }
    }

    // Delete Book (Handles POST request for confirmation)
    public function deleteBook($bookId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure book exists
            $book = $this->adminModel->getBookById($bookId);
            if (!$book) {
                Alert_Helper::warning('Book not found', 'Book not found or already deleted.');
                redirect('admin/book/manageBooks');
                return;
            }

            if ($this->adminModel->deleteBookById($bookId)) {
                Alert_Helper::success('Success', 'Book deleted successfully.');
                redirect('admin/book/manageBooks');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete book.');
                redirect('admin/book/manageBooks');
            }
        } else {
            // If accessed via GET, redirect
            redirect('admin/book/manageBooks');
        }
    }
}
