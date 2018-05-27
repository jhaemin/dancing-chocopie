<?php
session_start();
require("../../php-include/connect.php");
include '../../php-include/dcp-functions.php';

// multiple return values to AJAX using PHP array
$return = array('issolved'=>0, 'already_solved'=>0, 'isfirst'=>0, 'loggedin'=>0, 'empty_string'=>0, 'error'=>'');

do {
	// submit answer without login
	if (!isset($_SESSION['user_id'])) {
		$return['loggedin'] = 0;
		$return['error'] = "로그인 하세요.";

		break;
	}
	$return['loggedin'] = 1;
	$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);

	$sql = "SELECT * FROM dcp_user_info WHERE id='$user_index'";
	if ($result = mysqli_query($conn, $sql)) {
		$user = mysqli_fetch_assoc($result);
	}

	$quiz_id = isset($_POST['quiz_id']) ? mysqli_real_escape_string($conn, $_POST['quiz_id']) : null;
	$user_ans = isset($_POST['user_ans']) ? mysqli_real_escape_string($conn, $_POST['user_ans']) : null;
	$cp = mysqli_real_escape_string($conn, $user['cp']);

	if ($cp - 1 < 0) {
		$return['error'] = "CP가 부족합니다.";
		break;
	}

	$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
	$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);

	// works only when user submits answer
	// even if user cannot do this action
	// (for the bug situation)
	$sql = "SELECT * FROM `dcp_quiz_solved` WHERE `quiz_id`='$quiz_id' AND `user_index`='$user_index'";
	if (!($result = mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}
	$count = mysqli_num_rows($result);
	if ($count == 1) {
		$return['already_solved'] = 1;
		$return['error'] = "이미 해결한 문제입니다.";

		break;
	}

	// if submit empty string
	if ($quiz_id == null || $user_ans == null) {
		$return['empty_string'] = 1;
		$return['error'] = "정답을 입력하세요.";

		break;
	}

	// get quiz info from the database
	$sql = "SELECT * FROM `dcp_quiz` WHERE `id`='$quiz_id'";
	if (!($result = mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}
	$count = mysqli_num_rows($result);
	if ($count == 0) { // the quiz has been deleted
		$return['error'] = "퀴즈가 존재하지 않습니다.";

		break;
	}
	$quiz = mysqli_fetch_assoc($result);
	$new_try = mysqli_real_escape_string($conn, $quiz['try']) + 1;
	$uploader_index = mysqli_real_escape_string($conn, $quiz['user_index']);

	// check answer
	$iscorrect = 0;
	$ans_arr = explode("/", $quiz['answer']);
	foreach ($ans_arr as $ans) {
		if ($ans == $user_ans) {
			$iscorrect = 1;
		}
	}

	// wrong answer
	if (!$iscorrect) {
		// update quiz try count
		$sql = "UPDATE `dcp_quiz` SET `try`='$new_try' WHERE `id`='$quiz_id'";
		if (!($result = mysqli_query($conn, $sql))) {
			$return['error'] = mysqli_error($conn);
			break;
		}
		$return['issolved'] = 0;

		// update user cp
		$cp -= 1;
		$sql = "UPDATE dcp_user_info SET cp='$cp' WHERE id='$user_index'";
		if (!mysqli_query($conn, $sql)) {
			$return['error'] = mysqli_error($conn);
			break;
		}

		// update quiz answer rate
		$sql = "SELECT * FROM dcp_quiz WHERE id='$quiz_id'";
		$result = mysqli_query($conn, $sql);
		if (!(mysqli_query($conn, $sql))) {
			$return['error'] = mysqli_error($conn);
			break;
		}
		$quiz = mysqli_fetch_assoc($result);
		$answer_rate = intval($quiz['solved']/$quiz['try']*100);

		$sql = "UPDATE dcp_quiz SET answer_rate='$answer_rate' WHERE id='$quiz_id'";
		$result = mysqli_query($conn, $sql);
		if (!(mysqli_query($conn, $sql))) {
			$return['error'] = mysqli_error($conn);
			break;
		}

		break;
	}

	// correct answer
	$sql = "SELECT * FROM `dcp_quiz_solved` WHERE `quiz_id`='$quiz_id'";
	if (!($result = mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}
	$return['issolved'] = 1;

	// check if user solved the quiz for the first time
	if (mysqli_num_rows($result) == 0) {
		$return['isfirst'] = 1;
		$cp += 40;
	} else {
		$cp += 20;
	}

	// add solved user list
	$solved_at = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `dcp_quiz_solved` (quiz_id, user_index, solved_at) VALUES ('$quiz_id', '$user_index', '$solved_at')";
	if (!(mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}

	// reload the number of solved users of the quiz
	$sql = "SELECT * FROM `dcp_quiz_solved` WHERE `quiz_id`='$quiz_id'";
	if (!($result = mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}

	$new_solved = mysqli_num_rows($result);

	// update quiz 'solved' and 'try'
	$sql = "UPDATE `dcp_quiz` SET `try`='$new_try', `solved`='$new_solved' WHERE `id`='$quiz_id'";
	if (!(mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}

	// update user cp
	$sql = "UPDATE `dcp_user_info` SET `cp`='$cp' WHERE `id`='$user_index'";
	if (!(mysqli_query($conn, $sql))) {
		$return['error'] = mysqli_error($conn);

		break;
	}

	// update quiz answer rate
	$sql = "SELECT * FROM dcp_quiz WHERE id='$quiz_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$return['error'] = mysqli_error($conn);
		break;
	}
	$quiz = mysqli_fetch_assoc($result);
	$answer_rate = intval($quiz['solved']/$quiz['try']*100);

	$sql = "UPDATE dcp_quiz SET answer_rate='$answer_rate' WHERE id='$quiz_id'";
	if (!mysqli_query($conn, $sql)) {
		$return['error'] = mysqli_error($conn);
		break;
	}

	// update quiz uploader's cp
	if ($answer_rate >= 75) {
		$cp_add = 4;
	} else if ($answer_rate >= 50) {
		$cp_add = 6;
	} else if ($answer_rate >= 25) {
		$cp_add = 8;
	} else if ($answer_rate >= 0) {
		$cp_add = 10;
	}
	$sql = "UPDATE dcp_user_info SET cp = cp + '$cp_add' WHERE id='$uploader_index'";
	if (!mysqli_query($conn, $sql)) {
		$return['error'] = mysqli_error($conn);
		break;
	}

	// get uploader object
	// $sql = "SELECT * FROM dcp_user_index WHERE id='$uploader_index'";
	// $result = mysqli_query($conn, $sql);
	// if (!(mysqli_query($conn, $sql))) {
	// 	$return['error'] = mysqli_error($conn);
	// 	break;
	// }
	// $uploader = mysqli_fetch_assoc($result);

	$msg = $user['nickname'] . "님께서 회원님의 퀴즈를 맞췄습니다. " . $cp_add . "CP를 획득했습니다.";
	$sql = "INSERT INTO dcp_quiz_notification (user_index, quiz_id, message) VALUES ('$uploader_index', '$quiz_id', '$msg')";
	if (!mysqli_query($conn, $sql)) {
		$return['error'] = mysqli_error($conn);
		break;
	}

} while (0);
echo json_encode($return);

?>
