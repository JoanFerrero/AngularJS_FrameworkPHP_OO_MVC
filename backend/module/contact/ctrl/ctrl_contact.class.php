<?php
	class ctrl_contact {		
		function send_email(){
			$messageAdmin = ['type' => 'admin', 
                            'inputName' => $_POST['name'], 
                            'fromEmail' => $_POST['email'], 
                            'inputSubject' => $_POST['matter'], 
                            'inputMessage' => $_POST['message']];
        	$messageClient = ['type' => 'contact', 
                            'toEmail' => $_POST['email'], 
                            'inputSubject' => '', 
                            'inputMessage' => ''];
			$emailAdmin = json_decode(mail::send_email($messageAdmin), true);
			if ($emailAdmin == 'true') {
				$emailClient = json_decode(mail::setEmail($messageClient), true);
				if ($messageClient == 'true') {
					echo 'true';
					return;
				}// end_if
			}// end_if
			echo 'false';
		}
	}
?>