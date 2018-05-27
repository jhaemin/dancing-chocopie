<?php
session_start();
require("connect.php");

$user_id = "";
$id_err = "";
$pw_err = "";

if ($_POST) {
	if (!empty($_POST['user_id']) && !empty($_POST['user_pw'])) {
		$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
		$user_pw = mysqli_real_escape_string($conn, $_POST['user_pw']);

		$sql = "SELECT * FROM `dcp_user_info` WHERE `user_id` = '$user_id'";

	    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		if ($result) {
			$count = mysqli_num_rows($result);
		}

	    if ($count == 1) {
			$row = mysqli_fetch_assoc($result);
			if (password_verify($user_pw, $row['user_pw'])) {
				$_SESSION['user_index'] = $row['id'];
		        $_SESSION['user_id'] = $row['user_id'];
				$_SESSION['nickname'] = $row['nickname'];
				$_SESSION['cp'] = $row['cp'];
				
				if (isset($_SESSION['page'])) {
					header("Location: ".$_SESSION['page']);
				} else {
					header("Location: index.php");
				}
			} else {
				$pw_err = "패스워드가 올바르지 않습니다.";
			}
	    } else {
			$id_err = "없는 아이디입니다.";
	    }
	} else {
		if (empty($_POST['user_id'])) {
			$id_err = "아이디를 입력하세요.";
		}
		if (empty($_POST['user_pw'])) {
			$pw_err = "패스워드를 입력하세요.";
		}
	}
}
?>
