<?php
$to      = 'nelo.coto2@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: nelo.coto@gmail.com' . "\r\n" .
    'Reply-To: nelo.coto@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>