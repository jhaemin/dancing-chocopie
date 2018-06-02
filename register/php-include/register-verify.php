<?php

require_once("../../php-include/connect.php");

$return = array('id_err'=>'', 'pw_err'=>'', 'pw_cf_err'=>'', 'nn_err'=>'', 'issuccess'=>0, 'email'=>'');

// check if nickname contains only Korean, alphabet lowercase, numbers, and - or _
function isValidId($str) {
	return !preg_match('/[^A-Za-z0-9_-\xE0-\xFF\x80-\xFF\x80-\xFF]/', $str);
}

$done = 1;

do {
	if (!$_POST) {
		header("../../index.php");
		break;
	}

	if (!(!empty($_POST['user_id']) && !empty($_POST['user_pw']) && !empty($_POST['nickname']) && !empty($_POST['user_pw_cf']))) {
		if (empty($_POST['user_id'])) {
			$return['id_err'] = "이메일을 입력하세요.";
			$done = 0;
		}
		if (empty($_POST['user_pw'])) {
			$return['pw_err'] = "패스워드를 입력하세요.";
			$done = 0;
		}
		if (empty($_POST['nickname'])) {
			$return['nn_err'] = "닉네임을 입력하세요.";
			$done = 0;
		}
		if (empty($_POST['user_pw_cf'])) {
			$return['pw_cf_err'] = "패스워드를 한 번 더 입력하세요.";
			$done = 0;
		}
		$done = 0;
	}

	$user_id = strtolower(mysqli_real_escape_string($conn, $_POST['user_id']));
	if (!filter_var($user_id, FILTER_VALIDATE_EMAIL) && !empty($user_id)) {
		$return['id_err'] = "이메일 형식이 맞지 않습니다.";
		$done = 0;
	}



	// password check
	$user_pw = mysqli_real_escape_string($conn, $_POST['user_pw']);
	if (strlen($user_pw) < 8 && strlen($user_pw) > 0 || strlen($user_pw) > 30) {
		$return['pw_err'] = "조건에 맞지 않는 길이입니다.";
		$done = 0;
	}

	// password confirmation check
	$user_pw_cf = mysqli_real_escape_string($conn, $_POST['user_pw_cf']);
	if ($user_pw != $user_pw_cf && !empty($user_pw_cf)) {
		$return['pw_cf_err'] = "패스워드가 다릅니다.";
		$done = 0;
	}

	// nickname check
	$nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
	if (!isValidId($nickname)) {
		$return['nn_err'] = "한글, 알파벳소문자, 숫자, 특수문자(-)만 사용 가능합니다.";
		$done = 0;
	}
	if (mb_strlen($nickname) < 2 && mb_strlen($nickname) || mb_strlen($nickname) > 10) {
		$return['nn_err'] = "조건에 맞지 않는 길이입니다.";
		$done = 0;
	}

	// check from user list
	$sql = "SELECT * FROM `dcp_user_info` WHERE `user_id`='$user_id' OR `nickname`='$nickname'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row['user_id'] == $user_id) {
				$return['id_err'] = "이미 가입된 이메일입니다.";
				$done = 0;
			}
			if (strtolower($row['nickname']) == strtolower($nickname)) {
				$return['nn_err'] = "사용중인 닉네임입니다.";
				$done = 0;
			}
		}
		$done = 0;
	}

	// check from email registration user list
	$sql = "SELECT * FROM `dcp_user_waiting` WHERE `user_id`='$user_id' OR `nickname`='$nickname'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row['user_id'] == $user_id) {
				$return['id_err'] = "이미 가입된 이메일입니다.";
				$done = 0;
			}
			if (strtolower($row['nickname']) == strtolower($nickname)) {
				$return['nn_err'] = "사용중인 닉네임입니다.";
				$done = 0;
			}
		}
		$done = 0;
	}

	if ($done && $_POST['send']) {
		// echo user email for sending POST variable to welcome page
		$return['email']=$user_id;

		// generate random verification code
		$hash = md5(uniqid(rand(), true));

		// encrypt user password using PHP default encryption
		$user_pw = password_hash($user_pw, PASSWORD_DEFAULT);

		$created_at = date('Y-m-d H:i:s');

		$sql = "INSERT INTO `dcp_user_waiting` (user_id, user_pw, nickname, created_at, hash) VALUES ('$user_id', '$user_pw', '$nickname', '$created_at', '$hash')";

		if (mysqli_query($conn, $sql)) { // register success
			$index = mysqli_insert_id($conn);

			include("../../email/send-email.php");


			echo json_encode($return);
			break;

		} else { // register failed
		}
	} else {
	}
	echo json_encode($return);


} while (0);

?>
