<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=select_events.php');
}

if (isset($_GET['err'])) {
    $error_message = $_GET['err'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Events - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
    <div style="margin-left: 400px;margin-top:350px"> 
    <a style=" padding:70px; background-color:#007bff; color:white;" href="select_events1.php">Audience</a> 
    </div>

    <div style="margin-left: 1000px;margin-top:-30px"> 
    <a style=" padding:70px; background-color:#007bff; color:white;" href="select_events.php">Participate</a> 
    </div>

    
    
</body>