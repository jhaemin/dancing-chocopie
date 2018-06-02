function next() {
	if ($('#pp-agree').is(":checked")) {
		location.replace("register.php");
	} else {
		alert("개인정보 취급방침에 동의해야합니다.");

	}
}
