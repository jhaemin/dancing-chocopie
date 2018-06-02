<?php
if (isset($_SESSION['user_id'])) {
	header("Location: index.php");
	die();
}

include("php-include/login-verify.php");

?>

<!DOCTYPE html>
<html>
	<head>
		<title>로그인 - 춤추는 초코파이</title>
		<?php include("php-include/header.php"); ?>
		<link rel="stylesheet" href="css/login-register.built.css" />
		<?php include 'php-include/hd-js.php'; ?>
	</head>
	<body>
		<div id="page">
			<?php include("php-include/globalnav.php"); ?>
			<main id="main">
				<div class="login-header">
					<p class="login-title visual-text">춤추는 초코파이 로그인</p>
				</div>
				<form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<div class="input-wrapper">
						<p class="login-input-title email">이메일</p>
						<input type="email" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" placeholder="dancing@chocopie.com" class="dcp-input login-input login-id" required />
						<p class="input-error-message"><?php echo htmlspecialchars($id_err); ?></p>
					</div>
					<div class="input-wrapper input-pw-wrapper">
						<p class="login-input-title">패스워드</p>
						<input type="password" name="user_pw" value="" placeholder="********" class="dcp-input login-input login-pw" required />
						<p class="input-error-message"><?php echo htmlspecialchars($pw_err); ?></p>
					</div>
					<input type="submit" name="submit" value="로그인" class="dcp-button login-submit" />
				</form>
				<p class="lets-register">아이디가 없나요? <a href="register">회원가입</a>하세요!</p>
			</main>
			<?php include("php-include/footer.php"); ?>
		</div>
		<?php include("php-include/ft-js.php"); ?>
	</body>
</html>
