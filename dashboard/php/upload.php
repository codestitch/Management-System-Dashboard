<?php
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('memory_limit', '-1');
	set_time_limit(0);  
	ini_set('max_execution_time', '0');
	
	require_once('../../php/api/settings/config.php');
	
	/********** Session **********/
	if (!isset($_SESSION)) { session_start(); }

	if (!$_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID']) {
		unset($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID']);
		unset($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION']);
		$_SESSION = array();
		session_unset();
		session_destroy();
		echo "Expired";
		die();
	}

	// $url = PATH;

	// $url = str_replace("/", "", PATH);
	$url = str_replace("dashboard", "", PATH);
	// echo "$url: ".$url;
	
	$valid_formats = array("jpg", "png", "gif", "bmp", "JPG", "JPEG", "PNG", "GIF", "BMP");
	$imgName = randomizer(4)."".date("YmdHis")."".randomizer(4);

	switch ($_POST['purpose']) {
		case 'profile':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'product':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/product";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'post':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/post";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'press':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/press";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'promo':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/promo";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'staff':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/staff";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;

		case 'location':
			$file_name = $_POST['file_name'];
			$path = "../../assets/images/location";
			make_dir($path);
			$name = $_FILES[$file_name]['name'];
			$size = $_FILES[$file_name]['size'];
			$tmp  = $_FILES[$file_name]['tmp_name'];
			$type = $_FILES[$file_name]['type'];

			if(!get_magic_quotes_gpc()){
				$name = addslashes($name);
			}

			if(strlen($name)){
				$ext = substr(strrchr($name, "."), 1);
				if(in_array($ext,$valid_formats)){
					if($size<(1024*2048)) {	
						if(move_uploaded_file($tmp, $path.'/'.$imgName.'.'.$ext)) {			
							$imgSrc = $path.'/'.$imgName.'.'.$ext;
							$imgSrc = str_replace("../../", $url, $imgSrc);
							echo $imgSrc;							
						} else {
							echo "Failed";
						}
					} else {
							echo "Exceeds";
					}
				} else {
					echo "Invalid";	
				}
			} else {
				echo "Invalid";
				exit;
			}
			break;
		
		default:
			# code...
			break;
	}

	/********** DIR Creator **********/
	function make_dir($path) {
		if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
	}		

	/********** Randomizer **********/
	function randomizer($length) {
     	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz0123456789';
     	$result="";
     	for ($i = 0; $i < $length; $i++) {
			$result .= $characters[rand(0, strlen($characters) - 1)];
		}
	    return $result;
	}

	/********** Force Logout 
	function session_checker() {
		require_once('../auth/connection.php');
		$return = "Continue";

		if (!isset($_SESSION['CORE_ACCOUNT_ID']) || empty($_SESSION['CORE_ACCOUNT_ID'])) {
			return "Logout";
		}

		$sql = $conn->query("SELECT `multiLogin`, `loginSession` FROM `accounts` WHERE BINARY `accountID` = '".$_SESSION['CORE_ACCOUNT_ID']."'") or customError('Failed: ('.$conn->errno.') '.$conn->error, $log);

		if ($sql) {
			if (($sql->num_rows) > 0) {
				$account = $sql->fetch_assoc();
				if ($account['multiLogin'] == 'false') {
					if ($account['loginSession'] != $_SESSION['CORE_ACCOUNT_SESSION']) {
						$log->writelog("Session expired on accountID: ".$_SESSION['CORE_ACCOUNT_ID'].", role: ".$_SESSION['CORE_ACCOUNT_ROLE']);
						$return = "Logout";
					}
				} else {
					if (!isset($_SESSION['CORE_ACCOUNT_ID']) || empty($_SESSION['CORE_ACCOUNT_ID'])) {
						return "Logout";
					}
				}
			}
		}

		return $return;
	}**********/

	/********** File Checker **********/
	function file_checker($file) {
		if ($file  == null) {
			echo "Empty";
			die();	
		}
	}
?>