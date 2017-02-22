<?php 


		if (!function_exists('curl_init')){ 
		die('CURL is not installed!');
		}
		$url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=Testing_Telegram   ";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt ($ch, CURLOPT_CAINFO, "C:/xampp/htdocs/toko-full/cacert.pem");


		echo  $output = curl_exec($ch);

		if(curl_errno($ch)){
		echo 'Curl error: ' . curl_error($ch);
		}
		curl_close($ch);




?>