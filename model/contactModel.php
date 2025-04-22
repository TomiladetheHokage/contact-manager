<?php

class ContactModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }  

    public function getAllcontacts(){
        $contacts = $this->conn->query("SELECT * FROM contacts ORDER BY id");
        return $contacts->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContact($id){
        $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addContact($id=null, $name, $email, $phone){
        $stmt = $this->conn->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
        $result = $stmt->execute([$name, $email, $phone]);
        return $result;
    }

    public function updateContact($name, $email, $phone , $id){
        $stmt = $this->conn->prepare("UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
        $result = $stmt->execute([$name, $email, $phone, $id]);
        return $result;
    }

    public function deleteContact($id){
        $stmt = $this->conn->prepare("DELETE FROM contacts WHERE id = ?");
        $result = $stmt->execute([$id]);
        return $result;
    }

    public function searchContacts($query){
        $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?");
        $searchQuery = "%$query%";
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContactCount(){
        $stmt = $this->conn->query("SELECT COUNT(*) FROM contacts");
        return $stmt->fetchColumn();
    }


    // public function getContactByEmail($email){
    //     $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE email = ?");
    //     $stmt->execute([$email]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // public function getContactByPhone($phone){
    //     $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE phone = ?");
    //     $stmt->execute([$phone]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // public function getContactByName($name){
    //     $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE name = ?");
    //     $stmt->execute([$name]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
}



?>