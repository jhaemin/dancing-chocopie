<?php

session_start();
include '../../php-include/connect.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include("../../php-include/header.php"); ?>
		<link rel="stylesheet" href="../css/backstage.css" />
		<?php include("../../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../../php-include/globalnav.php"); ?>
			<main id="main" class="cc-main">
				<section class="cc-header center-box">
					<div class="wrapper" style="z-index:1;">
						<h1 class="cc-header-title">광장</h1>
						<p class="cc-header-ex">모두의 공간</p>
					</div>
					<img src="https://dl.dropboxusercontent.com/s/sthxqgmdlng8h48/Times_Square.jpg" alt="" class="cc-header-bg" />
				</section>
				<section class="cc-contents">
					<!-- Toolbar -->
					<div class="cc-toolbar-container">
						<div class="cc-toolbar">
							<div class="bs-category-container">
								<ul class="bs-category-list">
									<li class="bs-category-item animate-all">전체</li>
									<?php for ($i=0;$i<2;$i++) { ?>
									<li class="bs-category-item animate-all">공지사항</li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<button type="button" name="button" class="cc-register-btn animate-all">커뮤니티 가입하기</button>
						<span class="flex-space"></span>
						<button type="button" name="button" class="cc-register-btn animate-all">관리하기</button>
					</div>
					<div class="cc-wrapper">
						<div class="cc-body">

							<!-- Board -->
							<div class="bs-board">
								<div class="bs-list">
									<?php for ($i=0; $i<10; $i++) { ?>
									<div class="bs-item-container">
										<div class="bs-item">
											<div class="bs-item-left">
												<p class="comment-count"><?php
												echo $i * $i * $i;
												?></p>
											</div>
											<div class="bs-item-main">
												<a href="">테스트용 글 제목입니다. 아주 길어집니다 아주 아주아주앚주아주아주아주아주아주아주</a>
											</div>
											<div class="bs-item-info-wrapper">
												<div class="bs-item-info">
													<p class="nn">테스트닉네임spdlapdal</p>
													<p class="date">2017-5-11</p>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>

							<!-- Page Selector -->
							<?php include '../../php-include/page-selector.php'; ?>

							<!-- Search Module -->
							<?php include '../../php-include/search-module.php'; ?>
						</div>
						<div class="cc-side">
							<div class="cc-side-module">
								<h1>인기글</h1>
								<ol>
									<?php for ($i=0;$i<10;$i++) { ?>
									<li>인기글 <?php echo $i+1; ?></li>
									<?php } ?>
								</ol>
							</div>
							<div class="cc-side-module">
								<h1>최근 달린 댓글</h1>
								<ol>
									<?php for ($i=0;$i<10;$i++) { ?>
									<li>인기글 <?php echo $i+1; ?></li>
									<?php } ?>
								</ol>
							</div>
						</div>
					</div>

				</section>

			<?php include("../../php-include/modal.php"); ?>
			</main>
			<?php include("../../php-include/footer.php"); ?>
		</div>
		<?php include("../../php-include/ft-js.php"); ?>
	</body>
</html>
