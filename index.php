<?php

// require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/contactController.php';

$connection = getPdoconnection();
$contactController = new ContactController($connection); 

$action = $_GET['action'] ?? "index";

switch ($action){
  case 'update':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if ($id) {
            $result = $contactController->updateContact($name, $email, $phone, $id);

            if ($result === true) {
                header('Location: index.php?action=contactList');
                exit;
            } else {
                echo "<p class='text-red-600'>Failed to update contact.</p>";
            }
        } else {
            echo "<p class='text-red-600'>Contact ID is required.</p>";
        }
    }
    break;


  case 'create':
    include __DIR__ . '/views/contactForm.php';
    break;

  case 'saveContact':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'] ?? '';
      $email = $_POST['email'] ?? '';
      $phone = $_POST['phone'] ?? '';
      
      $result = $contactController->addContact($name, $email, $phone);
  
      if ($result === true) {
          header('Location: index.php?action=contactList');
        
      } else {
          echo $result; // validation or DB error
      }
      }
      break;

  case 'delete':
      if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $contactController->deleteContact($id);
          header('Location: index.php?action=contactList');
      } else {
          echo "Contact ID is required for deletion.";
      }
      break;    

  case 'contactList':
      $contacts = $contactController->getAllContacts();
      $contactCount = $contactController->getContactCount();
      include __DIR__ . '/views/contactList.php';
      break;

      
    
  
    
}
?>
