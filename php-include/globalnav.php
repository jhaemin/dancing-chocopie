<?php

if (isset($_SESSION['user_index'])) {
	$user_index = $_SESSION['user_index'];
	$sql = "SELECT * FROM dcp_user_info WHERE id='$user_index'";
	if ($nav_result = mysqli_query($conn, $sql)) {
		$nav_user = mysqli_fetch_assoc($nav_result);
	} else {
		echo mysqli_error($conn);
	}
}
?>

<nav id="globalnav" class="animate-all-05s">
	<div class="gn-wrapper">
		<div class="gn-container">
			<a href="<?php echo $local; ?>/index.php" class="gn-logo-wrapper">
				<img src="<?php echo $local; ?>/images/dcp_logo_beta.svg" alt="" class="gn-logo" />
			</a>
			<div class="gn-item-container">
				<ul class="gn-item-list">
					<li class="gn-item desktop" title="퀴즈스테이지">
						<a href="<?php echo $local; ?>/quizstage" class="gn-link">퀴즈스테이지</a>
					</li>
					<li class="gn-item desktop" title="백스테이지">
						<a href="<?php echo $local; ?>/backstage" class="gn-link">백스테이지</a>
					</li>
					<li class="gn-item desktop" title="아이템스토어">
						<a href="#" class="gn-link">아이템스토어</a>
					</li>

					<?php // if logged in
					if (isset($_SESSION['user_index'])) {
					?>

					<li class="gn-item desktop" title="로그아웃">
						<a href="<?php echo $local; ?>/logout.php" class="gn-link">로그아웃</a>
					</li>

					<?php
					} else {
					?>
					<li class="gn-item desktop" title="로그인">
						<a href="<?php echo $local; ?>/login.php" class="gn-link">로그인</a>
					</li>
					<li class="gn-item desktop" title="회원가입">
						<a href="<?php echo $local; ?>/register" class="gn-link">회원가입</a>
					</li>
					<?php
					}
					?>


					<!-- Notification box -->
					<div id="gn-user-noti">

						<!-- Quiz notification -->
						<h1 class="gn-noti-header gn-noti-hd-quiz">퀴즈 알림</h1>
						<?php
						$sql = "SELECT * FROM dcp_quiz_notification WHERE user_index='$user_index' ORDER BY id DESC";
						$result = mysqli_query($conn, $sql);
						if (!$result) {
							echo mysqli_error($conn);
						}
						// there is no notification
						if (mysqli_num_rows($result) == 0) { ?>
							<div class="gn-empty-noti">
								<h1>퀴즈 알림이 없습니다.</h1>
							</div>
						<?php
						} else { ?>
							<div class="gn-noti-action">
								<button class="gn-noti-action-btn" type="button" name="button" onclick="deleteAllQuizNoti()">알림 전체 삭제</button>
							</div>
						<?
						}
						while ($row = mysqli_fetch_assoc($result)) {
							$noti_id = mysqli_real_escape_string($conn, $row['id']);
							$noti_quiz_id = mysqli_real_escape_string($conn, $row['quiz_id']);
							$sql = "SELECT * FROM dcp_quiz WHERE id='$noti_quiz_id'";
							if ($quiz_result = mysqli_query($conn, $sql)) {
								$quiz_noti = mysqli_fetch_assoc($quiz_result);
							} else {
								echo mysqli_error($conn);
							}
						?>
						<!-- Quiz notification items -->
						<div class="gn-noti-item <?php if (!$row['confirmed']) echo 'new'; ?>">
							<p class="gn-noti-date"><?php echo date('Y-m-d H:i', strtotime($row['pushed_at'])); ?></p>
							<p><?php echo htmlspecialchars($row['message']); ?></p>
							<a href="<?php echo $local.'/quizstage/show.php?quiz_id='.htmlspecialchars($quiz_noti['id']); ?>">퀴즈: '<?php echo htmlspecialchars($quiz_noti['title']); ?>'</a>
						</div>

						<?php } ?>

						<!-- Chat/Message Notification -->
						<h1 class="gn-noti-header gn-noti-hd-msg">메시지</h1>
					</div>

					<!-- User info (link to mypage when click) -->
					<?php if (isset($_SESSION['user_index'])) { ?>
					<li class="gn-item gn-user-info noselect" title="마이페이지" onclick="toggleNoti()">
						<div class="wrapper">
							<p class="gn-user"><?php echo htmlspecialchars($nav_user['nickname']); ?></p>
							<p class="gn-cp"><span class="cp-coin"></span><?php echo htmlspecialchars($nav_user['cp']); ?><span style="margin-left:2px;">CP</span></p>
						</div>
						<!-- count box -->
						<span id="gn-noti-count"></span>
					</li>
					<?php } ?>

				</ul>
				<div class="gn-item gn-more-button-container">
					<button id="gn-more-button" class="gn-link" onclick="toggleNav()"></button>
				</div>
			</div>
			<div id="gn-item-more-container">
				<div class="gn-item-more-arrow"></div>
				<ul class="gn-item-more-list">
					<li class="gn-item-more">
						<a href="<?php echo $local; ?>/quizstage" class="gn-item-more-link" style="border-radius:3px 3px 0 0;">퀴즈스테이지</a>
					</li>
					<li class="gn-item-more">
						<a href="<?php echo $local; ?>/backstage" class="gn-item-more-link">백스테이지</a>
					</li>
					<li class="gn-item-more">
						<a href="#" class="gn-item-more-link">아이템스토어</a>
					</li>

					<?php
					if (isset($_SESSION['user_id'])) {
					?>
					<li class="gn-item-more" style="border-bottom:none;border-radius: 0 0 3px 3px;">
						<a href="<?php echo $local; ?>/logout.php" class="gn-item-more-link">로그아웃</a>
					</li>
					<?php
					} else {
					?>
					<li class="gn-item-more">
						<a href="<?php echo $local; ?>/login.php" class="gn-item-more-link">로그인</a>
					</li>
					<li class="gn-item-more" style="border-bottom:none;border-radius: 0 0 3px 3px;">
						<a href="<?php echo $local; ?>/register" class="gn-item-more-link">회원가입</a>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</nav>
