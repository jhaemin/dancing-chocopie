<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title><?php if ($mode == "edit") echo '퀴즈 수정'; else echo '새 퀴즈'; ?></title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/quizstage.css" />
		<?php include '../php-include/hd-js.php'; ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">
				<div class="bake-header-container visual-text">
					<h1 class="bake-header"><?php echo htmlspecialchars($page_title); ?></h1>
				</div>

				<div class="bake-guide" style="border-radius:0;">
					<h3>퀴즈 올리기 전에!</h3>
					<p>퀴즈 스테이지에서 비슷한 퀴즈가 있는지 검색해보세요!</p>
					<a href="index.php">← 퀴즈 스테이지로 돌아가기</a>
				</div>

				<form class="bake-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

					<div class="bake-category-container bake-input-container">
						<select class="dcp-select auto-width-select" name="category">
							<option value="" selected>카테고리를 선택하세요.</option>
							<?php
							// get quiz category info from database
							$sql = "SELECT * FROM `dcp_quiz_category` ORDER BY `list_order`";
							if ($result = mysqli_query($conn, $sql)) {
								while ($row = mysqli_fetch_assoc($result)) {
									?>
									<option value="<?php echo htmlspecialchars($row['category_id']); ?>" <?php if ($category == $row['category_id']) echo selected ?>><?php echo htmlspecialchars($row['category_name']); ?></option>
									<?php
								}

							} else {
								die(mysqli_error($conn));
							}
							?>
						</select>
						<?php if (isset($_POST['category']) && $_POST['category']=="") { ?>
						<p class="input-error-message" style="text-align:center;">카테고리를 선택하세요.</p>
						<?php } ?>

						<!-- auto-width-select -->
						<select id="tmp-select" class="dcp-select" style=""><option id="tmp-option"></option></select>
						<!-- auto-width-select -->

					</div>

					<div class="bake-title-container bake-input-container">

						<h2 class="bake-domain-name visual-text">퀴즈 제목</h2>

						<input id="bake-title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" class="dcp-input bake-input bake-input-title" maxlength="100" placeholder="퀴즈 제목을 입력하세요." />

						<?php if (isset($_POST['title']) && empty($_POST['title'])) { ?>
						<p class="input-error-message">제목을 입력하세요.</p>
						<?php } ?>

					</div>

					<div class="bake-article-container bake-input-container">

						<h2 class="bake-domain-name visual-text">퀴즈 내용 및 가이드</h2>

						<div class="title-as-article-wrapper" style="text-align: left; margin-bottom: 10px;">

							<input type="checkbox" id="title-as-article">

							<label for="title-as-article" class="client-text noselect" style="font-size: 12px; font-weight: 400;">제곧내 (체크 해제시 입력된 내용이 전부 삭제됩니다.)</label>

						</div>

						<!-- <textarea id="bake-article" class="dcp-textarea bake-input bake-article" name="article" maxlength="5000" placeholder="최대 5000자"></textarea> -->

						<!-- Beta editor -->
						<div id="bake-article" class="dcp-editor dcp-textarea bake-input bake-article" contenteditable="true"><?php echo $article; ?><br /></div>
						<input id="bake-hidden-article" type="hidden" name="article" value="">
						<!-- Beta editor -->

						<?php if (isset($_POST['article']) && empty($_POST['article'])) { ?>
						<p class="input-error-message">내용을 입력하세요.</p>
						<?php } ?>

						<input type="file" name="img" id="bake-img" value="" style="display:none;" accept="image/jpeg, image/gif, image/png" />
						<label for="bake-img" class="upload-image-btn">이미지 업로드 (최대 2MB)</label>
						<p style="vertical-align:top;margin-top:10px;font-size:12px;color:#6f6f6f">2MB가 넘는 이미지를 업로드하려면 직접 이미지 링크를 삽입해주세요. (업로드된 이미지는 춤추는 초코파이에서 소유하지 않습니다.)</p>

					</div>

					<div class="bake-ans-container bake-input-container">

						<h2 class="bake-domain-name visual-text">정답</h2>

						<div class="bake-guide">
							<h3>정답 입력 가이드</h3>
							<p>1. 정답은 사람이 유추할 수 있어야 합니다. <span style="text-decoration:line-through;color:#585858;">(고양이도 풀 수 있어야 합니다.)</span></p>
							<p>2. 정답에 띄어쓰기가 있거나 여러가지 방법으로 입력될 수 있는 경우 슬래시('/')로 구분하여 여러개의 답을 모두 입력해주세요. (예) 포새이돈/포세이돈, 춤추는초코파이/춤추는 초코파이</p>
							<p></p>
						</div>

						<input type="text" name="ans" value="<?php echo htmlspecialchars($ans); ?>" class="dcp-input bake-input bake-ans" autocomplete="off" maxlength="100" placeholder="정답을 입력하세요." />

						<?php if (isset($_POST['ans']) && empty($_POST['ans'])) { ?>
						<p class="input-error-message">정답을 입력하세요.</p>
						<?php } ?>

					</div>

					<div class="bake-button-container">

						<button type="button" name="goback" class="dcp-button white bake-goback" onclick="goBack('<?php
						if (isset($_SESSION['page'])) {
							echo $_SESSION['page'];
						} else if (isset($_SESSION['quiz_page'])) {
							echo $_SESSION['quiz_page'];
						} else {
							echo '../index.php';
						}
						?>')">취소</button>

						<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

						<input type="hidden" name="mode" value="<?php echo $mode; ?>">

						<button type="submit" name="bake" class="dcp-button bake-submit">완료</button>

					</div>

				</form>
				<!-- <form class="" action="submit.php" method="post">
					<div id="test" class="dcp-input dcp-textarea" contenteditable="true" style="text-align: left; white-space: pre;"></div>
					<button type="button" name="button" class="dcp-button" onclick="put()">넣어</button>
					<input id="hidden" type="hidden" name="hidden" value="" />
					<input type="submit" value="보내" class="dcp-button" onclick="putHidden()" />
				</form> -->
				<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/qs.built.js"></script>
	</body>
</html>
