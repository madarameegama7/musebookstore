<?php
class Database{
    private $host =  DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $port=DB_PORT;
    private $dbh;
    private $statement;
    private $error;

    public function __construct(){
        $dsn = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //Instantiate PDO
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->password,$options);

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;

        }
    }
    //Prepared statement
    public function query($sql){
        $this->statement = $this->dbh->prepare($sql);

    }
    //Bind parameters
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
        }
    }
    $this->statement->bindValue($param,$value,$type);
}
//Execute the prepared statement
public function execute(){
    return $this->statement->execute();
}
public function resultSet(){
    $this->execute();
    return $this->statement->fetchAll(PDO::FETCH_OBJ);
}
//gET SINGLE Record as the single result
public function single(){
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_OBJ);
}
public function rowCount(){
    return $this->statement->rowCount();
}

/**
 * Get the ID of the last inserted record
 * This method is essential for retrieving IDs of newly created records,
 * such as when creating new articles, comments, or other database entries.
 * @return string The ID of the last inserted record
 */
public function lastInsertId(){
    return $this->dbh->lastInsertId();
}
}
?>