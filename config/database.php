<?php
$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$username = $env['DB_USER'];
$dbpass = $env['DB_PASSWORD'];


function getPDOconnection (){
    global $host, $dbname, $username, $dbpass;
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch (PDOException $e) {
        die("connection failed: " . $e->getMessage());

    }
}

// $connection = getPdoconnection();
// if ($connection) {
//     echo "Connected to the database successfully bro!" . "<br>";
//     echo "PHP Version: ";
//     echo phpversion();
    
// } else {
//     echo "Failed to connect to the database.";
// }


?>



<!-- localhost\contatct-manager2\config\database.php -->

