<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title>회원가입 - 춤추는 초코파이</title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="../css/login-register.built.css" />
		<?php include '../php-include/hd-js.php'; ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">
				<header class="register-header">
					<p class="register-title visual-text">춤추는 초코파이 회원가입</p>
				</header>
				<form id="register-form">
					<div class="input-wrapper">

						<p class="register-input-title email">이메일 (아이디)</p>

						<input id="input-id" type="email" name="user_id" value="" class="dcp-input register-input register-id-input register-id" maxlength="255" placeholder="dancing@chocopie.net" />

						<p id="id-err" class="input-error-message"></p>

					</div>
					<div class="input-wrapper input-pw-wrapper">

						<p class="register-input-title">패스워드 (8-30자리)</p>

						<input id="input-pw" type="password" name="user_pw" value="" class="dcp-input register-input" maxlength="30" placeholder="********"/>

						<p id="pw-err" class="input-error-message"></p>

					</div>
					<div class="input-wrapper input-pw-wrapper">

						<p class="register-input-title">패스워드 확인</p>

						<input id="input-pw-cf" type="password" name="user_pw_cf" value="" class="dcp-input register-input" maxlength="30" placeholder="********" />

						<p id="pw-cf-err" class="input-error-message"></p>

					</div>
					<div class="input-wrapper input-nn-wrapper">
						<p class="register-input-title">닉네임 (2-10자리)</p>
						<input id="input-nn" type="text" name="nickname" value="" class="dcp-input register-input register-nickname" maxlength="10" placeholder="초코파이" />

						<p id="nn-err" class="input-error-message"></p>

					</div>
					<input id="register-submit" type="submit" value="가입하기" class="dcp-button register-submit" />
				</form>
				<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/register.js"></script>
	</body>
</html>
