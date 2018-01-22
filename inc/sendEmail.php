<?php

// Replace this with your own email address
$siteOwnersEmail = 'fipirra@gmail.com';


if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = "Nuevo mensaje de contacto";
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Por favor ingrese su nombre.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Por favor ingrese una dirección válida.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Su mensaje debe tener por lo menos 15 caracteres.";
	}
   // Subject
	if ($subject == '') { $subject = "Mensaje de contacto"; }


   // Set Message
   $message .= "Mensaje de: " . $name . "<br />";
	$message .= "Email: " . $email . "<br />";
   $message .= "Mensaje: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Este mensaje fue enviado desde el formulario de contacto de su página. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Algo salió mal. Por favor, intente de nuevo."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>
