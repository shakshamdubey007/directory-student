<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $batch = $_POST['batch'];
    $father_name = $_POST['father_name'];

    if ($_FILES['photo']['name']) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    } else {
        $photo = $student['photo'];
    }

    $stmt = $conn->prepare("UPDATE students SET name=?, roll_no=?, email=?, phone=?, batch=?, photo=?, father_name=? WHERE id=?");
    $stmt->bind_param("ssssissi", $name, $roll_no, $email, $phone, $batch, $photo, $father_name, $id);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>

<!-- HTML Form -->
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= $student['name'] ?>" required><br>
    <input type="text" name="roll_no" value="<?= $student['roll_no'] ?>" required><br>
    <input type="email" name="email" value="<?= $student['email'] ?>"><br>
    <input type="text" name="phone" value="<?= $student['phone'] ?>"><br>
    <input type="number" name="batch" value="<?= $student['batch'] ?>" required><br>
    <input type="text" name="father_name" value="<?= $student['father_name'] ?>"><br>
    <input type="file" name="photo"><br>
    <button type="submit">Update Student</button>
</form>
