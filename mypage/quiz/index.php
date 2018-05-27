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
					<div class="mq-wrapper">
						<div class="my-quiz-section">
							<?php
							$sql = "SELECT * FROM dcp_quiz WHERE user_index='$user_index'";
							if (!($result = mysqli_query($conn, $sql))) {
								echo mysqli_error($conn);
							}
							?>
							<h1 class="mq-header">내가 올린 퀴즈</h1>
							<ol class="uploaded-quiz-list">
								<?php
								while ($row = mysqli_fetch_assoc($result)) {
								?>
								<li class="uq-item">
									<span class="date"><?php echo date('Y-m-d H:i', strtotime($row['created_at'])) ?></span>
									<a href="<?php echo $local.'/quizstage/show.php?quiz_id='.$row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
								</li>
								<?php } ?>
							</ol>
						</div>
						<div class="my-quiz-section">
							<h1 class="mq-header">내가 푼 퀴즈</h1>
						</div>
						<div class="my-quiz-section">
							<h1 class="mq-header">내가 추천한 퀴즈</h1>
						</div>
						<!-- <div class="my-quiz-section flex-space"></div> -->
					</div>
				</section>
			</main>
			<?php include("../../php-include/footer.php"); ?>
		</div>
		<?php include("../../php-include/ft-js.php"); ?>
		<script src="../js/mypage.js"></script>
	</body>
</html>
