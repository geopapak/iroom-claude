<?php
include('session_check.php');
include ('header_includes.php');
include ('menu.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$link = explode('/', $actual_link);
$link1='rooms.php';
$link5='equipment.php';
$link3='edit_room.php';
$link4='edit_equipment.php';
$link6='university.php';
$link7='course.php';
$link8='gramuser.php';
$link9='calendar.php';
$link10='add_edit.php';
$link11='edit.php';
$link12='calendar_profesor.php';
$link13='calendar_room.php';
$link14='calendar_student.php';
$link15='semester.php';
$link16='main_user.php';
$link17='edit_user.php';
$link18='edit_depart.php';
$link19='add_exam.php';
$link20='userstudent.php';
$link21='database.php';
$link22='insert_hours.php';
$link23='period.php';
$link24='typecourse.php';
$link25='edittype.php';
$link26='typeroom.php';
$link27='edittyperoom.php';
$link28='record.php';
$link29='change_password.php';
$link30='kateuthinsi.php';

$link2=end($link);


if(stripos($link2,$link1)!== false or stripos($link2,$link6)!== false  or stripos($link2,$link3)!== false OR  stripos($link2,$link4)!== false or stripos($link2,$link5)!== false or stripos($link2,$link15)!== false or stripos($link2,$link16)!== false OR  stripos($link2,$link17)!== false OR  stripos($link2,$link18)!== false or stripos($link2,$link10)!== false or stripos($link2,$link19)!== false or stripos($link2,$link20)!== false or stripos($link2,$link8)!== false or stripos($link2,$link22)!== false or stripos($link2,$link23)!== false or stripos($link2,$link24)!== false or stripos($link2,$link25)!== false or stripos($link2,$link26)!== false or stripos($link2,$link27)!== false or stripos($link2,$link29)!== false or stripos($link2,$link30)!== false){
$head=<<<EOF
<html lang="en">
    <head>
        $title
			$head_include
</head>
$logo
</htm>
EOF;
	
}elseif(stripos($link2,$link9)!== false  OR  stripos($link2,$link11 )!== false OR  stripos($link2,$link28)!== false) {
$head=<<<EOF
<html lang="en">
    <head>
	$title
  $program
</head>
<a href="index.php" id="logo"></a>
	<nav>
		<a href="#" id="menu-icon"></a>
		<div>Καλώς ήρθατε $_SESSION[name] $_SESSION[lname]</div>	
			<li class="dropdown" >
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <i class="fas fa-bell"></i></a>
					<ul class="dropdown-menu scrollable-menu"  role="menu" style="right:-120px !important; left:-240px !important; word-break: break-all;"></ul>
				</li>
				<li><a href="../logout.php">Αποσύνδεση</a></li>
			
		</nav>
</htm>
EOF;
}elseif(stripos($link2,$link12)!== false  OR  stripos($link2,$link13)!== false OR  stripos($link2,$link14)!== false ){
	if ( isset($_SESSION["valuepid"]) ){
	include_once('CAS.php');	
	include_once('cas_config.php');
	phpCAS::client($cas_protocol, $cas_sso_server, $cas_port, '');
	phpCAS::setCasServerCACert($cas_cert); 	
	phpCAS::handleLogoutRequests(true , array($cas_sso_server));
	phpCAS::forceAuthentication();
	if (isset($_REQUEST['logout'])) {
		phpCAS::logout(array("service"=>$cas_logout_app_redirect_url));
	}
$head=<<<EOF
<html lang="en">
    <head>
$title
		$head_celandar
</head>
<a href="index.php" id="logo"></a>
	<nav>
		<a href="#" id="menu-icon"></a>
			<ul>
			<div>Καλώς ήρθατε $_SESSION[name] $_SESSION[lname]</div>	
				<li><a href="?logout=">Αποσύνδεση</a></li>
			</ul>
		</nav>
</htm>
EOF;
	}else{
$head=<<<EOF
<html lang="en">
    <head>
$title
$head_celandar
</head>
$logo
</htm>
EOF;
	}
}elseif(stripos($link2,$link21)!== false ){
$head=<<<EOF
<html lang="en">
    <head>
$title
		$head_include
</head>
$logo
</htm>
EOF;
}elseif(stripos($link2,$link7)!== false ){
$head=<<<EOF
<html lang="en">
    <head>
$title
		$head_include
		<script type="text/javascript" src="../js/scripts.js"></script>  
</head>
$logo
</htm>
EOF;
}else{
$head = <<< EOF
<html>
<head>
$title
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<link href="css/index_css.css" rel="stylesheet" />
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="screen">	  
	<script src="js/bootstrap.min.js" rel="stylesheet" /></script>	
   $redirect
</head>

       
   <a href="index.php" id="logo"></a>
	<nav>
		<a href="#" id="menu-icon"></a>
			<ul>
				<li><a href="login_cas.php">Σύνδεση cas</a></li>
				<li><a href="login.php">Σύνδεση</a></li>
			</ul>
		</nav>

</html>
EOF;
}
?>
