<?php

// if (!$_POST) {
// 	header("Location: index.php");
// 	die();
// }

?>

<!DOCTYPE html>
<html>
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
				<div class="container">
					<img class="dcp-hero" src="../images/dcp-hero.gif" alt="dancing chocopie" />
					<h1 class="wl-h">이제 마지막 단계만 거치면 됩니다!</h1>
					<p class="wl-p">본인 인증 이메일을 <span style="color:#0081f7;"><?php echo htmlspecialchars($_POST['email']); ?></span>로 발송했습니다.</p>
					<p>이메일은 1분 이내에 도착하며, 인증 코드는 30분이 지나면 만료됩니다.</p>
					<p>만료된 인증코드로는 인증을 받을 수 없으므로 새로 회원가입을 해주셔야합니다.</p>
					<p>감사합니다.</p>
				</div>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
	</body>
</html>
