<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Add New Student</h2>
    <form action="add_student.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="text" name="roll_no" placeholder="Roll Number" required><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="phone" placeholder="Phone"><br>
        <input type="number" name="batch" placeholder="Batch (e.g. 2025)" required><br>
        <input type="text" name="father_name" placeholder="Father's Name"><br>
        <input type="file" name="photo" required><br>
        <button type="submit">Add Student</button>
    </form>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>
