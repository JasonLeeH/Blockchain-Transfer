<?php
	while (1) {
		$address = '1DspudQpvjehGaAzqxTiTAC3oranA2cHZ2'; // address to check balance
		$new_address = '1Q3H2249Lpby18RH5bkxjeen7nkzTDVzPJ'; // address to send funds to
		$interval = 60; //seconds between lookups
		$threshold = 0.01; // amount needed, in BTC, to move funds
		
		$guid = '8484afca-e8cf-4b05-a705-5295dcd33a64'; // GUID
		$main_password = 'not2bhacked'; // password
		
		$balance = file_get_contents('https://blockchain.info/q/addressbalance/'.$address)/100000000;
		$fee = 0.0001;
		
		$amt = ($balance - $fee)*100000000;
		
		if ($balance >= $threshold) {
			echo 'Transferring funds to second address...'."\n";
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
		sleep($interval);
	}
?>