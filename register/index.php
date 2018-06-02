<?php
require("../php-include/connect.php");
?>


<!DOCTYPE html>
<html>
	<head>
		<title>회원가입 - 춤추는 초코파이</title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="../css/login-register.built.css" />
		<?php include("../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">

				<header class="register-header">
					<p class="register-title visual-text">춤추는 초코파이 회원가입</p>
				</header>
				<div class="privacy-policy">
					<?php include("../privacy/privacy.html"); ?>
				</div>
				<div class="wrapper">
					<input id="pp-agree" type="checkbox" name="" value="">
					<label class="pp-agree-cb" for="pp-agree">개인정보 취급방침에 동의합니다.</label>
				</div>

				<button class="dcp-button next" type="button" name="button" onclick="next()">다음</button>

			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/confirm.js"></script>
	</body>
</html>
