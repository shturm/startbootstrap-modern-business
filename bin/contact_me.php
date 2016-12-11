<?php
// Check for empty fields
// var_dump($_POST);
header('Content-Type: application/json');


if(empty($_POST['name'])      ||
   empty($_POST['phoneOrEmail'])     ||
   empty($_POST['g-recaptcha-response'])     ||
   empty($_POST['message'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "empty fields", "fields" => $_POST]);
	exit;
   }
   
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret'   => '6LcZBwkUAAAAAOQu3ZGuhKKii-Z0ZqnYZtK1yf0X',
    'response' => $_POST['g-recaptcha-response'],
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data) 
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if(!json_decode($result)->success) {
    echo $result;
    http_response_code(400);
    exit;
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$phoneOrEmail = strip_tags(htmlspecialchars($_POST['phoneOrEmail']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'alex@smetko.bg'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Smetko.bg контактна форма:  $name";
$email_body = "Съобщение от контактната форма на smetko.bg:\n\n"."Име: $name\nОбратна връзка: $phoneOrEmail\nСъобщение:\n$message";
$headers = "From: noreply@smetko.bg\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address\n";
$headers .= "Content-Type: text/plain;charset=utf-8";   
mail($to,$email_subject,$email_body,$headers);

echo $result;

?>
