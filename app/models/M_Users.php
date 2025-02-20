<?php
class M_Users{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
    public function findUserByEmail($email){
       $this->db->query('SELECT * FROM user WHERE user_email= :email');
       $this->db->bind(':email',$email);

       $row=$this->db->single();

       if($this->db->rowCount()>0){
          return true;
       }
       else{
        return false;
       }
    }

    public function registerUser($data){
        $this->db->query('INSERT INTO user(user_name,user_email,user_password, user_NIC, user_phone, user_address) VALUES (:user_name, :user_email, :user_password, :user_NIC, :user_phone, :user_address) ');
        $this->db->bind(':user_name',$data['name']);
        $this->db->bind(':user_email',$data['email']);
        $this->db->bind(':user_password',$data['password']);
        $this->db->bind(':user_NIC',$data['nic']);
        $this->db->bind(':user_phone',$data['contactNumber']);
        $this->db->bind(':user_address',$data['address']);

        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }

    }

}
?>