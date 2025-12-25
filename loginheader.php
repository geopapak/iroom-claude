<?php
include 'errorReporting.php';
//include('session_check.php');

$loginhead = <<< EOF
<html>
<head>
<meta charset="UTF-8">
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
	<link rel="stylesheet" href="css/login_css.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
   <a href="index.php" id="logo"></a>
	<nav>
		<a href="#" id="menu-icon"></a>
			<ul>
				<li><a href="index.php" class="current">Αρχική</a></li>
				
			</ul>
		</nav>

</html>
EOF;
?>