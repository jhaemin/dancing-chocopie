<?php

session_start();
require_once("../../php-include/connect.php");
include '../../php-include/conf.php';

if (!isset($_SESSION['user_index'])) {
	header("Location: ".$local."/login.php");
}


?>

<!DOCTYPE html>
<?php include '../../php-include/html-hd.php'; ?>
	<head>
		<title>개인정보관리</title>
		<?php include("../../php-include/header.php"); ?>
		<link rel="stylesheet" href="../css/mypage.css" />
		<?php include '../../php-include/hd-js.php'; ?>
	</head>
	<body>
		<div id="page">
			<?php include("../../php-include/globalnav.php"); ?>
			<main id="main">
				<?php include("../header.php"); ?>
				<section class="my-content">
					<span class="my-goback-wrapper">
						<a href="../" class="my-goback">메뉴</a>
					</span>
					<!-- <button type="button" class="my-goback" onclick="location.replace('index.php');">< 뒤로가기</button> -->
					<div class="priv-module-container">
						<div class="priv-module dcp-border">
							<h2 class="priv-t noselect notap">닉네임 변경</h2>
							<div class="priv-more">
								<p>새 닉네임 입력</p>
								<input type="text" name="" value="" class="dcp-input">
								<p id="nn-dp-err" class="input-error-message priv-error"></p>
								<form>
									<button type="button" class="dcp-button white">확인 및 변경</button>
								</form>
							</div>
						</div>
						<div class="priv-module dcp-border">
							<h2 class="priv-t noselect notap">패스워드 변경</h2>
							<div class="priv-more">
								<p>이전 패스워드 입력</p>
								<input type="password" name="user_pw" value="" class="dcp-input">
								<p>새로운 패스워드 입력</p>
								<input type="password" name="user_pw" value="" class="dcp-input">
								<p>새로운 패스워드 확인</p>
								<input type="password" name="user_pw" value="" class="dcp-input">
								<form>
									<button type="button" class="dcp-button white">변경</button>
								</form>
							</div>
						</div>
						<div class="priv-module dcp-border">
							<h2 class="priv-t noselect notap">회원탈퇴</h2>
							<div class="priv-more">
								<p>패스워드</p>
								<input type="password" name="user_pw" value="" class="dcp-input" />
							</div>
						</div>
					</div>
				</section>
			</main>
			<?php include("../../php-include/footer.php"); ?>
		</div>
		<?php include("../../php-include/ft-js.php"); ?>
		<script src="../js/mypage.js"></script>
	</body>
</html>
