<?php


require("../../PHPMailer/PHPMailerAutoload.php");



$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->CharSet = 'UTF-8';
$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'mail.dancingchocopie.net';			  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'no-reply@dancingchocopie.net';		                  // SMTP username
$mail->Password = 'letchocopiedance17';                   // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('no-reply@dancingchocopie.net', '[춤추는 초코파이]');
$mail->addAddress($user_id);     // Add a recipient
// $mail -> addAddress("lepor_lepos@icloud.com");

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = '춤추는 초코파이 가입을 환영합니다.';
$mail->Body    = file_get_contents('../../email/email-p1.html') . "https://dancingchocopie.net/user-verification.php?i=" . $index . "&v=" . $hash . file_get_contents('../../email/email-p2.html');
// for the mail clients which not support HTML email
$mail->AltBody = "https://dancingchocopie.net/user-verification.php?i=" . $index . "&v=" . $hash . " 이 링크를 브라우저에 붙여넣어서 접속해주세요. 감사합니다.";


if(!$mail->send()) {
    // echo 'Message could not be sent.';
    // echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	$return['issuccess'] = 1;
    // echo 'Message has been sent';
}


?>
