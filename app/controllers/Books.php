<?php
class Books extends Controller{
    private $bookModel;

    public function __construct(){
        $this->bookModel=$this->model('M_Books');
        
    }
    public function loadView(){
        $data=[];
        $this->view('pages/v_index',$data);
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
                if(empty($data['book_title_err']) && empty($data['book_author_err'] && empty($data['book_genre_err']) && empty($data['book_condition_err']) && empty($data['book_price_err']) && empty($data['book_option_err']))){
                    if($this->bookModel->create($data)){
                        echo "<script>showAlert();</script>";
                        $this->loadView();
                        
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