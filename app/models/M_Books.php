<?php
class M_Books{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
   
    public function create($data){
        $this->db->query('INSERT INTO book(book_title, book_author, book_genre, book_condition, book_price, listing_type, owner_id ) VALUES(:book_title, :book_author, :book_genre, :book_condition, :book_price,  :listing_type, :owner_id )');
        $this->db->bind(':book_title',$data['booktitle']);
        $this->db->bind(':book_author',$data['author']);
        $this->db->bind(':book_genre',$data['genre']);
        $this->db->bind(':book_condition',$data['bookcondition']);
        $this->db->bind(':book_price',$data['price']);
        $this->db->bind(':listing_type',$data['bookoption']);
        $this->db->bind(':owner_id',$_SESSION['user_id']);

        //Execute
        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function getBooks(){
        
    }

}
?>