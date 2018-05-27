<?php
session_start();
require '../php-include/connect.php';
require '../php-include/conf.php';

// set current page to session
$_SESSION['page'] = $_SERVER['REQUEST_URI'];

// set current quizstage page
$_SESSION['quiz_page'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['user_id'])) {
	$loggedin = 1;
} else {
	$loggedin = 0;
}

$category = -1;

$page = 1; // current page number
$max_limit = 10; // max quiz number show in a page
$page_num = 5; // max page number
$search_get = ""; // string for echoing a tag url inside page selectors href link

// enabled option variable
$category_enabled = false;

// select all quiz based on mode

// general
$sql = "SELECT * FROM dcp_quiz";

// category
if (isset($_GET['category']) && $_GET['category'] != -1) {
	$category = mysqli_real_escape_string($conn, $_GET['category']);
	$sql .= " WHERE category={$category}";
	$category_enabled = true;
}

// search
if (!empty($_GET['search'])) {
	// echo '<script>alert("왓?");</script>';
	if (!$category_enabled) {
		$sql .= " WHERE";
	} else {
		$sql .= " AND";
	}

	if ($_GET['search_mode'] == 'title') { // search by quiz title
		$search = mysqli_real_escape_string($conn, $_GET['search']);
		$search_array = explode(" ", $search);
		$query_parts = array();
		foreach ($search_array as $val) {
			$query_parts[] = "'%".$val."%'";
		}
		$search_string = implode(" AND title LIKE ", $query_parts);
		$sql .= " title LIKE {$search_string}";
	} else if ($_GET['search_mode'] == 'article') { // search by quiz article
		$search = mysqli_real_escape_string($conn, $_GET['search']);
		$sql .= " article LIKE '%{$search}%'";
	} else { // else way to search by modifying the GET url
		$_SESSION['error'] = "검색 방법이 잘못되었습니다.";
		header("Location: index.php");
		die();
	}
}

// ordering option
do {
	if (empty($_GET['order']) || $_GET['order'] == "latest") {
		$sql .= " ORDER BY id DESC";
		break;
	}
	if ($_GET['order'] == "popular") {
		$sql .= " ORDER BY recommend DESC";
		break;
	}
	if ($_GET['orderr'] == "rate-desc") {
		// $sql .= " ORDER BY"
	}
} while (0);


// echo '<script>alert("'.$sql.'");</script>';

include '../php-include/page-selector-config.php';

?>

<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title>퀴즈스테이지 - <?php echo htmlspecialchars($page); ?> 페이지</title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/quizstage.css" />
		<?php include("../php-include/hd-js.php"); ?>
	</head>
	<body>
		<div id="page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main">
				<header id="qs-banner">
					<div class="qs-banner-container">
						<!-- <h1 class="qs-title">퀴즈 스테이지</h1>
						<p class="qs-copy">재미있는 퀴즈를 사람들과 공유하세요!</p> -->
						<img src="<?php echo $local."/images/quizstage.svg" ?>" alt="" />
						<h2>퀴즈의, 퀴즈에 의한, 퀴즈를 위한 커뮤니티</h2>
					</div>
				</header>
				<div class="content-wrapper">
					<section id="main-content">

						<div class="quiz-option">

							<!-- auto-width-select -->
							<select id="tmp-select" class="dcp-select" style=""><option id="tmp-option"></option></select>
							<!-- auto-width-select -->

							<form class="quiz-option-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
								<select id="category-select" class="dcp-select quiz-opt-select auto-width-select" name="category" onchange="this.form.submit()">
									<option value="-1" selected>전체</option>
									<?php
									// get quiz category info from database
									$sql = "SELECT * FROM `dcp_quiz_category` ORDER BY `list_order`";
									if ($result2 = mysqli_query($conn, $sql)) {
										while ($row = mysqli_fetch_assoc($result2)) {
											?>
											<option value="<?php echo htmlspecialchars($row['category_id']); ?>" <?php if ($category == $row['category_id']) echo selected ?>><?php echo htmlspecialchars($row['category_name']); ?></option>
											<?php
										}

									} else {
										die(mysqli_error($conn));
									}
									?>
								</select>

								<select class="dcp-select quiz-opt-select auto-width-select" name="order" onchange="this.form.submit()">
									<option value="latest" <?php if ($_GET['order'] == "latest") echo "selected"; ?>>등록순</option>
									<option value="popular" <?php if ($_GET['order'] == "popular") echo "selected"; ?>>인기순</option>
									<option value="rate-desc" <?php if ($_GET['order'] == "rate-desc") echo "selected"; ?>>정답률 낮은 순</option>
									<option value="rate-asc" <?php if ($_GET['order'] == "rate-asc") echo "selected"; ?>>정답률 높은 순</option>
								</select>
							</form>

						</div>

						<!-- Search result -->
						<?php if (!empty($_GET['search'])) { ?>
						<div class="search_result_wrapper">
							<p class="search_result_header">"<?php echo htmlspecialchars($search); ?>"에 대한 총 <?php echo htmlspecialchars($num); ?>개의 검색결과입니다.</p>
						</div>
						<?php } ?>

						<!-- No search result -->
						<?php if ($num == 0) { ?>
						<div class="search_result_anounce visual-text">
							<?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
							<p class="sra_header">검색 결과 없음.</p>
							<?php } else { ?>
							<p class="sra_header">퀴즈 없음.</p>
							<?php } ?>
						</div>
						<?php } ?>


						<!-- Quiz list -->
						<div class="quiz-item-wrapper">
							<?php
							// display quiz list results
							while ($row = mysqli_fetch_assoc($page_result)) {
								if ($row['try'] == 0) {
									$percent = 0;
								} else {
									$percent = intval($row['solved']/$row['try']*100);
								}

								// specify colors for each answer rate scope
								$color = '#ed0d0d'; // default : red
								if ($percent >= 90) {
									$color = '#0094f4';
								} else if ($percent >= 70) {
									$color = '#00b5c7';
								} else if ($percent >= 50) {
									$color = '#4baf22';
								} else if ($percent >= 30) {
									$color = '#f68704';
								}
							?>
							<div class="quiz-item">
								<div class="quiz-side-info">
									<div class="count-wrapper">
										<!-- Answer Rate -->
										<p class="client-text" style="font-size:12px;">정답률</p>
										<p style="font-weight:700;color:<?php echo htmlspecialchars($color); ?>; margin-top:5px;"><?php
										echo htmlspecialchars($percent) . "%";
										?></p>
									</div>
								</div>
								<div class="quiz-main-info">
									<div class="quiz-title-wrapper">
										<a class="quiz-link overlay-link" href="<?php echo 'show.php?quiz_id=' . htmlspecialchars($row['id']); ?>"></a>
										<p class="quiz-title"><?php echo htmlspecialchars($row['title']); ?></p>
									</div>
									<div class="quiz-info">
										<?php
										$uploader_index = mysqli_real_escape_string($conn, $row['user_index']);
										$sql = "SELECT * FROM `dcp_user_info` WHERE `id`='$uploader_index'";
										if ($uploader_result = mysqli_query($conn, $sql)) {
											$uploader = mysqli_fetch_assoc($uploader_result);
										}
										?>
										<?php
										$created_at = strtotime($row['created_at']);
										?>
										<!-- Like count -->
										<p class="information"><span class="like-count" <?php
										if ($row['recommend'] == 0) echo 'style="opacity:0.4"';
										?>><?php
										echo htmlspecialchars($row['recommend']);
										?></span> <span class="comment-count" <?php
										if ($row['comment'] == 0) echo 'style="opacity:0.4"';
										?>><?php
										echo htmlspecialchars($row['comment']);
										?></span> <?php
										$cat_id = mysqli_real_escape_string($conn, $row['category']);
										$sql = "SELECT * FROM dcp_quiz_category WHERE category_id=$cat_id";
										if ($cat_result = mysqli_query($conn, $sql)) {
											$quiz_category = mysqli_fetch_assoc($cat_result);
											$quiz_category_name = $quiz_category['category_name'];
										}
										echo '<span class="category">'.htmlspecialchars($quiz_category_name).'</span>';
										if (date("Y-m-d", $created_at) === date("Y-m-d")) {
											echo ' <span class="date">'.date("H:i", $created_at)."</span>";
										} else {
											echo ' <span class="date">'.date("m-d", $created_at).'</span>';
										}
										?> <span class="uploader"><?php echo $uploader['nickname']; ?></span></p>
									</div>
								</div>

							</div>
							<?php } ?>
						</div>

						<!-- Page Selector -->
						<?php include '../php-include/page-selector.php'; ?>

						<!-- Search Engine -->
						<?php include '../php-include/search-module.php'; ?>
					</section>

					<!-- Side content -->
					<?php include("php-include/side-content.php"); ?>
				</div>

				<!-- Modal -->
				<?php include("../php-include/modal.php"); ?>
			</main>
			<?php include("../php-include/footer.php"); ?>
		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/qs.built.js"></script>

		<?php
		if (isset($_SESSION['error'])) { ?>
			<script>openModal('<?php echo $_SESSION['error']; ?>')</script>
		<?php
			unset($_SESSION['error']);
		} ?>
	</body>
</html>
