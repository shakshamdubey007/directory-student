<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "your_database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter = $_GET['filter'] ?? '';
$query = $_GET['query'] ?? '';

$allowed = ['name', 'roll', 'batch'];
if (!in_array($filter, $allowed)) {
    die("Invalid filter selected.");
}

// Prepare SQL safely
$stmt = $conn->prepare("SELECT * FROM students WHERE $filter LIKE ?");
$searchTerm = "%" . $query . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();

$result = $stmt->get_result();

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Roll No</th><th>Batch</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['roll']}</td>
            <td>{$row['batch']}</td>
          </tr>";
}
echo "</table>";

$stmt->close();
$conn->close();
?>
