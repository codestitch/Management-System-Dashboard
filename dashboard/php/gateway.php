<?php
	/********** PHP INIT **********/
	header('Cache-Control: no-cache');
	set_time_limit(0);
	ini_set('memory_limit', '-1');
	ini_set('mysql.connect_timeout','0');
	ini_set('max_execution_time', '0');
	ini_set('date.timezone', 'Asia/Manila');
	
	require_once('../../php/api/cipher/cipher.class.php');
	require_once('../../php/api/settings/config.php');
	// $path = PATH."/dashboard.php";
	$path = str_replace("/dashboard", "", PATH)."dashboard.php"; 
	

	if ((!isset($_POST['function'])) || (!$_POST['function'])) {
		echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
		return;
		die();
	}

	$function = $_POST['function'];
	$output = array();
	$key = randomizer(32);
	$iv = randomizer(16);

	$cipher = NEW cipher($key, $iv);

	switch ($function) {
		case 'login':
			$username = "";
			$password = "";

			if ((!isset($_POST['username'])) || (!$_POST['username'])) {
				echo json_encode(array(array("response"=>"Error", "description"=>"Invalid Username/Password.")));
				return;
				die();
			} else {
				$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$username = $cipher->encrypt($username);
			}

			if ((!isset($_POST['password'])) || (!$_POST['password'])) {
				echo json_encode(array(array("response"=>"Error", "description"=>"Invalid Username/Password.")));
				return;
				die();
			} else {
				$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$password = $cipher->encrypt($password);
			}

			$function = $cipher->encrypt("login");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&username=".urlencode($username)."&password=".urlencode($password);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			$output = json_decode($server_output);

			if (($output[0]->response) == "Success") {
				session_start();
				$_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'] = $output[0]->data->accountID;
				$_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'] = $output[0]->data->loginSession;
				$_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ROLE'] = $output[0]->data->role;
				echo $output[0]->response;
			} else {
				if(!$output[0]->response) {
					echo $server_output;
				} else {
					echo $output[0]->response;
				}
			}

			break;

		case 'password':
			$old_password = "";
			$new_password = "";

			if ((!isset($_POST['old_password'])) || (!$_POST['old_password'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$old_password = filter_var($_POST['old_password'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

				if (preg_match('/^[a-zA-Z0-9]+$/', $old_password) <= 0) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$old_password = $cipher->encrypt($old_password);
			}

			if ((!isset($_POST['new_password'])) || (!$_POST['new_password'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

				if (preg_match('/^[a-zA-Z0-9]+$/', $new_password) <= 0) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$new_password = $cipher->encrypt($new_password);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("password");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&old_password=".urlencode($old_password)."&new_password=".urlencode($new_password);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'json':
			$table = "";

			if ((!isset($_POST['table'])) || (!$_POST['table'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$table = filter_var($_POST['table'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$table = $cipher->encrypt($table);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("json");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&table=".urlencode($table);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'send_push':
			$message = "";
			$type = "";

			if ((!isset($_POST['message'])) || (!$_POST['message'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$message = $cipher->encrypt($message);
			}

			if ((!isset($_POST['type'])) || (!$_POST['type'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$type = $cipher->encrypt($type);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("send_push");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&message=".urlencode($message)."&type=".urlencode($type);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;


		case 'add_location':
			$name = "";
			$address = "";
			$latitude = "";
			$longitude = "";
			$branch = "";
			$phone = "";
			$email = "";
			$status = "";
			$loyalty = "";
			$image = ""; 

			if ((!isset($_POST['name'])) || ($_POST['name'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in name.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['address'])) || ($_POST['address'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in address.")));
				return;
				die();
			} else {
				$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$address = $cipher->encrypt($address);
			}

			if ((!isset($_POST['latitude'])) || ($_POST['latitude'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in latitude.")));
				return;
				die();
			} else {
				$latitude = filter_var($_POST['latitude'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$latitude = $cipher->encrypt($latitude);
			}

			if ((!isset($_POST['longitude'])) || ($_POST['longitude']  == NULL )) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in longitude.")));
				return;
				die();
			} else {
				$longitude = filter_var($_POST['longitude'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$longitude = $cipher->encrypt($longitude);
			}

			if ((!isset($_POST['branch'])) || ($_POST['branch'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in branch.")));
				return;
				die();
			} else {
				$branch = filter_var($_POST['branch'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$branch = $cipher->encrypt($branch);
			}

			if ((!isset($_POST['phone'])) || ($_POST['phone'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in phone.")));
				return;
				die();
			} else {
				$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$phone = $cipher->encrypt($phone);
			}

			if ((!isset($_POST['email'])) || ($_POST['email'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in email.")));
				return;
				die();
			} else {
				$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$email = $cipher->encrypt($email);
			}

			if ((!isset($_POST['status'])) || ($_POST['status'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in status.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in status value.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			if ((!isset($_POST['loyalty'])) || ($_POST['loyalty'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in loyalty.")));
				return;
				die();
			} else {
				if (($_POST['loyalty'] != 'active') && ($_POST['loyalty'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in loyalty value.")));
					return;
					die();
				}

				$loyalty = filter_var($_POST['loyalty'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$loyalty = $cipher->encrypt($loyalty);
			}

			if ((!isset($_POST['image'])) || ($_POST['image'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in image.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}


			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_location");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&address=".urlencode($address)."&latitude=".urlencode($latitude)."&longitude=".urlencode($longitude)."&branch=".urlencode($branch)."&phone=".urlencode($phone)."&email=".urlencode($email)."&status=".urlencode($status)."&loyalty=".urlencode($loyalty)."&image=".urlencode($image);

			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_location':
			$locID = "";
			$name = "";
			$address = "";
			$latitude = "";
			$longitude = "";
			$branch = "";
			$phone = "";
			$email = "";
			$status = "";
			$loyalty = "";
			$image = ""; 

			if ((!isset($_POST['locID'])) || ($_POST['locID'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in locID.")));
				return;
				die();
			} else {
				$locID = filter_var($_POST['locID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$locID = $cipher->encrypt($locID);
			}

			if ((!isset($_POST['name'])) || ($_POST['name'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in name.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['address'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in address.")));
				return;
				die();
			} else {
				$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$address = $cipher->encrypt($address);
			}

			if ((!isset($_POST['latitude']))  ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in latitude.")));
				return;
				die();
			} else {
				$latitude = filter_var($_POST['latitude'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$latitude = $cipher->encrypt($latitude);
			}

			if ((!isset($_POST['longitude']))  ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in longitude.")));
				return;
				die();
			} else {
				$longitude = filter_var($_POST['longitude'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$longitude = $cipher->encrypt($longitude);
			}

			if ((!isset($_POST['branch'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in branch.")));
				return;
				die();
			} else {
				$branch = filter_var($_POST['branch'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$branch = $cipher->encrypt($branch);
			}

			if ((!isset($_POST['phone'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in phone.")));
				return;
				die();
			} else {
				$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$phone = $cipher->encrypt($phone);
			}

			if ((!isset($_POST['email'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in email.")));
				return;
				die();
			} else {
				$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$email = $cipher->encrypt($email);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in status.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in status value.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			if ((!isset($_POST['loyalty'])) || (!$_POST['loyalty'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in loyalty.")));
				return;
				die();
			} else {
				if (($_POST['loyalty'] != 'active') && ($_POST['loyalty'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request in loyalty value.")));
					return;
					die();
				}

				$loyalty = filter_var($_POST['loyalty'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$loyalty = $cipher->encrypt($loyalty);
			}

			if ((!isset($_POST['image'])) || ($_POST['image'] == NULL)) {
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_location");

			
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&locID=".urlencode($locID)."&name=".urlencode($name)."&address=".urlencode($address)."&latitude=".urlencode($latitude)."&longitude=".urlencode($longitude)."&branch=".urlencode($branch)."&phone=".urlencode($phone)."&email=".urlencode($email)."&status=".urlencode($status)."&loyalty=".urlencode($loyalty)."&image=".urlencode($image);

			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_press':
			$image = "";
			$status = "";

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_press");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_press':
			$pressID = "";

			if ((!isset($_POST['pressID'])) || (!$_POST['pressID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$pressID = filter_var($_POST['pressID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$pressID = $cipher->encrypt($pressID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_press");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&pressID=".urlencode($pressID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_press':
			$pressID = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['pressID'])) || (!$_POST['pressID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$pressID = filter_var($_POST['pressID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$pressID = $cipher->encrypt($pressID);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_press");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&pressID=".urlencode($pressID)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_promo':
			$name = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_promo");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_promo':
			$promoID = "";

			if ((!isset($_POST['promoID'])) || (!$_POST['promoID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$promoID = filter_var($_POST['promoID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$promoID = $cipher->encrypt($promoID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_promo");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&promoID=".urlencode($promoID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_promo':
			$promoID = "";
			$name = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['promoID'])) || (!$_POST['promoID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$promoID = filter_var($_POST['promoID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$promoID = $cipher->encrypt($promoID);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);


			$function = $cipher->encrypt("update_promo");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&promoID=".urlencode($promoID)."&name=".urlencode($name)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_loyalty':
			$name = "";
			$points = "";
			$terms = "";
			$description = "";
			$status = "";

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['points']))) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$points = filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_INT);
				$points = $cipher->encrypt($points);
			}

			if ((!isset($_POST['terms'])) || (!$_POST['terms'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $terms = filter_var($_POST['terms'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$terms = $cipher->encrypt(htmlentities(stripcslashes($_POST['terms']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_loyalty");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&points=".urlencode($points)."&terms=".urlencode($terms)."&description=".urlencode($description)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_loyalty':
			$loyaltyID = "";

			if ((!isset($_POST['loyaltyID'])) || (!$_POST['loyaltyID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$loyaltyID = filter_var($_POST['loyaltyID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$loyaltyID = $cipher->encrypt($loyaltyID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_loyalty");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&loyaltyID=".urlencode($loyaltyID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_loyalty':
			$loyaltyID = "";
			$name = "";
			$points = "";
			$terms = "";
			$description = "";
			$status = "";

			if ((!isset($_POST['loyaltyID'])) || (!$_POST['loyaltyID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$loyaltyID = filter_var($_POST['loyaltyID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$loyaltyID = $cipher->encrypt($loyaltyID);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['points'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$points = filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_INT);
				$points = $cipher->encrypt($points);
			}

			if ((!isset($_POST['terms'])) || (!$_POST['terms'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $terms = filter_var($_POST['terms'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$terms = $cipher->encrypt(htmlentities(stripcslashes($_POST['terms']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_loyalty");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&loyaltyID=".urlencode($loyaltyID)."&name=".urlencode($name)."&points=".urlencode($points)."&terms=".urlencode($terms)."&description=".urlencode($description)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_staff':
			$name = "";
			$description = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_staff");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&description=".urlencode($description)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_staff':
			$staffID = "";

			if ((!isset($_POST['staffID'])) || (!$_POST['staffID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$staffID = filter_var($_POST['staffID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$staffID = $cipher->encrypt($staffID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_staff");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&staffID=".urlencode($staffID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_staff':
			$staffID = "";
			$name = "";
			$description = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['staffID'])) || (!$_POST['staffID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$staffID = filter_var($_POST['staffID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$staffID = $cipher->encrypt($staffID);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_staff");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&staffID=".urlencode($staffID)."&name=".urlencode($name)."&description=".urlencode($description)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_post':
			$title = "";
			$description = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['title'])) || (!$_POST['title'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$title = $cipher->encrypt($title);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_post");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&title=".urlencode($title)."&description=".urlencode($description)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_post':
			$postID = "";

			if ((!isset($_POST['postID'])) || (!$_POST['postID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$postID = filter_var($_POST['postID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$postID = $cipher->encrypt($postID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_post");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&postID=".urlencode($postID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_post':
			$postID = "";
			$title = "";
			$description = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['postID'])) || (!$_POST['postID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$postID = filter_var($_POST['postID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$postID = $cipher->encrypt($postID);
			}

			if ((!isset($_POST['title'])) || (!$_POST['title'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$title = $cipher->encrypt($title);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_post");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&postID=".urlencode($postID)."&title=".urlencode($title)."&description=".urlencode($description)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_product':
			$category = "";
			$name = "";
			$description = "";
			$price = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['category'])) || (!$_POST['category'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$category = filter_var($_POST['category'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$category = $cipher->encrypt($category);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['price'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
				$price = $cipher->encrypt($price);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_product");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&category=".urlencode($category)."&name=".urlencode($name)."&description=".urlencode($description)."&price=".urlencode($price)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_product':
			$prodID = "";

			if ((!isset($_POST['prodID'])) || (!$_POST['prodID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$prodID = filter_var($_POST['prodID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$prodID = $cipher->encrypt($prodID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_product");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&prodID=".urlencode($prodID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_product':
			$prodID = "";
			$category = "";
			$name = "";
			$description = "";
			$price = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['prodID'])) || (!$_POST['prodID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$prodID = filter_var($_POST['prodID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$prodID = $cipher->encrypt($prodID);
			}


			if ((!isset($_POST['category'])) || (!$_POST['category'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$category = filter_var($_POST['category'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$category = $cipher->encrypt($category);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['price'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
				$price = $cipher->encrypt($price);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_product");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&prodID=".urlencode($prodID)."&category=".urlencode($category)."&name=".urlencode($name)."&description=".urlencode($description)."&price=".urlencode($price)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_category':
			$name = "";
			$icon = "";
			$image = "";
			$status = "";

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}

			if ((!isset($_POST['icon']))) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$icon = filter_var($_POST['icon'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$icon = $cipher->encrypt($icon);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_category");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&image=".urlencode($image)."&icon=".urlencode($icon)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_category':
			$categoryID = "";
			$name = "";
			$icon = "";
			$image = "";
			$status = "";


			if ((!isset($_POST['categoryID'])) || (!$_POST['categoryID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$categoryID = filter_var($_POST['categoryID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$categoryID = $cipher->encrypt($categoryID);
			}

			if ((!isset($_POST['name']))  ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['image'])) || (!$_POST['image']) || (strtoupper($_POST['image']) == 'NULL')) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 6")));
				// return;
				// die();
				$image = NULL;
			} else {
				$image = filter_var($_POST['image'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$image = $cipher->encrypt($image);
			}


			if ((!isset($_POST['icon'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$icon = filter_var($_POST['icon'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$icon = $cipher->encrypt($icon);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);


			$function = $cipher->encrypt("update_category");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&categoryID=".urlencode($categoryID)."&name=".urlencode($name)."&icon=".urlencode($icon)."&image=".urlencode($image)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'view_record':
			$table = "";
			$recordID = "";

			// echo $table."--";

			if ((!isset($_POST['table'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request Table.")));
				return;
				die();
			} else {
				$table = filter_var($_POST['table'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$table = $cipher->encrypt($table);
			}

			if ((!isset($_POST['recordID'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request recordID.")));
				return;
				die();
			} else {
				$recordID = filter_var($_POST['recordID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$recordID = $cipher->encrypt($recordID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("view_record");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&table=".urlencode($table)."&recordID=".urlencode($recordID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_profile_info':
			$company = "";
			$fname1 = "";
			$mname1 = "";
			$lname1 = "";
			$fname2 = "";
			$mname2 = "";
			$lname2 = "";
			$landline1 = "";
			$landline2 = "";
			$mobile1 = "";
			$mobile2 = "";
			$fax1 = "";
			$fax2 = "";
			$email = "";
			$address = "";
			$website = "";
			$about = "";

			if ((!isset($_POST['company'])) || (!$_POST['company'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$company = $cipher->encrypt($company);
			}

			if ((!isset($_POST['fname1'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$fname1 = filter_var($_POST['fname1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$fname1 = $cipher->encrypt($fname1);
			}

			if ((!isset($_POST['mname1'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$mname1 = NULL;
			} else {
				$mname1 = filter_var($_POST['mname1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$mname1 = $cipher->encrypt($mname1);
			}

			if ((!isset($_POST['lname1'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$lname1 = filter_var($_POST['lname1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$lname1 = $cipher->encrypt($lname1);
			}

			if ((!isset($_POST['fname2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$fname2 = NULL;
			} else {
				$fname2 = filter_var($_POST['fname2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$fname2 = $cipher->encrypt($fname2);
			}

			if ((!isset($_POST['mname2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$mname2 = NULL;
			} else {
				$mname2 = filter_var($_POST['mname2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$mname2 = $cipher->encrypt($mname2);
			}

			if ((!isset($_POST['lname2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$lname2 = NULL;
			} else {
				$lname2 = filter_var($_POST['lname2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$lname2 = $cipher->encrypt($lname2);
			}

			if ((!isset($_POST['landline1'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$landline1 = NULL;
			} else {
				$landline1 = filter_var($_POST['landline1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$landline1 = $cipher->encrypt($landline1);
			}

			if ((!isset($_POST['landline2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$landline2 = NULL;
			} else {
				$landline2 = filter_var($_POST['landline2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$landline2 = $cipher->encrypt($landline2);
			}

			if ((!isset($_POST['mobile1'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$mobile1 = NULL;
			} else {
				$mobile1 = filter_var($_POST['mobile1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$mobile1 = $cipher->encrypt($mobile1);
			}

			if ((!isset($_POST['mobile2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$mobile2 = NULL;
			} else {
				$mobile2 = filter_var($_POST['mobile2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$mobile2 = $cipher->encrypt($mobile2);
			}

			if ((!isset($_POST['fax1'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$fax1 = NULL;
			} else {
				$fax1 = filter_var($_POST['fax1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$fax1 = $cipher->encrypt($fax1);
			}

			if ((!isset($_POST['fax2'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$fax2 = NULL;
			} else {
				$fax2 = filter_var($_POST['fax2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$fax2 = $cipher->encrypt($fax2);
			}

			if ((!isset($_POST['email'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
				$email = $cipher->encrypt($email);
			}

			if ((!isset($_POST['address'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$address = NULL;
			} else {
				$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$address = $cipher->encrypt($address);
			}

			if ((!isset($_POST['website'])) ) {
				// echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				// return;
				// die();
				$website = NULL;
			} else {
				$website = filter_var($_POST['website'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$website = $cipher->encrypt(htmlentities(stripcslashes($_POST['website']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['about'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$about = $cipher->encrypt(htmlentities(stripcslashes($_POST['about']), ENT_QUOTES, 'UTF-8'));
			}
			
            
            if ((!isset($_POST['merchantCode'])) || (!$_POST['merchantCode'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$merchantCode = filter_var($_POST['merchantCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$merchantCode = $cipher->encrypt(htmlentities(stripcslashes($_POST['merchantCode']), ENT_QUOTES, 'UTF-8'));
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_profile_info");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&company=".urlencode($company)."&fname1=".urlencode($fname1)."&mname1=".urlencode($mname1)."&lname1=".urlencode($lname1)."&fname2=".urlencode($fname2)."&mname2=".urlencode($mname2)."&lname2=".urlencode($lname2)."&landline1=".urlencode($landline1)."&landline2=".urlencode($landline2)."&mobile1=".urlencode($mobile1)."&mobile2=".urlencode($mobile2)."&fax1=".urlencode($fax1)."&fax2=".urlencode($fax2)."&email=".urlencode($email)."&address=".urlencode($address)."&website=".urlencode($website)."&about=".urlencode($about)."&merchantCode=".urlencode($merchantCode);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_profile_logo':
			$profilePic = "";

			if ((!isset($_POST['profilePic'])) || (!$_POST['profilePic'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$profilePic = filter_var($_POST['profilePic'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
				$profilePic = $cipher->encrypt($profilePic);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_profile_logo");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&profilePic=".urlencode($profilePic);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_profile_loyalty':
			$merchantCode = "";
			$baseValue = "";
			$basePoint = "";
			$regPoint = "";
			$raffleValue = "";
			$raffleEntry = "";
			$raffleStatus = "";
			$nonCash_status = "";
			$nonCash_key = "";
			$baseValue_nonCash = "";
			$basePoint_nonCash = "";

			if ((!isset($_POST['merchantCode'])) || ($_POST['merchantCode'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				// $merchantCode = filter_var($_POST['merchantCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$merchantCode = $cipher->encrypt($_POST['merchantCode']);
			}

			if ((!isset($_POST['baseValue'])) || ($_POST['baseValue'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$baseValue = filter_var($_POST['baseValue'], FILTER_SANITIZE_NUMBER_INT);
				$baseValue = $cipher->encrypt($baseValue);
			}

			if ((!isset($_POST['basePoint'])) || ($_POST['basePoint'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$basePoint = filter_var($_POST['basePoint'], FILTER_SANITIZE_NUMBER_INT);
				$basePoint = $cipher->encrypt($basePoint);
			}

			if ((!isset($_POST['regPoint'])) || ($_POST['regPoint'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				$regPoint = filter_var($_POST['regPoint'], FILTER_SANITIZE_NUMBER_INT);
				$regPoint = $cipher->encrypt($regPoint);
			}

			if ((!isset($_POST['raffleValue'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request raffleValue.")));
				return;
				die();
			} else {
				$raffleValue = filter_var($_POST['raffleValue'], FILTER_SANITIZE_NUMBER_INT);
				$raffleValue = $cipher->encrypt($raffleValue);
			}

			if ((!isset($_POST['raffleEntry'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request raffleEntry.")));
				return;
				die();
			} else {
				$raffleEntry = filter_var($_POST['raffleEntry'], FILTER_SANITIZE_NUMBER_INT);
				$raffleEntry = $cipher->encrypt($raffleEntry);
			}

			if ((!isset($_POST['raffleStatus'])) || ($_POST['raffleStatus'] == NULL)) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['raffleStatus'] != 'active') && ($_POST['raffleStatus'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$raffleStatus = filter_var($_POST['raffleStatus'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$raffleStatus = $cipher->encrypt($raffleStatus);
			}

			if ((!isset($_POST['nonCash_status'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
				return;
				die();
			} else {
				if (($_POST['nonCash_status'] != 'active') && ($_POST['nonCash_status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.")));
					return;
					die();
				}

				$nonCash_status = filter_var($_POST['nonCash_status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$nonCash_status = $cipher->encrypt($nonCash_status);
			}

			if ((!isset($_POST['nonCash_key'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request nonCash_key.")));
				return;
				die();
			} else {
				$nonCash_key = filter_var($_POST['nonCash_key'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$nonCash_key = $cipher->encrypt($nonCash_key);
			}

			if ((!isset($_POST['baseValue_nonCash'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request baseValue_nonCash.")));
				return;
				die();
			} else {
				$baseValue_nonCash = filter_var($_POST['baseValue_nonCash'], FILTER_SANITIZE_NUMBER_INT);
				$baseValue_nonCash = $cipher->encrypt($baseValue_nonCash);
			}

			if ((!isset($_POST['basePoint_nonCash'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request basePoint_nonCash.")));
				return;
				die();
			} else {
				$basePoint_nonCash = filter_var($_POST['basePoint_nonCash'], FILTER_SANITIZE_NUMBER_INT);
				$basePoint_nonCash = $cipher->encrypt($basePoint_nonCash);
			}
			
			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_profile_loyalty");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&merchantCode=".urlencode($merchantCode)."&baseValue=".urlencode($baseValue)."&basePoint=".urlencode($basePoint)."&regPoint=".urlencode($regPoint)."&raffleValue=".urlencode($raffleValue)."&raffleEntry=".urlencode($raffleEntry)."&raffleStatus=".urlencode($raffleStatus)."&nonCash_status=".urlencode($nonCash_status)."&nonCash_key=".urlencode($nonCash_key)."&baseValue_nonCash=".urlencode($baseValue_nonCash)."&basePoint_nonCash=".urlencode($basePoint_nonCash);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_sku':

			$name = "";
			$skuCode = "";
			$price = "";
			$promoType = "";
			$points = "";
			$description = "";
			$status = "";

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.1 ")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['skuCode'])) || (!$_POST['skuCode'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 2")));
				return;
				die();
			} else {
				$skuCode = filter_var($_POST['skuCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$skuCode = $cipher->encrypt($skuCode);
			}


			if ((!isset($_POST['price'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 3")));
				return;
				die();
			} else {
				$price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
				$price = $cipher->encrypt($price);
			}

			if ((!isset($_POST['promoType'])) || (!$_POST['promoType'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 4")));
				return;
				die();
			} else {
				$promoType = filter_var($_POST['promoType'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$promoType = $cipher->encrypt($promoType);
			}
			
			if ((!isset($_POST['points'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 5")));
				return;
				die();
			} else {
				$points = filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_INT);
				$points = $cipher->encrypt($points);
			}
			
			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 6")));
				return;
				die();
			} else {
				$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt($description);
			}
			
			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 7")));
				return;
				die();
			} else {

				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 8")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}


			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_sku");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&name=".urlencode($name)."&skuCode=".urlencode($skuCode)."&price=".urlencode($price)."&promoType=".urlencode($promoType)."&points=".urlencode($points)."&description=".urlencode($description)."&status=".urlencode($status);

			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_sku' :
			$skuID = "";

			if ((!isset($_POST['skuID'])) || (!$_POST['skuID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request 0.")));
				return;
				die();
			} else {
				$skuID = filter_var($_POST['skuID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$skuID = $cipher->encrypt($skuID);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_sku");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&skuID=".urlencode($skuID);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_sku':
			$skuID = "";
			$skuCode = "";
			$name = "";
			$price = "";
			$points = "";
			$description = "";
			$status = "";

			if ((!isset($_POST['skuID'])) || (!$_POST['skuID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. ")));
				return;
				die();
			} else {
				$skuID = filter_var($_POST['skuID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$skuID = $cipher->encrypt($skuID);
			}

			if ((!isset($_POST['name'])) || (!$_POST['name'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 3")));
				return;
				die();
			} else {
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$name = $cipher->encrypt($name);
			}

			if ((!isset($_POST['skuCode'])) || (!$_POST['skuCode'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 2")));
				return;
				die();
			} else {
				$skuCode = filter_var($_POST['skuCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$skuCode = $cipher->encrypt($skuCode);
			}

			if ((!isset($_POST['price']))) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 4")));
				return;
				die();
			} else {
				$price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
				$price = $cipher->encrypt($price);
			}

			if ((!isset($_POST['points'])) ) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 5")));
				return;
				die();
			} else {
				$points = filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_INT);
				$points = $cipher->encrypt($points);
			}

			if ((!isset($_POST['description'])) || (!$_POST['description'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 6")));
				return;
				die();
			} else {
				// $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$description = $cipher->encrypt(htmlentities(stripcslashes($_POST['description']), ENT_QUOTES, 'UTF-8'));
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 7")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 8")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_sku");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&skuID=".urlencode($skuID)."&name=".urlencode($name)."&skuCode=".urlencode($skuCode)."&price=".urlencode($price)."&points=".urlencode($points)."&description=".urlencode($description)."&status=".urlencode($status);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'add_tablet':

			$locID = "";
			$status = "";

			if ((!isset($_POST['locID'])) || (!$_POST['locID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request.1 ")));
				return;
				die();
			} else {
				$locID = filter_var($_POST['locID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$locID = $cipher->encrypt($locID);
			}
			
			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 7")));
				return;
				die();
			} else {

				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 8")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}


			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("add_tablet");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&locID=".urlencode($locID)."&status=".urlencode($status);

			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'delete_tablet' :
			$deviceCode = "";

			if ((!isset($_POST['deviceCode'])) || (!$_POST['deviceCode'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request 0.")));
				return;
				die();
			} else {
				$deviceCode = filter_var($_POST['deviceCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$deviceCode = $cipher->encrypt($deviceCode);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("delete_tablet");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&deviceCode=".urlencode($deviceCode);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'update_tablet':
			$deviceCode = "";
			$locID = "";
			$status = "";
			$deploy = "";

			if ((!isset($_POST['deviceCode'])) || (!$_POST['deviceCode'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. ")));
				return;
				die();
			} else {
				$deviceCode = filter_var($_POST['deviceCode'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$deviceCode = $cipher->encrypt($deviceCode);
			}

			if ((!isset($_POST['locID'])) || (!$_POST['locID'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 3")));
				return;
				die();
			} else {
				$locID = filter_var($_POST['locID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$locID = $cipher->encrypt($locID);
			}

			if ((!isset($_POST['status'])) || (!$_POST['status'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 7")));
				return;
				die();
			} else {
				if (($_POST['status'] != 'active') && ($_POST['status'] != 'inactive')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 8")));
					return;
					die();
				}

				$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$status = $cipher->encrypt($status);
			}

			if ((!isset($_POST['deploy'])) || (!$_POST['deploy'])) {
				echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 7")));
				return;
				die();
			} else {
				if (($_POST['deploy'] != 'true') && ($_POST['deploy'] != 'false')) {
					echo json_encode(array(array("response"=>"Error", "errorCode"=>"400", "description"=>"Bad Request. 8")));
					return;
					die();
				}

				$deploy = filter_var($_POST['deploy'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$deploy = $cipher->encrypt($deploy);
			}

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("update_tablet");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id)."&deviceCode=".urlencode($deviceCode)."&locID=".urlencode($locID)."&status=".urlencode($status)."&deploy=".urlencode($deploy);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		case 'card_series':

			session_start();
			$accountID = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$my_session_id = filter_var($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

			$accountID = $cipher->encrypt($accountID);
			$my_session_id = $cipher->encrypt($my_session_id);

			$function = $cipher->encrypt("card_series");
			$params = "oauth=".urlencode($key)."&token=".urlencode($iv)."&accountID=".urlencode($accountID)."&my_session_id=".urlencode($my_session_id);
			$url = $path."?function=".urlencode($function);
			$cURL = curl_init();
			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_POST, 1);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $params);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($cURL);
			curl_close ($cURL);
			echo $server_output;
			break;

		default:
			# code...
			break;
	}

	/********** Randomizer **********/
	function randomizer($len, $norepeat = true) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $max = strlen($chars) - 1;

	    if ($norepeat && $len > $max + 1) {
	        throw new Exception("Non repetitive random string can't be longer than charset");
	    }

	    $rand_chars = array();

	    while ($len) {
	        $picked = $chars[mt_rand(0, $max)];

	        if ($norepeat) {
	            if (!array_key_exists($picked, $rand_chars)) {
	                $rand_chars[$picked] = true;
	                $len--;
	            }
	        }
	        else {
	            $rand_chars[] = $picked;
	            $len--;
	        }
	    }

	    return implode('', $norepeat ? array_keys($rand_chars) : $rand_chars);   
	}

	/********** Validate E-Mail Address **********/
	function validate_email($email) {
		$isValid = true;

        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            $isValid = false;
        }

        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        if (count($email_array) < 2) {
        	$isValid = false;
        	return $isValid;
        }

        $local_array = explode(".", $email_array[0]);

        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                $isValid = false;
            }
        }

        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                $isValid = false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    $isValid = false;
                }
            }
        }

	   	return $isValid;
	}

?>