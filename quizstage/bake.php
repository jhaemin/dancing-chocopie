<?php
session_start();
require("../php-include/connect.php");
require '../php-include/conf.php';

// access without login
if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "로그인 하세요.";
	header("Location: index.php");
	die();
} else {
	$loggedin = 1;
}

$mode = "bake";
$quiz_id = "";
$title = "";
$article = "";
$ans = "";
$page_title = "새로운 퀴즈 업로드";

// When user presses upload button
if ($_POST && !empty($_POST['title']) && !empty($_POST['ans']) && !empty($_POST['article']) && $_POST['category']!="") {

	$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);
	$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$article = mysqli_real_escape_string($conn, $_POST['article']);
	$ans = mysqli_real_escape_string($conn, $_POST['ans']);
	$category = mysqli_real_escape_string($conn, $_POST['category']);
	$created_at = date('Y-m-d H:i:s');
	$quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);

	// conver <br /> to line breaks
	$article = preg_replace('/<br(\s+)?\/?>/i', "\n", $article);

	$sql = "INSERT INTO `dcp_quiz` (user_index, title, article, answer, category, created_at, edited_at) VALUES ('$user_index', '$title', '$article', '$ans', '$category', '$created_at', '$created_at')";

	$result = mysqli_query($conn, $sql);

	if ($result) {
		// upload quiz complete
		$last_id = mysqli_insert_id($conn);
		header("Location: show.php?quiz_id=" . $last_id);
	} else {
		$_SESSION['error'] = mysqli_error($conn);
		header("Location: index.php");
	}
} else {
	if (!($_POST['category']=="")) {
		$category = $_POST['category'];
	}
	if (!empty($_POST['title'])) {
		$title = $_POST['title'];
	}
	if (!empty($_POST['article'])) {
		$article = $_POST['article'];
	}
	if (!empty($_POST['ans'])) {
		$ans = $_POST['ans'];
	}
}

?>

<?php include("php-include/bake-template.php"); ?>
