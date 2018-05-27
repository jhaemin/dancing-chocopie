<!-- mypage header -->
<?php

$user_index = mysqli_real_escape_string($conn, $_SESSION['user_index']);
$sql = "SELECT * FROM dcp_user_info WHERE id='$user_index'";
$result = mysqli_query($conn, $sql);
if ($result) {
	$user = mysqli_fetch_assoc($result);
} else {
	die(mysqli_error($conn));
}

?>
<section class="my-header">
	<h1 class="my-nn client-text"><?php echo htmlspecialchars($_SESSION['nickname']); ?><span class="my-nn-ex"> 님의 마이페이지</span></h1>
</section>
