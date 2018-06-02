<?php

session_start();
require 'php-include/connect.php';
require 'php-include/conf.php';
// set current page to session
$_SESSION['page'] = $_SERVER['REQUEST_URI'];

// select today quiz
$sql = "SELECT * FROM dcp_quiz_today ORDER BY picked_at DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}
$quiz_id = mysqli_real_escape_string($conn, mysqli_fetch_assoc($result)['quiz_id']);

$sql = "SELECT * FROM dcp_quiz WHERE id='$quiz_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}
$today_quiz = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<?php include 'php-include/html-hd.php'; ?>
	<head>
		<title>춤추는 초코파이 - 신개념 커뮤니티!</title>
		<meta name="description" content="세상의 모든 퀴즈, 춤추는 초코파이입니다. 퀴즈 맞추고 초코파이 드세요!">
		<?php include("php-include/header.php"); ?>
		<link rel="stylesheet" href="css/home.built.css" />
		<meta property="og:type" content="website">
		<meta property="og:title" content="춤추는 초코파이">
		<meta property="og:description" content="신개념 커뮤니티 춤추는 초코파이입니다.">
		<meta property="og:image" content="https://dl.dropboxusercontent.com/s/mh1b3jqz2lmhjcz/dcp-hero-bg.gif">
		<meta property="og:url" content="https://www.dancingchocopie.net">
		<?php include("php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("php-include/globalnav.php"); ?>
			<main id="main" class="today">
				<section id="main-quiz">
					<div class="wrapper">
						<h1 class="today-title visual-text">오늘의 퀴즈</h1>
						<div class="board">
							<div class="board-border"></div>
							<div class="board-body animate-all">
								<article class="quiz">
									<!-- Quiz title -->
									<p class="title"><?php echo htmlspecialchars($today_quiz['title']); ?></p>
								</article>
								<a href="quizstage/show.php?quiz_id=<?php echo htmlspecialchars($today_quiz['id']); ?>" class="link-to-org-qz">퀴즈스테이지에서 보기 〉</a>
								<img class="eraser" src="images/eraser.svg" alt="" />
							</div>
						</div>
						<form id="main-quiz-form" class="user-answer">
							<input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($today_quiz['id']); ?>">
							<input type="text" name="user_ans" value="" class="dcp-input main-user-input" placeholder="정답을 입력하세요." />
							<?php if (isset($_SESSION['user_index'])) { ?>
							<input id="main-quiz-submit" type="submit" value="정답 확인" class="dcp-button main-user-submit" />
							<?php } else { ?>
							<button id="main-quiz-submit" class="dcp-button main-user-submit" onclick="return openModal('login')">정답 확인</button>
							<?php } ?>
						</form>
					</div>
				</section>
				<section id="home-menu">
					<div class="hc-module-container">
						<div class="hc-module guide animate-all center-box">
							<div class="wrapper animate-all">
								<img src="images/book.svg" alt="" class="hc-icon" />
								<h1 class="visual-text">처음이세요?</h1>
							</div>
						</div>
						<div class="hc-module quizstage animate-all center-box">
							<div class="wrapper animate-all">
								<img src="images/quizstage.svg" alt="" class="hc-icon" />
								<h1 class="visual-text">퀴즈스테이지</h1>
								<!-- <p>자신이 알고 있는 재미있는 퀴즈와 지식을 사람들과 공유하세요.</p> -->
							</div>
							<a href="quizstage" class="overlay-link"></a>
						</div>
						<div class="hc-module backstage animate-all center-box">
							<div class="wrapper animate-all">
								<img src="images/backstage.svg" alt="" class="hc-icon" />
								<h1 class="visual-text">백스테이지</h1>
								<!-- <p>이곳에서 사람들과 자유롭게 담소를 나누세요.</p> -->
							</div>
							<a href="backstage" class="overlay-link"></a>
						</div>
						<div class="hc-module itemstore animate-all center-box">
							<div class="wrapper animate-all">
								<img src="images/shopping-bag.svg" alt="" class="hc-icon" />
								<h1 class="visual-text">아이템스토어</h1>
							</div>
							<a href="#" class="overlay-link"></a>
						</div>
					</div>
				</section>
				<?php include("php-include/modal.php"); ?>
			</main>
			<?php include("php-include/footer.php"); ?>
		</div>
		<?php include("php-include/ft-js.php"); ?>
		<script src='quizstage/js/qs.built.js'></script>
		<script src='js/home.built.js'></script>
	</body>
</html>
