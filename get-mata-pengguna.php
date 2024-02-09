<?php
session_start();

include("connection.php");

$userId = $_SESSION['nokp'];

$sql = "SELECT mata FROM ahli WHERE nokp = $userId";

$result = mysqli_query($condb, $sql);

$user = mysqli_fetch_assoc($result);

echo json_encode($user);
?>