<?php
	if (isset($_GET['urlf'])) {
		$url = "https://tineye.com/result_json/?sort=score&order=desc";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:101.0) Gecko/20100101 Firefox/101.0",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
			"Accept-Language: en-CA,en-US;q=0.7,en;q=0.3",
			"Content-Type: application/x-www-form-urlencoded",
			"Upgrade-Insecure-Requests: 1",
			"Sec-Fetch-Dest: document",
			"Sec-Fetch-Mode: navigate",
			"Sec-Fetch-Site: cross-site",
			"Sec-Fetch-User: ?1"
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$urlf = $_GET['urlf'];
		$data = "url=". urlencode($urlf);
		echo $data;

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		$resp = curl_exec($curl);
		curl_close($curl);

		echo $resp;
	} else {
		echo '{"error": "401 BAD REQUEST"}';
	}
?>
	