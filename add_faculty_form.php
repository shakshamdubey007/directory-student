<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = 'uploads/' . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo);

    $stmt = $conn->prepare("INSERT INTO faculty (name, designation, department, phone, email, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $designation, $department, $phone, $email, $photo);
    $stmt->execute();

    header("Location: faculty_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
     <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2 style="text-align: center; margin-bottom: 30px;">Add New Faculty Member</h2>
    <div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Designation:</label>
        <input type="text" name="designation" required><br>

        <label>Department:</label>
        <input type="text" name="department" required><br>

        <label>Phone:</label>
        <input type="text" name="phone" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Photo:</label>
        <input type="file" name="photo" required><br>
        
        <button type="submit">Add Faculty</button>
    </form>
</div>
</body>
</html>
