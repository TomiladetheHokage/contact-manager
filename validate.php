<?php


function validateContact($id, $name, $email, $phone, PDO $conn) {
    $name = trim($name);
    $email = trim($email);
    $phone = trim($phone);

    if (empty($name) || strlen($name) < 2) {
        throw new Exception("Name is required and must be at least 2 characters.");
    } elseif (!preg_match("/^[a-zA-Z\s.'-]+$/", $name)) {
        throw new Exception("Name can only contain letters, spaces, dots, hyphens, or apostrophes.");
    }

    if (
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !preg_match('/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,10}$/', $email)
    ) {
        throw new Exception("Invalid email format.");
    }
     

    if (!preg_match("/^\d{10,15}$/", $phone)) {
        throw new Exception("Invalid phone number format.");
    } else {
        $stmt = $conn->prepare("SELECT * FROM contacts WHERE phone = ? AND id != ?");
        $stmt->execute([$phone, $id]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Phone number already exists.");
        }
    } 
}

function validatePhoneNumber($name, $email, $phone, $conn, $id = null) {
    validateContact($id, $name, $email, $phone, $conn);

    $stmt = $conn->prepare("SELECT id FROM contacts WHERE phone = ? AND id != ?");
    $stmt->execute([$phone, $id]);
    if ($stmt->fetch()) {
        throw new Exception("Phone number is already used by another contact.");
    }

    return true;
}

?>