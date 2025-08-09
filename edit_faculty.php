<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM faculty WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = 'uploads/' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    } else {
        $photo = $faculty['photo'];
    }

    $stmt = $conn->prepare("UPDATE faculty SET name=?, designation=?, department=?, phone=?, email=?, photo=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $designation, $department, $phone, $email, $photo, $id);
    $stmt->execute();

    header("Location: faculty_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
</head>
<body>
    <h2>Edit Faculty Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><input type="text" name="name" value="<?= $faculty['name'] ?>" required><br>
        <label>Designation:</label><input type="text" name="designation" value="<?= $faculty['designation'] ?>" required><br>
        <label>Department:</label><input type="text" name="department" value="<?= $faculty['department'] ?>" required><br>
        <label>Phone:</label><input type="text" name="phone" value="<?= $faculty['phone'] ?>" required><br>
        <label>Email:</label><input type="email" name="email" value="<?= $faculty['email'] ?>" required><br>
        <label>Photo:</label><input type="file" name="photo"><br>
        <button type="submit">Update Faculty</button>
    </form>
</body>
</html>
