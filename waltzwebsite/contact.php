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

$curl = curl_init("https://app.waltznetworks.com/register");

$registeration_data = array(
    "name" => $field_name,
    "email" => $field_email,
    "registrationMessage" => $field_message
);

foreach ($registeration_data as $key => $key_value) {
  $query_data[] = urlencode($key) . '=' . urlencode($key_value);
}
$query_data = implode('&', $query_data);

curl_setopt_array($curl, array(
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_USERAGENT      => "www.waltznetworks.com contact.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_POST           => 1,
    CURLOPT_POSTFIELDS     => $query_data,
    CURLOPT_HTTPHEADER     => array('Content-Type: application/x-www-form-urlencoded')
));
curl_exec($curl);
curl_close($curl);

$body_message .= 'POST-Data: ' . $query_data;

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
