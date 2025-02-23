<?php
class Books extends Controller{
    private $bookModel;

    public function __construct(){
        $this->bookModel=$this->model('M_Books');
        
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
    
                'book_title_err' => '',
                'book_author_err' => '',
                'book_genre_err' => '',
                'book_condition_err' => '',
                'book_price_err' => '',
                'book_option_err' => ''
    
    
                ];

                //validation
                if(empty($data['booktitle'])){
                    $data['book_title_err']="Please enter a title";

                }


        }
        else{
            $data=[
            'title' => '',
            'author' => '',
            'genre' => '',
            'bookcondition'=> '',
            'price' => '',
            'bookoption' => '',

            'book_title_err' => '',
            'book_author_err' => '',
            'book_genre_err' => '',
            'book_condition_err' => '',
            'book_price_err' => '',
            'book_option_err' => ''


            ];

            $this->view('books/v_create',$data);
        }

       
        
    }
}

?>