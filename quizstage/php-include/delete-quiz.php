<?php

do {
	if (!$_POST['quiz_id'] || !$_POST['nickname']) {
		break;
	}

	// only uploader can delete the quiz
	if ($_POST['nickname'] != $_SESSION['nickname']) {
		break;
	}

	$quiz_id = mysqli_real_escape_string($conn, $_POST['quiz_id']);
	$sql = "DELETE FROM `dcp_quiz` WHERE `id`='$quiz_id';";
	$sql .= "DELETE FROM `dcp_quiz_solved` WHERE `quiz_id`='$quiz_id';";
	$sql .= "DELETE FROM `dcp_quiz_recommend` WHERE `quiz_id`='$quiz_id';";
	$sql .= "DELETE FROM dcp_comment WHERE quiz_id='$quiz_id';";
	$sql .= "DELETE FROM dcp_quiz_notification WHERE quiz_id='$quiz_id'";

	if (mysqli_multi_query($conn, $sql)) {
		if (isset($_SESSION['quiz_page'])) {
			$quiz_page = $_SESSION['quiz_page'];
		} else {
			$quiz_page = 'index.php';
		}
		$_SESSION['error'] = "퀴즈가 삭제되었습니다.";

	} else {
		$_SESSION['error'] = "퀴즈가 존재하지 않습니다.";
	}

	header("Location: ".$quiz_page);

} while (0);

?>
