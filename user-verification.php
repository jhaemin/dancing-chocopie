<?php

session_start();
require_once("php-include/connect.php");

$isverified = false;

do {

	if (!isset($_GET['i']) || !isset($_GET['v'])) {
		header("Location: index.php");
		die();
	}

	$id = mysqli_real_escape_string($conn, $_GET['i']);
	$hash = mysqli_real_escape_string($conn, $_GET['v']);

	$sql = "SELECT * FROM `dcp_user_waiting` WHERE `id`='$id' AND `hash`='$hash'";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result);
	} else {
		break;
	}
	if ($count != 1) {
		break;
	}

	$user_id = mysqli_real_escape_string($conn, $row['user_id']);
	$user_pw = mysqli_real_escape_string($conn, $row['user_pw']);
	$nickname = mysqli_real_escape_string($conn, $row['nickname']);
	$created_at = mysqli_real_escape_string($conn, $row['created_at']);
	$cp = 500;


	// insert data into user_info
	$sql = "INSERT INTO `dcp_user_info` (user_id, nickname, user_pw, created_at, cp) VALUES ('$user_id', '$nickname', '$user_pw', '$created_at', '$cp')";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		break;
	}

	// delete waiting user list
	$sql = "DELETE FROM `dcp_user_waiting` WHERE `id`='$id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		break;
	}

	$isverified = true;

} while (0);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>회원가입 인증 - 춤추는 초코파이</title>
		<?php include("php-include/header.php"); ?>
		<?php include 'php-include/hd-js.php'; ?>
	</head>
	<body>
		<div id="page">
			<?php include("php-include/globalnav.php"); ?>
			<main id="main">
				<?php if ($isverified) { ?>
				<p style="padding-top:120px;">인증되었습니다.</p>
				<?php } else { ?>
				<p style="padding-top:120px;">인증에 실패했습니다.</p>
				<?php } ?>
			</main>
			<?php include("php-include/footer.php"); ?>
		</div>
		<?php include("php-include/ft-js.php"); ?>
	</body>
</html>
