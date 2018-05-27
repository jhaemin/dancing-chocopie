<?php

session_start();
require_once("../../php-include/connect.php");

if (!isset($_SESSION['user_index']) || !$_POST) {
	header("Location: ../index.php");
	die();
}

$comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
$quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);

$sql = "SELECT * FROM dcp_quiz_comment WHERE id='$comment_id'";
if ($result = mysqli_query($conn, $sql)) {
	$comment = mysqli_fetch_assoc($result);
} else {
	echo mysqli_error($conn);
	die();
}

if ($comment['user_index'] != $_SESSION['user_index']) {
	echo '다른 사용자의 댓글은 삭제할 수 없습니다.';
	die();
}

$sql = "DELETE FROM dcp_quiz_comment WHERE id='$comment_id'";
if ($result = mysqli_query($conn, $sql)) {

} else {
	echo mysqli_error($conn);
	die();
}

// update comment count
include("update-comment-count.php");

?>
