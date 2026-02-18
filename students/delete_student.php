<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete record
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: view_students.php?msg=deleted");
    exit;
} else {
    header("Location: view_students.php");
    exit;
}
?>
