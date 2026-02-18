<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete room
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: view_rooms.php?msg=deleted");
    exit;
} else {
    header("Location: view_rooms.php");
    exit;
}
?>
