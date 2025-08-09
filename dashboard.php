<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM students ORDER BY batch DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Welcome, <?= $_SESSION['admin'] ?></h2>
    <p><a href="add_student_form.php">➕ Add New Student</a> |
     <a href="add_faculty_form.php">➕ Add New Faculty</a> |
    <a href="faculty_admin.php">👨‍🏫 Faculty Directory</a> |
    <a href="logout.php">Logout</a>

    <h3>All Students</h3>
    <table border="1">
        <tr>
            <th>Photo</th>
            <th>Roll No</th>
            <th>Name</th>
            <th>Father's Name</th>
            <th>Batch</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><img src="<?= $row['photo'] ?>" width="50"></td>
            <td><?= htmlspecialchars($row['roll_no']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['father_name']) ?></td>
            <td><?= htmlspecialchars($row['batch']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
