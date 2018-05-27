<?php

function pushNotification($user_index, $msg) {
	$sql = "INSERT INTO dcp_server_notification (user_index, message) VALUES ('$user_index', '$msg')";
	$result = mysqli_query($conn, $sql);
	if (!(mysqli_query($conn, $sql))) {
		return false;
	} else {
		return true;
	}
}

?>
