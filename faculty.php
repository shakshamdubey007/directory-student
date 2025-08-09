<?php
require 'db.php';

// Handle search and filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'name';

$allowed = ['name', 'designation', 'department'];
if (!in_array($filter, $allowed)) {
    $filter = 'name';
}

$stmt = $conn->prepare("SELECT * FROM faculty WHERE $filter LIKE ? ORDER BY department ASC");
$like = "%$search%";
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSE Faculty Directory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- 🏫 College Header with Logos -->
<div class="top-bar">
    <img src="uploads/BGGI_LOGO-removebg-preview.png" alt="Left Logo" class="logo-side">

    <div class="college-info">
        <h1 class="main-heading">BHAI GURDAS INSTITUTE OF ENGINEERING & TECHNOLOGY</h1>
        <div style="display: flex; justify-content: center;">
            <h5 class="college-address">Main Patiala Road, Sangrur-148001(PB.)</h5>
        </div>
    </div>

    <img src="uploads/file-98.png" alt="Right Logo" class="logo-side">
</div>

<!-- 🔗 Navigation Bar -->
<nav style="background-color: #f2f2f2; padding: 10px; text-align: center;">
    <a href="index.php" style="margin: 0 20px; font-weight: bold; color: brown;">Student Directory</a>
    <a href="faculty.php" style="margin: 0 20px; font-weight: bold; color: brown;">Faculty Directory</a>
</nav>

<!-- 🏷️ Header Section -->
<div class="directory-header">
    <h2 class="dept-title">DEPARTMENT OF COMPUTER SCIENCE & ENGINEERING</h2>
    <h3 class="directory-title">FACULTY DIRECTORY</h3>
</div>

<!-- 🔍 Search Filter Form -->
<div class="search-container" style="margin: 20px auto; text-align: center;">
    <form method="GET" style="display: inline-flex; gap: 10px; align-items: center;">
        <label for="filter" style="color: brown; font-weight: bold;">Search by:</label>
        <select name="filter" id="filter" required>
            <option value="name" <?= $filter === 'name' ? 'selected' : '' ?>>Name</option>
            <option value="designation" <?= $filter === 'designation' ? 'selected' : '' ?>>Designation</option>
            <option value="department" <?= $filter === 'department' ? 'selected' : '' ?>>Department</option>
        </select>

        <input type="text" name="search" class="search-input" placeholder="Enter search term..." value="<?= htmlspecialchars($search) ?>" required>
        <button type="submit" class="search-btn">Search</button>
    </form>
</div>

<!-- 📋 Faculty Table -->
<table>
    <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Phone</th>
        <th>Email</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><img src="<?= $row['photo'] ?>" width="50"></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['designation']) ?></td>
        <td><?= htmlspecialchars($row['department']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- 🔐 Admin Login Link -->
<p><a href="login.php">Admin Login</a></p>

<!-- 📌 Footer -->
<div class="footer">
    &copy; 2025 BGIET College | Designed by Divyam
</div>

</body>
</html>
