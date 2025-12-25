<?php
function sent_email($name,$last_name,$email,$pass){
$to= $email;
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$subject = 'Καλώς ήρθετε στο iRoom.';
$message='
<html>
<head>
<title>
iRoom
</title>
</head>
<body>
<img src="../img/email_logo.png"><br>
Τα στοιχεία σας είναι:<br>
Username: '.$email .' <br>
Κωδικός: ' .$pass.'
<br>
<br>
Ο κωδικός έχει δημιουργηθεί από το σύστημα iRoom και πρέπει να τον αλλάξετε κατά την πρώτη είσοδο σας στο σύστημα.
</body>
</html>';

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=utf-8';

$headers[] = 'From: noreply@email.vlsi.gr'; 

// mail($to, $subject, $message, $headers);


if(@mail($to, $subject, $message, implode("\r\n", $headers))){
$_SESSION['email']=1;  
}else{
$_SESSION['email']=0; 
}

}
?>
