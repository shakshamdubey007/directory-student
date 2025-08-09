<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $batch = $_POST['batch'];
    $father_name = $_POST['father_name'];

    $photo = 'uploads/' . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo);

    $stmt = $conn->prepare("INSERT INTO students (name, roll_no, email, phone, batch, photo, father_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $name, $roll_no, $email, $phone, $batch, $photo, $father_name);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
