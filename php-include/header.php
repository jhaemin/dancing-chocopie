<?php

if (!$isconfigured) {
	$local = "";
	// set_include_path($_SERVER["DOCUMENT_ROOT"]);
	if (file_exists($_SERVER['DOCUMENT_ROOT']."/verify-server.html")) {
		$local = "/dancingchocopie";
		// set_include_path($_SERVER["DOCUMENT_ROOT"]."/dancingchocopie");
	}
	$isconfigured = true;
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $local; ?>/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $local; ?>/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $local; ?>/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $local; ?>/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo $local; ?>/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $local; ?>/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $local; ?>/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $local; ?>/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="<?php echo $local; ?>/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="<?php echo $local; ?>/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="<?php echo $local; ?>/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="<?php echo $local; ?>/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="<?php echo $local; ?>/favicon-128.png" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />

<link rel="stylesheet" href="<?php echo $local; ?>/css/fonts.css" />
<link rel="stylesheet" href="<?php echo $local; ?>/css/globalstyle.css" />
<link rel="stylesheet" href="<?php echo $local; ?>/css/globalnav.css">
<link rel="stylesheet" href="<?php echo $local; ?>/css/footer.css" />
