<?php

session_start();
if (!isset($_SESSION['user_index'])) {
	header("Location: ../../index.php");
	die();
}
include '../../php-include/connect.php';

$to = mysqli_real_escape_string($conn, $_POST['to']);
$from = mysqli_real_escape_string($conn, $_SESSION['user_index']);
$msg = mysqli_real_escape_string($conn, $_POST['msg']);

$response = array();

$sql = "INSERT INTO dcp_chat (`from`, `to`, `message`) VALUES ('$from', '$to', '$msg')";
if (!($result = mysqli_query($conn, $sql))) {
	$response['error'] = mysqli_error($conn);
}
echo json_encode($response);

?>
