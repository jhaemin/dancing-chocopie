<?php
session_start();
require_once("../php-include/connect.php");
require '../php-include/conf.php';

// set current page to session
$_SESSION['page'] = $_SERVER['REQUEST_URI'];
header("Location: sorry.php");

?>


<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title>여러분이 만들어가는 공간, 백스테이지 - 춤추는 초코파이</title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/backstage.css" />
		<?php include("../../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main" class="bs-main">
				<section class="back-header center-box">
					<div class="wrapper">
						<img src="../images/backstage.svg" alt="" />
						<h2>여러분이 만들어가는 공간, 백스테이지.</h2>
					</div>
				</section>
				<section class="back-content">

					<input class="dcp-input" type="text" name="" value="" placeholder="커뮤니티 검색하기">
					<div class="group-module-container">
						<div class="group-module center-box animate-all" data-group-name="광장">
							<div class="gm-wrapper">
								<h1 class="gm-header">광장</h1>
								<p class="gm-ex">모두의 공간</p>
							</div>
							<img class="gm-bg-img" src="https://i.imgur.com/YiFkSkO.jpg" alt="">
							<a href="square" class="overlay-link notap"></a>
						</div>
						<div class="group-module center-box animate-all" data-group-name="새로운 소식">
							<div class="gm-wrapper">
								<h1 class="gm-header">새로운 소식</h1>
								<p class="gm-ex">오늘은 또 무슨 일이 일어날까</p>
							</div>
							<img class="gm-bg-img" src="https://i.imgur.com/VtKFIfK.jpg" alt="">
						</div>
						<div class="group-module center-box animate-all" data-group-name="새로운 소식">
							<div class="gm-wrapper">
								<h1 class="gm-header">중고장터</h1>
								<p class="gm-ex">저렴하고 안전하게 거래하세요</p>
							</div>
							<img class="gm-bg-img" src="https://i2.wp.com/www.fleamarketinsiders.com/wp-content/uploads/2014/09/Mauerpark-flohmarkt-Victoria-Calligo.jpg?resize=720%2C415" alt="">
						</div>
						<div class="group-module center-box animate-all" style="background-color:#f6f6f6;">
							<div class="gm-wrapper">
								<img src="../images/plus.svg" alt="" style="width:35px;"/>
								<p class="gm-ex" style="color:#595959;">여러분만의 커뮤니티를 만들어보세요.</p>
							</div>
							<a href="new.php" class="overlay-link notap" <?php
							if (!isset($_SESSION['user_index'])) { ?>
								onclick="openModal('login', event)"
							<?php } ?>></a>
							<!-- <button class="overlay-link" type="button" name="button" onclick="openModal('login')"></button> -->
						</div>
						<div class="group-module flex-space"></div>
						<div class="group-module flex-space"></div>
						<div class="group-module flex-space"></div>
					</div>


				</section>
				<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>

		<?php
		if (isset($_SESSION['error'])) { ?>
			<script>openModal('<?php echo $_SESSION['error']; ?>')</script>
		<?php
			unset($_SESSION['error']);
		} ?>
	</body>
</html>
