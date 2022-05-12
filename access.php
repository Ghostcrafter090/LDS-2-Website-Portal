<?php
	if (isset($_GET['key'])) {
		$key = $_GET['key'];
	}
	$minute = file_get_contents(".\accessMin.cx");
	$grabbed = "no";
	if ($minute != date("h:i")) {
		file_put_contents(".\accessMin.cx", date("h:i"));
		$grabbed = "yes";
		try {
			file_put_contents(".\current_data.json", file_get_contents("https://api.weather.com/v2/pws/observations/current?stationId=IFALLRIV2&format=json&units=s&apiKey=". $key));
		} catch ($e) {
			file_put_contents(".\accessMin.cx", "0:0");
		}
	}
	$danger = file_get_contents(".\danger.txt");
	echo "{'data': {'main': ". file_get_contents(".\current_data.json"). ", 'lightning_danger': ". $danger. "}, 'grabbed': '". $grabbed. "'}";
	