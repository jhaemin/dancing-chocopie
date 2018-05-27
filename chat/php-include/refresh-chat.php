<?php

session_start();
if (!isset($_SESSION['user_index'])) {
	header("Location: ../../index.php");
	die();
}
include '../../php-include/connect.php';

$to = mysqli_real_escape_string($conn, $_POST['to']);
$from = mysqli_real_escape_string($conn, $_SESSION['user_index']);

$sql = "SELECT * FROM dcp_chat WHERE `from`='$from' OR `from`='$to'";


?>
