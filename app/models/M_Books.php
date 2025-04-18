<?php
class M_Books{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
   
    public function create($data){
        $this->db->query('INSERT INTO book(book_title, book_author, book_genre, book_condition, book_price, listing_type, owner_id, book_publisher, book_published_year, book_ISBN) VALUES(:book_title, :book_author, :book_genre, :book_condition, :book_price,  :listing_type, :owner_id, :book_publisher, :book_published_year, :book_ISBN )');
        $this->db->bind(':book_title',$data['booktitle']);
        $this->db->bind(':book_author',$data['author']);
        $this->db->bind(':book_genre',$data['genre']);
        $this->db->bind(':book_condition',$data['bookcondition']);
        $this->db->bind(':book_price',$data['price']);
        $this->db->bind(':listing_type',$data['bookoption']);
        $this->db->bind(':owner_id',$_SESSION['user_id']);
        $this->db->bind(':book_publisher',$data['publisher']);
        $this->db->bind(':book_published_year',$data['year']);
        $this->db->bind(':book_ISBN',$data['isbn']);

        //Execute
        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function getBooks(){
        $this->db->query('SELECT * FROM v_books');
        $results=$this->db->resultSet();
        return $results;
    }

    public function getBooksById($book_id){
        $this->db->query('SELECT * FROM v_books WHERE book_id = :book_id');
        $this->db->bind(':book_id',$book_id);

        $row = $this->db->single();
        return $row;
    }
    public function update($data){
        $this->db->query('UPDATE book SET book_title = :book_title , book_author = :book_author, book_genre = :book_genre, book_condition= :book_condition, book_price =:book_price, listing_type = :listing_type, book_publisher = :book_publisher, book_published_year = :book_published_year, book_ISBN = :book_ISBN WHERE book_id = :book_id AND owner_id = :owner_id');
        $this->db->bind(':book_title',$data['booktitle']);
        $this->db->bind(':book_author',$data['author']);
        $this->db->bind(':book_genre',$data['genre']);
        $this->db->bind(':book_condition',$data['bookcondition']);
        $this->db->bind(':book_price',$data['price']);
        $this->db->bind(':listing_type',$data['bookoption']);
        $this->db->bind(':owner_id',$_SESSION['user_id']);
        $this->db->bind(':book_id',$data['bookid']);
        $this->db->bind(':book_publisher',$data['publisher']);
        $this->db->bind(':book_published_year',$data['year']);
        $this->db->bind(':book_ISBN',$data['isbn']);

        //Execute
        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function delete($id) {
        $this->db->query('DELETE FROM book WHERE book_id = :id');
        $this->db->bind(':id', $id);
    
        return $this->db->execute();
    }

    public function searchBooks($query)
{
    $this->db->query("SELECT * FROM book WHERE book_title LIKE :query OR book_author LIKE :query OR book_genre LIKE :query OR book_publisher LIKE :query");
    $this->db->bind(':query', '%' . $query . '%');
    return $this->db->resultSet();
}

public function getBooksByCategory($category) {
    $this->db->query("SELECT * FROM book WHERE book_genre = :category");
    $this->db->bind(':category', $category);
    return $this->db->resultSet();
}
}

    
?>