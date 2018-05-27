<?php

session_start();
require_once("../php-include/connect.php");

if (!isset($_SESSION['user_index'])) {
	$_SESSION['error'] = '로그인하세요.';
	header("Location: index.php");
	die();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="" />
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">
				<h1 style="padding-top:100px;">새로운 그룹 형성하기</h1>
				<p>백스테이지에서는 여러분이 자유롭게 커뮤니티를 형성하고 운영할 수 있습니다.</p>
				<p>뜻을 함께하는 10명의 춤초 회원과 10000CP만 있으면 됩니다.</p>
				<input type="text" name="" value="" class="dcp-input" placeholder="커뮤니티 이름" />

				<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
	</body>
</html>
