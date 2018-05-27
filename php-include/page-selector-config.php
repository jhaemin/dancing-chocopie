<?php

// set page number
$result = mysqli_query($conn, $sql);
if (!$result) {
	die(mysqli_error($conn));
}

$num = mysqli_num_rows($result);
$max_page = intval($num / $max_limit);

if ($num % $max_limit != 0) {
	$max_page += 1;
}

// codes below must be executed after calculated max_page
if (!empty($_GET['page'])) {
	// wrong page number - over max page or less than 0
	if ($_GET['page'] > $max_page || $_GET['page'] < 0) {
		header("Location: ../index.php");
	}
	$page = $_GET['page'];
}

$start_limit = ($page - 1) * $max_limit;
$page_num_start = intval($page / ($page_num + 1)) * $page_num + 1;

// select limited quiz based on mode
$sql .= " LIMIT $start_limit, $max_limit";
$page_result = mysqli_query($conn, $sql);
if (!$page_result) {
	die(mysqli_error($conn));
}

?>
