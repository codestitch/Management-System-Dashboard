<?php

	/********** PHP INIT **********/
	header('Access-Control-Allow-Origin: *');
	header('Cache-Control: no-cache');	
	set_time_limit(0);
	ini_set('memory_limit', '-1');
	ini_set('mysql.mysqliect_timeout','0');
	ini_set('max_execution_time', '0');
	ini_set('date.timezone', 'Asia/Manila');

	/********** E-Mailer **********/
	require_once('PHPMailerAutoload.php');
	require("class.smtp.php");
	require_once("class.phpmailer.php");
	include_once('config.php');

	class phpmailerAppException extends phpmailerException {}

	
	mass_failed_registration_sender();

	function send_mail($receiver, $recipient_name, $subject, $message) {
		$sender = MAILER_SENDER;
		$fromName = MAILER_FROM_NAME;		
		$return = false;
		$mail = new PHPMailer(true);
		$mail->CharSet = 'utf-8';
		$smtp = MAILER_SMTP;
		$port = MAILER_PORT;
		$un = MAILER_ACCOUNT_USERNAME;
		$pw = MAILER_ACCOUNT_PASSWORD;
		$bouncemail = MAILER_BOUNCE;

		//Class was here a while ago....

		try {
			$to = $receiver;

			if(!PHPMailer::validateAddress($to)) {
			  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
			}

			$mail->isSMTP();
			//$mail-SMTPDebug 0 = Disabled || 1 = Client Messages || 2 = Client and server messages
			$mail->SMTPDebug  = 2;
			$mail->Host       = $smtp;
			$mail->Port       = $port;
			$mail->SMTPSecure = "none"; // "ssl";
			$mail->SMTPAuth   = true;
			$mail->Username   = $un;
			$mail->Password   = $pw;
			$mail->addReplyTo($sender, $fromName);
			$mail->From       = $sender;
			$mail->FromName   = $fromName;
			$mail->addAddress($receiver, $recipient_name);
			//$mail->admysqlixnC("support@appsolutely.ph");
			$mail->Subject  = $subject;
			$body = $message;
			
			$mail->WordWrap = 80;
			$mail->msgHTML($body, dirname(__FILE__), true); //Create message bodies and embed images
			//$mail->addAttachment('images/phpmailer_mini.gif','phpmailer_mini.gif');  // optional name
			//$mail->addAttachment('images/phpmailer.png', 'phpmailer.png');  // optional name

			$mail->addCustomHeader("MIME-Version", "1.0");
			$mail->addCustomHeader("Organization" , $recipient_name); 
			$mail->addCustomHeader("Content-Transfer-encoding" , "8bit");
			$mail->addCustomHeader("Message-ID" , "<".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>");
			$mail->addCustomHeader("X-MSmail-Priority" , "High");
			$mail->addCustomHeader("X-Mailer" , "PHPMailer 5.1 (phpmailer.sourceforge.net)");
			$mail->addCustomHeader("X-MimeOLE" , "5.1 (phpmailer.sourceforge.net)");
			$mail->addCustomHeader("X-Sender" , $mail->Sender);
			$mail->addCustomHeader("X-AntiAbuse" , "This is a solicited email for - ".$recipient_name." mailing list.");
			$mail->addCustomHeader("X-AntiAbuse" , "Servername - {$_SERVER['SERVER_NAME']}");
			$mail->addCustomHeader("X-AntiAbuse" , $mail->Sender);
								 
			try {
			  // $mail->IsQmail();
			  $mail->send();
			  $results_messages[] = "Success";
			}
			catch (phpmailerException $e) {
			  throw new phpmailerAppException('Error: (Message Failed to Email: ' . $to . ') '.$e->getMessage());
			}
		}
		catch (phpmailerAppException $e) {
		  $results_messages[] = $e->errorMessage();
		}

		if (count($results_messages) > 0) {
			foreach ($results_messages as $result) {
				if ($result != "Success") {
					return "Failed";
				} elseif ($result == "Success") {
					return "Success";
				}
			}
		}
	}

	/********** Resend Registration Email **********/
	function resend_reg_email($email, $mysqli) {
		$path = PATH."api.php?category=services&function=activation";
		$memberID = check_email($email, $mysqli);
		$fname = NULL;
		$mname = NULL;
		$lname = NULL;
		$password = NULL;
		$activation = NULL;
		$recipient_name = "";

		if ($memberID == 'False') {
			return json_encode(array(array("error"=>"Account does not exist.")));
		}

		$sql = $mysqli->query("SELECT `fname`, `mname`, `lname`, `password`, `activation` FROM `memberstable` WHERE BINARY `email` = '$email' AND BINARY `memberID` = '$memberID' LIMIT 1") or die('Failed: ('.$mysqli->errno.') '.$mysqli->error);

		if ($sql) {
			if (($sql->num_rows) > 0) {
				$row = $sql->fetch_assoc();
				$fname = $row['fname'];
				$mname = $row['mname'];
				$lname = $row['lname'];
				$password = $row['password'];
				$activation = $row['activation'];

				if (!$fname && !$mname && !$lname) {
					$recipient_name = "Registered Client";
				} else {
					$recipient_name = $fname." ".$mname." ".$lname;					
				}

				$subject = 'SEAFOOD ISLAND APP Account Confirmation';
				$message = '<center><img src="'.PATH.'seafood/assets/images/logo.png" width="300px" height="150px"></center>';
				$message .= '<p style="font-family: Tahoma !important;">Hi, '.$recipient_name.'</p>';
				$message .= '<p style="font-family: Tahoma !important;">Thank you for downloading the '. MERCHANT .' Mobile App! Your username and temporary password is:</p>';
				$message .= '<p style="font-family: Tahoma !important;">Username: <b>'.$email.'</b></p>';
				$message .= '<p style="font-family: Tahoma !important;">Password: <b>'.$password.'</b></p>';
				$message .= '<p style="font-family: Tahoma !important;">Activate your account by clicking on the link: <a href="'.PATH.'seafood/activation.php?email='.$email.'&activation='.$activation.'" style="background:#000; color:#fff; text-decoration:none;">Activate</a></p>';
				$message .= '<p style="font-family: Tahoma !important;">Please immediately change your password for your protection. You may visit <a href="'.MERCHANT_LINK.'" target="_blank">'.MERCHANT_WEBLABEL.'</a> to change your password.</p>';
				$message .= '<p style="font-family: Tahoma !important;">Use of the '. MERCHANT .' Mobile App signifies acceptance of the terms and conditions available on the downloaded app.</p>';
				$message .= '<br/>';
				$message .= '<p style="font-family: Tahoma !important;">Thank you,</p>';
				$message .= '<p style="font-family: Tahoma !important;">'. MERCHANT .' Family</p>';

				$sent = send_mail($email, $recipient_name, $subject, $message);
				
				if ($sent == "Success") {
					$query = $mysqli->query("UPDATE `memberstable` SET `emailSent` = 'true' WHERE BINARY `email` = '$email' AND BINARY `memberID` = '$memberID'") or die('Failed: ('.$mysqli->errno.') '.$mysqli->error);
					return json_encode(array(array("return"=>"E-mail re-sending successful.")));
				} else {
					$query = $mysqli->query("UPDATE `memberstable` SET `emailSent` = 'false' WHERE BINARY `email` = '$email' AND BINARY `memberID` = '$memberID'") or die('Failed: ('.$mysqli->errno.') '.$mysqli->error);

					return json_encode(array(array("error"=>"E-mail re-sending failed.")));
				}

			} else {
				return json_encode(array(array("error"=>"Account does not exist.")));
			}
		} else {
			return json_encode(array(array("error"=>"Account does not exist.")));
		}
	}

	/********** Mass Resend Failed Registration E-mail **********/
	function mass_failed_registration_sender() {
		/********** Connection **********/
		include_once('../settings/config.php');

		$sql = $mysqli->query("SELECT `email` FROM `memberstable` WHERE BINARY `emailSent` = 'false' AND BINARY `regtype` = 'app'") or die('Failed: ('.$mysqli->errno.') '.$mysqli->error);
		$email_arr = array();
		if ($sql) {
			if (($sql->num_rows) > 0) {
				$counter = 0;
				while ($row = $sql->fetch_assoc()) {
					echo resend_reg_email($row['email'], $mysqli)."<br/>";
					sleep(20);
					$counter += 1;
					if ($counter >= 3) {
						echo "Stop!";
						break;
					}
				}
			} else {
				echo "0 Failed Registration";
			}
		} else {
			echo 'Failed: ('.$mysqli->errno.') '.$mysqli->error;
		}
	}

	/********** Check Email if Existing **********/
	function check_email($email, $mysqli) {
		$return = "False";
		$memberID = null;
		$rs = $mysqli->query("SELECT `memberID` FROM `memberstable` WHERE BINARY `email` = '$email'");
		if ($rs->num_rows > 0) {
			while ($row = $rs->fetch_assoc()) {
				$memberID = $row['memberID'];
			}
			$return = $memberID;
		}
		return $return;
	}

?>