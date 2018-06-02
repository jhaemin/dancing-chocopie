<?php

include '../php-include/connect.php';

// check if there is already picked today's quiz
$sql = "SELECT * FROM dcp_quiz_today WHERE DATE(picked_at)=CURDATE()";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
	echo "Today's quiz is already picked.";
	die();
}

// select the best quiz from the yesterday
$sql = "SELECT * FROM dcp_quiz WHERE DATE(created_at)=DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY recommend DESC, comment DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
if ($result) {
	$count = mysqli_num_rows($result);
} else {
	echo mysqli_error($conn);
}

if ($count == 0) {
	echo "No quiz yesterday.";
	die();
} else {
	$quiz = mysqli_fetch_assoc($result);
	$quiz_id = mysqli_real_escape_string($conn, $quiz['id']);
}

// echo today picked quiz
echo "(".$quiz['id'].")";
echo $quiz['title'].", ";

$sql = "INSERT INTO dcp_quiz_today (quiz_id) VALUES ('$quiz_id')";

$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}

?>
