<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	// Checks whether the HTTP request is a form submission or not

	if (empty($_POST['name'])) {
		$nameError = 'Name is empty';
	} else {
		$name = $_POST['name'];
	}

	if (empty($_POST['email'])) {
		$emailError = 'Email is empty';
	} else {
		$email = $_POST['email'];
		// Validates the email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailError = 'Invalid email';
		}
	}

	if (empty($_POST['subject'])) {
		$subjectError = 'Subject is empty';
	} else {
		$subject = $_POST['subject'];
	}

	if (empty($_POST['message'])) {
		$messageError = 'Message is empty';
	} else {
		$message = $_POST['message'];
	}

	if (empty($nameError) && empty($emailError) && empty($subjectError) && empty($messageError)) {
		$date = date('j, F Y h:i A');
		// This generates the current date
		$emailBody = "
			<html>
			<head>
				<title>$email is contacting you</title>
			</head>
			<body style=\"background-color:#fafafa;\">
				<div style=\"padding:20px;\">
					Date: <span style=\"color:#888\">$date</span>
					<br>
					Name: <span style=\"color:#888\">$name</span>
					<br>
					Email: <span style=\"color:#888\">$email</span>
					<br>
					Subject: <span style=\"color:#888\">$subject</span>
					<br>
					Message: <div style=\"color:#888\">$message</div>
				</div>
			</body>
			</html>
		";

		$headers = 	'From: Portfolio Contact Form <lavon.tech@outlook.com>' . "\r\n" .
			"Reply-To: $email" . "\r\n" .
			"MIME-Version: 1.0\r\n" .
			"Content-Type: text/html; charset=iso-8859-1\r\n";

		$to = 'lavon.tech@outlook.com';
		$subject = 'Contacting you';

		if (mail($to, $subject, $emailBody, $headers)) {
			$sent = true;
		}
	}
}
?>

<?php if (isset($emailError) || isset($messageError)) : ?>
	<div id="error-message">
		<?php
		echo isset($emailError) ? $emailError . '<br>' : '';
		echo isset($messageError) ? $messageError . '<br>' : '';
		?>
	</div>
<?php endif; ?>


<?php if (isset($sent) && $sent === true) : ?>
	<div id="done-message">
		Your data was succesfully submitted
	</div>
<?php endif; ?>