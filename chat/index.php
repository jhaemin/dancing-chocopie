<?php

session_start();

if (!isset($_SESSION['user_index'])) {
	header("Location: ../index.php");
	die();
}

if (!isset($_GET['to'])) {
	header("Location: ../index.php");
}

include '../php-include/connect.php';
include '../php-include/conf.php';

$to = mysqli_real_escape_string($conn, $_GET['to']);
$from = mysqli_real_escape_string($conn, $_SESSION['user_index']);

?>

<!DOCTYPE html>
<?php include '../php-include/html-hd.php'; ?>
	<head>
		<title></title>
		<?php include("../php-include/header.php"); ?>
		<link rel="stylesheet" href="css/chat.built.css" />
		<?php include("../php-include/hd-js.php"); ?>
	</head>
	<body class="chat-body">
		<div id="page" class="chat-page">
			<?php include("../php-include/globalnav.php"); ?>
			<main id="main" class="chat-main">
				<div id="chat">
					<div id="chat-contents-container">
						<?php
						$sql = "SELECT * FROM dcp_chat WHERE (`from`='$from' AND `to`='$to') OR (`from`='$to' AND `to`='$from')";
						if (!($chat_get_result = mysqli_query($conn, $sql))) {
							echo mysqli_error($conn);
						}
						while ($chat_row = mysqli_fetch_assoc($chat_get_result)) {
						?>
						<div class="chat-bubble-container <?php
						if ($chat_row['from'] == $to) {
							echo 'received';
						} else {
							echo 'sent';
						}
						?>">
							<div class="chat-bubble">
								<p><?php echo htmlspecialchars($chat_row['message']); ?></p>
							</div>
						</div>
						<?php } ?>
					</div>
					<form class="chat-input-container">
						<input type="hidden" name="to" value="<?php echo htmlspecialchars($to); ?>">
						<input class="chat-text-input" type="text" name="msg" value="" placeholder="메시지를 입력하세요." autocomplete="off" />
						<button class="chat-send" type="submit" name="button">전송</button>
					</form>
				</div>
			<?php include("../php-include/modal.php"); ?>
			</main>

		</div>
		<?php include("../php-include/ft-js.php"); ?>
		<script src="js/chat.built.js"></script>
	</body>
</html>
