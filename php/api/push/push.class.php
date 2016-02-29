<?php

	class push_notification {

		private static $failed_resend = 0;
		private static $resend_array = array();
		private static $tmp_logs;
		
		function __construct() {
			include_once('php/api/php/logs/logs.class.php');
			$logs = NEW logs();
			self::$tmp_logs = $logs;
		}

		public function ios($ios_deviceID, $message, $certname, $env, $type) {
			$logs = self::$tmp_logs;
			$apn_chunk = array_chunk($ios_deviceID, 25);
			$apple_expiry = time() + (90 * 24 * 60 * 60);
			$load = array(
				'aps' => array(
				'alert' => $message,
				// 'badge' => 1,
				'sound' => 'default',
				'option' => $type
				)
			);	
			$payload = json_encode($load);

			for ($i=0; $i<count($apn_chunk); $i++) {
				$streamContext = stream_context_create();
				stream_context_set_option($streamContext, 'ssl', 'passphrase', '');
				stream_context_set_option($streamContext, 'ssl', 'local_cert', 'php/api/push/certificates/'.$certname);
				if ($env == "production") {
					$apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60,STREAM_CLIENT_CONNECT, $streamContext);
				} elseif ($env == "development") {
					$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 60,STREAM_CLIENT_CONNECT, $streamContext);
				}
				stream_set_blocking ($apns, 0); 

				for ($x=0; $x<count($apn_chunk[$i]); $x++) {
					$apple_identifier = $i.$x;
					$deviceToken = $apn_chunk[$i][$x];
					$apnsMessage = pack("C", 1) . pack("N", $apple_identifier) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
					fwrite($apns, $apnsMessage);
					$apple_error_response = $this->checkAppleErrorResponse($apns, $deviceToken, "False");
					$logs->write_logs("Push Notification", "push.class.php", "Platform: IOS\t PushID: $deviceToken\t Apple Error Response: $apple_error_response\t Flag: False");
				}
				fclose($apns);
				ob_flush();
			}

			if (count(self::$resend_array) > 0) {
				$resend_chunk = array_chunk(self::$resend_array, 25);

				for ($i=0; $i<count($resend_chunk); $i++) {
					$streamContext = stream_context_create();
					stream_context_set_option($streamContext, 'ssl', 'passphrase', '');
					stream_context_set_option($streamContext, 'ssl', 'local_cert', 'php/api/push/certificates/'.$certname);
					if ($env == "production") {
						$apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60,STREAM_CLIENT_CONNECT, $streamContext);
					} elseif ($env == "development") {
						$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 60,STREAM_CLIENT_CONNECT, $streamContext);
					}
					stream_set_blocking ($apns, 0);

					for ($x=0; $x<count($resend_chunk[$i]); $x++) {
						$apple_identifier = "RS".$i.$x;
						$deviceToken = $resend_chunk[$i][$x];
						$apnsMessage = pack("C", 1) . pack("N", $apple_identifier) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
						fwrite($apns, $apnsMessage);
						$apple_error_response = $this->checkAppleErrorResponse($apns, $deviceToken, "True");
						$logs->write_logs("Push Notification", "push.class.php", "Platform: IOS\t PushID: $deviceToken\t Apple Error Response: $apple_error_response\t Flag: True");
					}
					fclose($apns);
					ob_flush();
				}
			}
		}
		
		public function android($android_GCM_regID, $message, $type) {
			$logs = self::$tmp_logs;
			$registration_ids = $android_GCM_regID;
			$message = array("price" => $message, "option" => $type);

			$GOOGLE_API_KEY = "AIzaSyDmDKjIwlBcPDFr82ZK0WwyZklLI_MBoSg";
	        $url = 'https://android.googleapis.com/gcm/send';

	        $fields = array(
	            'registration_ids' => $registration_ids,
	            'data' => $message,
	        );

	        $headers = array(
	            'Authorization: key=' . $GOOGLE_API_KEY,
	            'Content-Type: application/json'
	        );

	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	        $result = curl_exec($ch);

	        $android_GCM_regID_list = implode(",\r\n\t\t\t", $android_GCM_regID);

	        if ($result === FALSE) {
	        	$logs->write_logs("Push Notification", "push.class.php", "Platform: ANDROID\r\n\tPushID: $android_GCM_regID_list\r\n\tResponse: Curl failed > ".curl_error($ch));
	            die('Curl failed: ' . curl_error($ch));
	        } else {
	        	$logs->write_logs("Push Notification", "push.class.php", "Platform: ANDROID\r\n\tPushID: $android_GCM_regID_list\r\n\tResponse: Success");
	            return "Success";
	        }

	        curl_close($ch);
		}

		public function checkAppleErrorResponse($apns, $deviceToken, $resend) {
			$apple_error_response = fread($apns, 6);

			if ($apple_error_response) {
				$error_response = unpack('Ccommand/Cstatus_code/Nidentifier', $apple_error_response); 

				if ($error_response['status_code'] == '0') {
					return "0";
				} else if ($error_response['status_code'] == '1') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "1";
				} else if ($error_response['status_code'] == '2') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "2";
				} else if ($error_response['status_code'] == '3') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "3";
				} else if ($error_response['status_code'] == '4') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "4";
				} else if ($error_response['status_code'] == '5') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "5";
				} else if ($error_response['status_code'] == '6') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "6";
				} else if ($error_response['status_code'] == '7') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "7";
				} else if ($error_response['status_code'] == '8') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "8";
				} else if ($error_response['status_code'] == '255') {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "255";
				} else {
					if ($resend == "False") {
						array_push(self::$resend_array, $deviceToken);
					} else {
						self::$failed_resend += 1;
					}
					return "-";
				}
				return "-";
			}		       
			return "-";
		}

	}

?>