<?php 

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['contactName'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['contactEmail'] = "Please enter a valid email address.";
	}
	// Check subject
	if (strlen($subject) < 2) {
		$error['contactSubject'] = "Please enter your name.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['contactMessage'] = "Please enter your message. It should have at least 15 characters.";
	}

	//Email content
	if (isset($_POST['sendMail'])) {
		require '../PHPMailerAutoload.php';
		require '../credential.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 4;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = EMAIL;                 // SMTP username
		$mail->Password = PASS;                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom($_POST['contactEmail']);
		$mail->addReplyTo($_POST['contactEmail']);
		$mail->addAddress(EMAIL);     // Add a recipient

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = "Enquiry from ". $_POST['contactName'];
		$mail->Body    = $_POST['contactMessage'] . "<hr>" .
						 "<h5>RECRUITER DETAILS - </h5>" .
						 "👤 Name: <b>" . $_POST['contactName'] ."</b>" . 
						 "<br>📧 Email: <b>" . $_POST['contactEmail'] ."</b>" .
						 "<br>📝 Subject: <b>". $_POST['contactSubject'] ."</b>";
		$mail->AltBody = $_POST['contactMessage'];

		if(!$mail->send()) {
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Your message was sent 😁 <br><br> 
		        I will be in touch with you shortly. Have a nice day!';
		}
	}

 ?>