<?php
class Books extends Controller{
    private $bookModel;

    public function __construct(){
        $this->bookModel=$this->model('M_Books');
        
    }
    public function loadView(){
        $data=[];
        $this->view('books/v_displaybooks',$data);
    }
    public function index() {
        $books=$this->bookModel->getBooks();
        $data=[
            'books'=>$books
        ];
        $this->view('books/v_displaybooks',$data);
    }
    
    public function create(){


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST=filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data=[
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition'=> trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher'=>trim($_POST['publisher']),
                'year'=>trim($_POST['year']),
                'isbn'=>trim($_POST['isbn']),
    
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
                if(empty($data['booktitle'])){
                    $data['book_title_err']="Please enter a title";

                }
                if(empty($data['author'])){
                    $data['book_author_err']="Please enter author name";

                }
                if(empty($data['genre'])){
                    $data['book_genre_err']="Please enter genre";

                }
                if(empty($data['bookcondition'])){
                    $data['book_condition_err']="Please select book condition";

                }
                if(empty($data['price'])){
                    $data['book_price_err']="Please enter a price";

                }
                if(empty($data['bookoption'])){
                    $data['book_option_err']="Please select an option";

                }
                if(empty($data['publisher'])){
                    $data['book_publisher_err']="Please enter publisher name";

                }
                if(empty($data['year'])){
                    $data['book_year_err']="Please enter published year";

                }
                if(empty($data['isbn'])){
                    $data['book_isbn_err']="Please enter ISBN";

                }


                if(empty($data['book_title_err']) && 
                empty($data['book_author_err']) && 
                empty($data['book_genre_err']) && 
                empty($data['book_condition_err']) && 
                empty($data['book_price_err']) && 
                empty($data['book_option_err']) &&
                empty($data['publisher']) &&
                empty($data['year']) &&
                empty($data['isbn'])){
                    if($this->bookModel->create($data)){
                        flash('post_msg','Book added successfully!');
                        redirect('books/index');
                        
                    }
                    else{
                        die("Something went wrong");
                    }
                }
                else{
                    //load errros with view
                    $this->view('books/v-create', $data);
                }


        }
        else{
            $data=[
            'booktitle' => '',
            'author' => '',
            'genre' => '',
            'bookcondition'=> '',
            'price' => '',
            'bookoption' => '',
            'publisher'=> '',
            'year'=> '',
            'isbn'=> '',
    

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

            $this->view('books/v_create',$data);
        }

       
        
    }
    public function show(){
        $books=$this->bookModel->getBooks();
        $data=[
            'books'=>$books
        ];
        $this->view('books/v_displaybooks',$data);

        
    }

    public function edit($book_id){


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST=filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data=[
                'bookid'=>$book_id,
                'booktitle' => trim($_POST['booktitle']),
                'author' => trim($_POST['author']),
                'genre' => trim($_POST['genre']),
                'bookcondition'=> trim($_POST['bookcondition']),
                'price' => trim($_POST['price']),
                'bookoption' => trim($_POST['bookoption']),
                'publisher'=>trim($_POST['publisher']),
                'year'=>trim($_POST['year']),
                'isbn'=>trim($_POST['isbn']),
    
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
                if(empty($data['booktitle'])){
                    $data['book_title_err']="Please enter a title";

                }
                if(empty($data['author'])){
                    $data['book_author_err']="Please enter author name";

                }
                if(empty($data['genre'])){
                    $data['book_genre_err']="Please enter genre";

                }
                if(empty($data['bookcondition'])){
                    $data['book_condition_err']="Please select book condition";

                }
                if(empty($data['price'])){
                    $data['book_price_err']="Please enter a price";

                }
                if(empty($data['bookoption'])){
                    $data['book_option_err']="Please select an option";

                }
                if(empty($data['publisher'])){
                    $data['book_publisher_err']="Please enter publisher name";

                }
                if(empty($data['year'])){
                    $data['book_year_err']="Please enter published year";

                }
                if(empty($data['isbn'])){
                    $data['book_isbn_err']="Please enter ISBN";

                }
                if(empty($data['book_title_err']) && 
                empty($data['book_author_err']) && 
                empty($data['book_genre_err']) && 
                empty($data['book_condition_err']) && 
                empty($data['book_price_err']) && 
                empty($data['book_option_err']) &&
                empty($data['publisher']) &&
                empty($data['year']) &&
                empty($data['isbn']) ){
                    if($this->bookModel->update($data)){
                        flash('post_msg', 'Book is updated');
                        redirect('books/index');
                        
                    }
                    else{
                        die("Something went wrong");
                    }
                }
                else{
                    //load errros with view
                    $this->view('books/v-editbooks', $data);
                }


        }
        else{

            $book=$this->bookModel->getBooksById($book_id);

            //check the onwer
            if($book->user_id != $_SESSION['user_id']){
                redirect('Pages/parentView');
            }
            $data=[
            'bookid'=>$book_id,
            'booktitle' => $book->book_title,
            'author' => $book->book_author,
            'genre' => $book->book_genre,
            'bookcondition'=> $book->book_condition,
            'price' => $book->book_price,
            'bookoption' => $book->listing_type,
            'publisher'=> $book->book_publisher,
            'year'=> $book->book_published_year,
            'isbn'=>$book->book_ISBN,


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

            $this->view('books/v_editbooks',$data);
        }

       
        
    }

    public function delete($book_id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //get book from model
            $book=$this->bookModel->getBooksById($book_id);

            //check if the book belongs to the logged in user
            if($book->user_id != $_SESSION['user_id']){
                redirect('Pages/parentView');
            }
            if($this->bookModel->delete($book_id)){
                flash('post_msg', 'Book deleted successfully!');
                redirect('books/index');
            }
            else{
                die("Something went wrong while deleting this book");
            }
        }else{
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

    public function category() {
        $category = isset($_GET['name']) ? trim($_GET['name']) : '';
    
        $books = $this->bookModel->getBooksByCategory($category);
    
        $data = [
            'books' => $books,
            'category' => $category
        ];
    
        $this->view('books/v_categorybooks', $data);
    }
    
    
    

    

    
}

?>