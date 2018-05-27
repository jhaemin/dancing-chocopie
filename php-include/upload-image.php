<?

// imgur client_id
$client_id="bb7e32afbf40629";

do {
	if (!isset($_POST)) {
		break;
	}

	$img = $_FILES['file-0'];


	if($img['name']==''){
		echo "An Image Please.";
		break;
	}

	if ($img['size'] > 2000000) { // image is larger than 2MB
	    echo "이미지 용량이 너무 큽니다.";
		break;
	}

	$filename = $img['tmp_name'];
	$handle = fopen($filename, "r");
	$data = fread($handle, filesize($filename));
	$pvars   = array('image' => base64_encode($data));
	$timeout = 30;
	$curl    = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
	array('Authorization: Client-ID ' . $client_id));
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$out = curl_exec($curl);
	curl_close ($curl);
	$pms = json_decode($out,true);
	$url = $pms['data']['link'];
	if($url != ""){
		// echo "<h2>Uploaded Without Any Problem</h2>";
		// echo "image url : $url <br />";
		// echo "<img src='$url'/>";
		$url = str_replace('http', 'https', $url);
		echo $url;
	} else {
		echo "알 수 없는 문제가 발생했습니다. 잠시 후 다시 시도해주세요.";
	}
} while (0);
?>
