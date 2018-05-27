<?php

session_start();
require 'connect.php';

if (!isset($_SESSION['user_index'])) {
	die();
}

$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);

if ($_GET['type'] == 'quiz' && !isset($_GET['qnt_id'])) {
	$sql = "DELETE FROM dcp_quiz_notification WHERE user_index='$user_index'";
	if (!mysqli_query($conn, $sql)) {
		echo mysqli_error($conn);
	}
}

?>
