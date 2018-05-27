<?php

session_start();
include '../php-include/connect.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/sorry.built.css" />
		<?php include("../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main" class="center-box" style="background-color:#FFD5D0;padding:25px 0;">
				<img src="https://i.imgur.com/swfm9CX.png" alt="flower" style="position:absolute;left:-1vw;top:5vh;width:85vw;">
				<h2 class="visual-text" style="padding-top:50px;color:white;font-size:10vw;text-shadow:0.5vw 0.5vw 0 rgba(0, 0, 0, 0.33);position:relative;z-index:1;">2019년 봄에<br />찾아뵙겠습니다.</h2>

			<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
	</body>
</html>
