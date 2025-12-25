<?php
session_start();
if(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Διαχειριστής'){
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
$sql = "SELECT count(*) FROM days"; 
$result = $dbh->prepare($sql); 
$result->execute(); 
$rows_days = $result->fetchColumn(); 

$sql = "SELECT count(*) FROM hours"; 
$result = $dbh->prepare($sql); 
$result->execute(); 
$rows_hours = $result->fetchColumn(); 

$sql = "SELECT count(*) FROM semester"; 
$result = $dbh->prepare($sql); 
$result->execute(); 
$rows_sem = $result->fetchColumn(); 
$stringHTML = <<< EOF
<html>
<body>
		$menu1
<header>
                 $head
				 $redirect
				 <link rel="stylesheet" type="text/css" href="../css/font-awesome/css/font-awesome.min.css" /> 
	</header>
	 
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	

<div class="container text-center">
    <div class="row">
        <div class="col-lg-12">
            <h2>Δημιούργια Ημερών - Ωρών - Εξαμήνων</h2>
            <p>
EOF;
echo $stringHTML;

if  ($rows_days == 0 ){ 
$stringHTML = <<< EOF
                <a href="days.php" class="btn btn-squared-default btn-success">
                    <i class="fa fa-plus-circle fa-5x"></i>
                    <br />
                    Δημιουργία ημερών.
                    <br />
                    <strong>Δεν έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;
}else {
$stringHTML = <<< EOF
				<a href="#" class="btn btn-squared-default btn-danger">
                    <i class="fa fa-minus-circle fa-5x"></i>
                    <br />
                    Δημιουργία ημερών.
                    <br />
                    <strong>Έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;                
}
if  ($rows_hours == 0 ){ 
$stringHTML = <<< EOF
                <a href="insert_hours.php" class="btn btn-squared-default btn-success">
                    <i class="fa fa-clock-o fa-5x"></i>
                    <br />
                    Δημιουργία ωρών.
                    <br />
                    <strong>Δεν έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;
}else {
$stringHTML = <<< EOF
				<a href="#" class="btn btn-squared-default btn-danger">
                    <i class="fa fa-clock-o fa-5x"></i>
                    <br />
                    Δημιουργία ωρών.
                    <br />
                    <strong>Έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;                
}
if  ($rows_sem == 0 ){ 
$stringHTML = <<< EOF
                <a href="sem.php" class="btn btn-squared-default btn-success">
                    <i class="fa fa-calendar-plus-o fa-5x"></i>
                    <br />
                    Δημιουργία εξαμήνων.
                    <br />
                    <strong>Δεν έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;
}else {
$stringHTML = <<< EOF
                <a href="#" class="btn btn-squared-default btn-danger">
                    <i class="fa fa-calendar-plus-o fa-5x"></i>
                    <br />
                    Δημιουργία εξαμήνων.
                    <br />
                    <strong>Έχουν καταχωρηθεί.</strong>
                </a>
EOF;
echo $stringHTML;                
}
$stringHTML = <<< EOF
            </p>
        </div>
    </div>
</div>

<style>
    .btn-squared-default
    {
        width: 143px !important;
        height: 143px !important;
        font-size: 10px;
    }

        .btn-squared-default:hover
        {
            border: 3px solid white;
            font-weight: 800;
        }

    .btn-squared-default-plain
    {
        width: 100px !important;
        height: 100px !important;
        font-size: 10px;
    }

        .btn-squared-default-plain:hover
        {
            border: 0px solid white;
        }
</style>

<!-- Square Buttons Effects - END -->
</div>				

<footer>
$footer
    </footer>

</body>
</html>

EOF;
echo $stringHTML ;
}else{
    echo "<script>window.location='../login.php'</script>";
}
?>