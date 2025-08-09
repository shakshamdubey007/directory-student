<?php
require 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'name';

$allowed = ['name', 'roll_no', 'batch'];
if (!in_array($filter, $allowed)) {
    $filter = 'name'; // fallback
}

$stmt = $conn->prepare("SELECT * FROM students WHERE $filter LIKE ? ORDER BY batch DESC");
$like = "%$search%";
$stmt->bind_param("s", $like);

$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <title>CSE Student Directory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   

</div>
    
<div class="top-bar">
    <img src="uploads\BGGI_LOGO-removebg-preview.png" alt="Left Logo" class="logo-side">

     <div class="college-info">
    <h1 class="main-heading">BHAI GURDAS INSTITUTE OF ENGINEERING & TECHNOLOGY</h1>
    <div style="display: flex; justify-content: center;">
    <h5 class="college-address">Main Patiala Road, Sangrur-148001(PB.)</h5>
</div>

</div>
    <img src="uploads\file-98.png" alt="Right Logo" class="logo-side">
</div>
<nav style="background-color: #f2f2f2; padding: 10px; text-align: center;">
    <a href="index.php" style="margin: 0 20px; font-weight: bold; color: brown;">Student Directory</a>
    <a href="faculty.php" style="margin: 0 20px; font-weight: bold; color: brown;">Faculty Directory</a>
</nav>

<div class="directory-header">
    <h2 class="dept-title">DEPARTMENT OF COMPUTER SCIENCE & ENGINEERING</h2>
    <h3 class="directory-title">STUDENT DIRECTORY</h3>
    

  <div class="search-container">
    <form method="GET" style="display: flex; gap: 10px; align-items: center;">
        <label for="filter" style="color: brown; font-weight: bold;">Search by:</label>
        <select name="filter" id="filter" required>
            <option value="name" <?= isset($_GET['filter']) && $_GET['filter'] === 'name' ? 'selected' : '' ?>>Name</option>
            <option value="roll_no" <?= isset($_GET['filter']) && $_GET['filter'] === 'roll_no' ? 'selected' : '' ?>>Roll No</option>
            <option value="batch" <?= isset($_GET['filter']) && $_GET['filter'] === 'batch' ? 'selected' : '' ?>>Batch</option>
        </select>

        <input type="text" name="search" class="search-input" placeholder="Enter search term..." value="<?= htmlspecialchars($search) ?>" required>
        <button type="submit" class="search-btn">Search</button>
    </form>
</div>


    <table>
        <tr>
            <th>Photo</th>
            <th>Roll No</th>
            <th>Name</th>
            <th>Father's Name</th>
            <th>Batch</th>
            <th>Phone</th>
            <th>Email</th>
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
            
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="login.php">Admin Login</a></p>
    <div class="footer">
    &copy; 2025 BGIET College  | Designed by Divyam
</div>

</body>
</html>
