<?php
// Database credentials
$host = "sql203.infinityfree.com";      // Usually localhost
$db_name = "if0_40293878_hostel_db";   // Jo database humne Step 1 me banaya
$username = "if0_40293878";       // XAMPP default
$password = "Jyss7WzWWjxOWl";           // XAMPP default password empty hota hai

try {
    // PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connection success (optional, remove in production)
    // echo "Connected successfully";
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
