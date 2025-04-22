<?php


require_once __DIR__ . '/../model/contactModel.php';
require_once __DIR__ . '/../validate.php';
require_once __DIR__ . '/../config/database.php';

$connection = getPdoconnection();

class ContactController {
    private $contactController;
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->contactController = new ContactModel($connection);
    }

    public function getAllContacts() {
        return $this->contactController->getAllcontacts();
    }

    public function getContact($id) {
        return $this->contactController->getContact($id);
    }

    public function addContact($name, $email, $phone) {
        try{    
            validateContact($id = null, $name, $email, $phone, $this->connection);
            return $this->contactController->addContact($id=null, $name, $email, $phone);
        } catch (Exception $e) {
            header("Location: index.php?action=create&error=" . urlencode($e->getMessage()));
        }
    }

    public function updateContact($name, $email, $phone,  $id) {
        try{
            validateContact($id, $name, $email, $phone, $this->connection);
            return $this->contactController->updateContact($name, $email, $phone, $id);
        } catch (Exception $e) {
            header("Location: index.php?action=contactList&error=" . urlencode($e->getMessage()) . "&modal=false");
        }
    } 

    public function deleteContact($id) {
        return $this->contactController->deleteContact($id);
    }



    public function getContactCount() {
        return $this->contactController->getContactCount();
    }   


}




?>