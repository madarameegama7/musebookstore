<?php
class M_Books{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
   
    public function create($data){
        $this->db->query('INSERT INTO book(book_title, book_author, book_genre, book_condition, book_price, listing_type, owner_id, book_publisher, book_published_year, book_ISBN, book_image, child_safe) 
        VALUES(:book_title, :book_author, :book_genre, :book_condition, :book_price,  :listing_type, :owner_id, :book_publisher, :book_published_year, :book_ISBN, :book_image, :child_safe)');
        $this->db->bind(':book_image',$data['book_image_name']);
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
        $this->db->bind(':child_safe',$data['childsafe']);


        //Execute
        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function getBooks($limit = null){
        // Query from the book table directly instead of the v_books view
        if ($limit) {
            $this->db->query('SELECT * FROM book ORDER BY created_at DESC LIMIT :limit');
            $this->db->bind(':limit', $limit);
        } else {
            $this->db->query('SELECT * FROM book ORDER BY created_at DESC');
        }
        
        $results = $this->db->resultSet();
        return $results;
    }
    public function getChildBooks($limit = null) {
        if ($limit) {
            $this->db->query("SELECT * FROM book WHERE child_safe = 'Yes' ORDER BY created_at DESC LIMIT :limit");
            $this->db->bind(':limit', $limit);
        } else {
            $this->db->query('SELECT * FROM book ORDER BY created_at DESC');
        }
        
        // Get the results and return them
        $results = $this->db->resultSet();
        return $results;
    }
    

    public function getBooksById($book_id){
        $this->db->query('SELECT * FROM book WHERE book_id = :book_id');
        $this->db->bind(':book_id',$book_id);

        $row = $this->db->single();
        return $row;
    }

    public function getBooksByUserId($user_id){
        $this->db->query('SELECT * FROM v_books WHERE owner_id = :user_id');
        $this->db->bind(':user_id',$user_id);

        return $this->db->resultSet();
    }
    public function getBookTitleByBookId($book_id){
        $this->db->query('SELECT book_title FROM v_books WHERE book_id = :book_id');
        $this->db->bind(':book_id',$book_id);

        $row = $this->db->single();
        return $row;

    }
    public function getBookTitleByOwnerId($user_id){
        $this->db->query('SELECT book_title FROM v_books WHERE owner_id = :user_id');
        $this->db->bind(':user_id',$user_id);

        $results=$this->db->resultSet();
        return $results;

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
public function acceptSwapRequest($book_id, $transaction_id) {
    $this->db->query("UPDATE transaction SET status = 'approved' WHERE book_id = :book_id AND transaction_id = :transaction_id ");
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':transaction_id', $transaction_id);

    return $this->db->execute();
}
public function deleteSwapRequest($book_id, $approved_transaction_id) {
    $this->db->query("UPDATE transaction 
                      SET status = 'declined' 
                      WHERE book_id = :book_id AND transaction_id != :transaction_id");
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':transaction_id', $approved_transaction_id);
    return $this->db->execute();
}

public function updateBookStatusSwapRequest($book_id){
    $this->db->query("UPDATE book SET book_status = 'swapped' WHERE book_id = :book_id");
    $this->db->bind(':book_id', $book_id);
    return $this->db->execute();
}
}

    
?>