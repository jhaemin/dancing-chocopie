<?php
session_start();
include("../php-include/connect.php");

$sql = "SELECT * FROM dcp_user_waiting";
$result = mysqli_query($conn, $sql);

if (!$result) {
	die(mysqli_error($conn));
}

$count = 0;

while ($row = mysqli_fetch_assoc($result)) {
	$created_at = strtotime($row['created_at']);
	$today = strtotime(date('Y-m-d H:i:s'));

	$gap_min = ($today - $created_at)/60;
	echo $gap_min . "<br />";

	if ($gap_min >= 30) {
		$id = mysqli_real_escape_string($conn, $row['id']);
		$sql = "DELETE FROM dcp_user_waiting WHERE id='$id'";
		if (!mysqli_query($conn, $sql)) {
			echo mysqli_error($conn) . '<br />';
		} else {
			echo $row['user_id'] . " has been deleted from waiting list.<br />";
		}
		$count++;
	}
}

if ($count == 0) {
	echo 'User waiting list is clean.';
}
?>
