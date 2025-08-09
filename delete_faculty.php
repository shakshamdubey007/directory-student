<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM faculty WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: faculty_admin.php");
exit;
?>
