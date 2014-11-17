<?php
while (1) {
	$guid = '73352dc3-06b1-465c-8544-28d5f0f7f817'; // GUID
	$main_password = 'fuckermoth3r'; // password
	
	$interval = 60; //seconds between lookups
	$threshold = 0.01; // amount needed, in BTC, to move funds
	
	$new_address = '1Apu2HQEW7k4zo9KxjdP7BK3PpETgRQmMR'; // address to send funds to

	$addresses = json_decode(file_get_contents("https://blockchain.info/merchant/$guid/list?password=$main_password"), true);
	$addr_count = count($addresses['addresses']);
	
	$i = 0;
	
	while ($i < $addr_count) {
		$balance = $addresses['addresses'][$i]['balance'];
		$address = $addresses['addresses'][$i]['address'];
		$fee = 0.0001*100000000;
		$amt = ($balance - $fee);
		if ($bal >= $threshold) {
			echo 'Transferring funds to '.$new_address.' ...'."\n";
			$send = "https://blockchain.info/merchant/$guid/payment?password=$main_password&to=$new_address&amount=$amt&from=$address&fee=$fee";
			$status = get_headers($send, 1);
			if ($status = 200) {	
				echo 'BTC transferred to second addrress.'."\n";
				} else {
					echo 'Malformed transaction request.'."\n";
				}
		} else {
			echo 'Balance too low in address to transfer at this time. Checking again in '.$interval.' seconds.'."\n";
		}
		$i++;
	}
	sleep($interval);
}
?>