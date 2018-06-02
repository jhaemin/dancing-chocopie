<?php
session_start();
session_destroy();

$local = "";
if (file_exists($_SERVER['DOCUMENT_ROOT']."/verify-server.html")) {
	$local = "/dancingchocopie";
}
header("Location: ".$local."/login.php");
?>
