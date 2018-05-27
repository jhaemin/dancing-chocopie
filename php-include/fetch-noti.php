<?php

session_start();
include 'connect.php';

if (!isset($_SESSION['user_index'])) {
	die();
}
$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);
$sql = "SELECT * FROM dcp_quiz_notification WHERE user_index='$user_index' AND confirmed=0";
$response = array();
$i =0;
while (1) {
	$result = mysqli_query($conn, $sql);
	$response['count'] = mysqli_num_rows($result);
	if ($response['count'] >= 0) {
		echo json_encode($response);
		break;
	}
	sleep(1);
	clearstatcache();
}
?>
