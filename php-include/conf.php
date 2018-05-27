<?php

$local = "";
// set_include_path($_SERVER["DOCUMENT_ROOT"]);
if (file_exists($_SERVER['DOCUMENT_ROOT']."/verify-server.html")) {
	$local = "/dancingchocopie";
	// set_include_path($_SERVER["DOCUMENT_ROOT"]."/dancingchocopie");
}

if (isset($_SESSION['user_index'])) {
	$loggedin = true;
} else {
	$loggedin = false;
}

?>
