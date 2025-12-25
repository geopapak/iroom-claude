<?php
$title=<<<eof
        <title>iRooms</title>
eof;
$head_include=<<<EOF
	 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
		<script src="../js/bootstrap.min.js" rel="stylesheet" /></script>
		<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="screen">		
		<link rel="stylesheet" href="../css/media.css" type="text/css" media="print" />
		<link href="../css/body_css.css" rel="stylesheet" />
		<link href="../css/sidebar.css" rel="stylesheet" />
		<link href="../css/myTable.css" rel="stylesheet" />
		<script src="../js/sidebar.js" rel="stylesheet" /></script>
		<script src="../js/search.js" rel="stylesheet" /></script>
		<script src="../js/debug.js" rel="stylesheet" /></script>
		<script src="../js/print.js" rel="stylesheet" /></script>
		<link href="../css/alert_message.css" rel="stylesheet" type="text/css" media="screen">
EOF;

$head_celandar=<<<EOF
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href="../css/alert_message.css" rel="stylesheet" type="text/css" media="screen">
		<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
		<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="screen">
		<link rel="stylesheet" href="../css/media.css" type="text/css" media="print" />
		<link href="../css/body_css.css" rel="stylesheet" />
		<link href="../css/sidebar.css" rel="stylesheet" />
		<link href="../css/myTable.css" rel="stylesheet" />
		<script src="../js/bootstrap.min.js" rel="stylesheet" /></script>
		<script src="../js/sidebar.js" rel="stylesheet" /></script>
		<script src="../js/search.js" rel="stylesheet" /></script>
		<script src="../js/debug.js" rel="stylesheet" /></script>
		<script src="../js/javascript_pass.js" rel="stylesheet" /></script>
		<script src="../js/print.js" rel="stylesheet" /></script>  
		<style>
		.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
}
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
EOF;

$logo=<<<EOF
<a href="index.php" id="logo"></a>
	<nav>
		<a href="#" id="menu-icon"></a>
			<ul>
				<div>Καλώς ήρθατε $_SESSION[name] $_SESSION[lname]</div>	
				<li><a href="../logout.php">Αποσύνδεση</a></li>
			</ul>
		</nav>
EOF;

$program=<<<eof
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link href="../css/body_css.css" rel="stylesheet" />
		<link href="../css/sidebar.css" rel="stylesheet" />
		<link href="../css/alert_message.css" rel="stylesheet" />
		<link href="../css/myTable.css" rel="stylesheet" />
		<!--<script src="../js/bootstrap.min.js" rel="stylesheet" /></script>-->
		<script src="../js/sidebar.js" rel="stylesheet" /></script>
		<script src="../js/search.js" rel="stylesheet" /></script>
		<script src="../js/notification.js" rel="stylesheet" /></script>
		<link rel="stylesheet" href="../css/media.css" type="text/css" media="print" />
		<script src="../js/print.js" rel="stylesheet" /></script>  

<style>
.scrollable-menu {
    height: auto;
    max-height: 500px;
    overflow-x: hidden;
}
</style>
eof;
?>
