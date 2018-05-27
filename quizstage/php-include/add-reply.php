<?php
session_start();
require("../../php-include/connect.php");

if (!$_POST) {
	header("Location: index.php");
	die();
}

if (!isset($_SESSION['user_index'])) {
	echo '로그인 하세요.';
	die();
}

if (empty($_POST['content'])) {
	echo '답글을 입력하세요.';
	die();
}

$quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
$comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);
$content = mysqli_real_escape_string($conn, $_POST['content']);

$sql = "INSERT INTO dcp_quiz_reply (quiz_id, comment_id, user_index, content) VALUES ('$quiz_id', '$comment_id', '$user_index', '$content')";

$result = mysqli_query($conn, $sql);

if ($result) {

} else {
	echo mysqli_error($conn);
	die();
}

include("update-comment-count.php");

?>
