<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_index'])) {
	die();
}

$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);
$sql = "UPDATE dcp_quiz_notification SET confirmed=1 WHERE user_index='$user_index' AND confirmed=0";
if (!mysqli_query($conn, $sql)) {
	echo mysqli_error($conn);
}


?>
