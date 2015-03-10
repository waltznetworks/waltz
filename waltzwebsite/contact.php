<?php
$field_name = $_POST['name'];
$field_email = $_POST['email'];
$field_message = $_POST['registrationMessage'];

$mail_to = 'contact@waltznetworks.com';

$body_message = 'Name: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message."\n";

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

if ($mail_status) {
  header('Location: /#contact');
} else {
?>
	<type="text/javascript">
		We are sorry! There appears to be a problem. Please, send your message directly to contact@waltznetworks.com
	</script>
<?php
}
?>
