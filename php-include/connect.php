<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/verify-server.html")) {
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "dancingchocopie";
} else {
	$servername = "localhost";
	$username = "dancingc_choco";
	$password = "letchocopiedance17";
	$dbname = "dancingc_chocopie";
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check mysql initial charset
// printf("Initial character set: %s\n", mysqli_character_set_name($conn));

// change mysql charset
mysqli_set_charset($conn, "utf8");
// printf("Initial character set: %s\n", mysqli_character_set_name($conn));

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
	setlocale(LC_ALL, "ko_KR.euc-kr");
	date_default_timezone_set('Asia/Seoul');
	// header('Content-Type: text/html; charset=utf-8');
}

$local = "";
// set_include_path($_SERVER["DOCUMENT_ROOT"]);
if (file_exists($_SERVER['DOCUMENT_ROOT']."/verify-server.html")) {
	$local = "/dancingchocopie";
	// set_include_path($_SERVER["DOCUMENT_ROOT"]."/dancingchocopie");
}
$isconfigured = true;
?>
