<?php

// Put contacting email here
$php_main_email = "admin@masfarre.com";

//Fetching Values from URL
$php_name = $_POST['fullname'];
$php_email = $_POST['email'];
$php_phone = $_POST['phone'];
$php_eventdate = $_POST['eventdate'];
$php_eventtype = $_POST['eventtype'];
$php_eventplace = $_POST['eventplace'];
$php_message = $_POST['message'];

//Sanitizing email
$php_email = filter_var($php_email, FILTER_SANITIZE_EMAIL);
$php_name = filter_var($php_name, FILTER_SANITIZE_STRING);
$php_phone = filter_var($php_phone, FILTER_SANITIZE_STRING);
$php_eventdate = filter_var($php_eventdate, FILTER_SANITIZE_STRING);
$php_eventtype = filter_var($php_eventtype, FILTER_SANITIZE_STRING);
$php_eventplace = filter_var($php_eventplace, FILTER_SANITIZE_STRING);
$php_message = filter_var($php_message, FILTER_SANITIZE_STRING);


//After sanitization Validation is performed
if (filter_var($php_email, FILTER_VALIDATE_EMAIL)) {
	
		$php_subject = "Mensaje enviado desde el formulario de contacto de la web";
		
		// To send HTML mail, the Content-type header must be set
		$php_headers = 'MIME-Version: 1.0' . "\r\n";
		$php_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$php_headers .= 'From:' . $php_email. "\r\n"; // Sender's Email
		$php_headers .= 'Cc:' . $php_email. "\r\n"; // Carbon copy to Sender
		
		$php_template = '<div style="padding:50px;">Hola ' . $php_name . ',<br/>'
		. 'Gracias por contactarnos. Nos ponemos en contacto con usted lo antes posible.<br/><br/>'
		. '<strong style="color:#f00a77;">Nombre:</strong>  ' . $php_name . '<br/>'
		. '<strong style="color:#f00a77;">Email:</strong>  ' . $php_email . '<br/>'
		. '<strong style="color:#f00a77;">Telefono:</strong>  ' . $php_phone . '<br/>'
		. '<strong style="color:#f00a77;">Fecha del evento:</strong>  ' . $php_eventdate . '<br/>'
		. '<strong style="color:#f00a77;">Tipo de evento:</strong>  ' . $php_eventtype . '<br/>'
		. '<strong style="color:#f00a77;">Lugar del evento:</strong>  ' . $php_eventplace . '<br/>'
		. '<strong style="color:#f00a77;">Mensaje:</strong>  ' . $php_message . '<br/><br/>'
		. 'This is a Contact Confirmation mail.'
		. '<br/>'
		. 'We will contact you as soon as possible .</div>';
		$php_sendmessage = "<div style=\"background-color:#f5f5f5; color:#333;\">" . $php_template . "</div>";
		
		// message lines should not exceed 70 characters (PHP rule), so wrap it
		$php_sendmessage = wordwrap($php_sendmessage, 70);
		
		// Send mail by PHP Mail Function
		if(
		mail($php_main_email, $php_subject, $php_sendmessage, $php_headers)
		)
		{
			// Redirecting to success page
			echo "<span class='contact_success'>* Your message has been sent successfully. We will contact you as soon as possible. *</span>";
		} else {
			echo "<span class='contact_error'>* Error while sending message *</span>";
		}
		echo "<script>setTimeout(\"location.href = 'index.html';\",2000);</script>";
	
} else {
	echo "<span class='contact_error'>* Invalid email *</span>";
}

?>