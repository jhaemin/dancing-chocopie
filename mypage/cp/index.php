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
					<div class="cp-coin-wrapper">
						<p class="cp-amount"><span class="cp-coin"></span><?php echo htmlspecialchars($user['cp']); ?></p>
					</div>
				</section>
			</main>
			<?php include("../../php-include/footer.php"); ?>
		</div>
		<?php include("../../php-include/ft-js.php"); ?>
		<script src="../js/mypage.js"></script>
	</body>
</html>
