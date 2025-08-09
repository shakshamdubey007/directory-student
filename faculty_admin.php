<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM faculty ORDER BY department ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Faculty Directory - Admin Panel</h2>
    <p><a href="add_faculty_form.php">➕ Add New Faculty</a> | <a href="admin.php">Back to Admin</a></p>

    <table border="1">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><img src="<?= $row['photo'] ?>" width="50"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['designation']) ?></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="edit_faculty.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_faculty.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this faculty member?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
