<?php
session_start();
require_once("../php-include/connect.php");
include '../php-include/conf.php';

if (!isset($_SESSION['nickname'])) {
	header("Location: ../login.php");
}




?>


<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title>마이페이지</title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/mypage.css" />
		<?php include("../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">
				<?php include("header.php"); ?>
				<section class="my-content">
					<div class="my-module-wrapper">
						<div class="my-module personal dcp-border">
							<a href="private" class="overlay-link"></a>
							<!-- <button type="button" class="overlay-link" onclick="location.replace('private.php');"></button> -->
							<div class="my-module-content">
								<img src="../images/padlock.svg" alt="personal" class="icon" />
								<h2 class="category">개인정보</h2>
							</div>
						</div>
						<div class="my-module dcp-border">
							<a href="quiz" class="overlay-link"></a>
							<div class="my-module-content">
								<img src="../images/upload.svg" alt="personal" class="icon" />
								<h2 class="category">퀴즈</h2>
							</div>
						</div>
						<div class="my-module dcp-border">
							<a href="cp" class="overlay-link"></a>
							<div class="my-module-content">
								<img src="../images/cp.svg" alt="personal" class="icon" />
								<h2 class="category">CP</h2>
							</div>
						</div>
						<div class="my-module" style="height:0;border:none;margin-top:0;margin-bottom:0"></div>
						<div class="my-module" style="height:0;border:none;margin-top:0;margin-bottom:0"></div>
					</div>
				</section>

			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/mypage.js"></script>
	</body>
</html>
