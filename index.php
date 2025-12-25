<?php

require 'redirectHTTPS.php';
require 'connectDB.php';
include 'errorReporting.php';
//include 'header.php';
include 'footer.php';

$sql = "SELECT * FROM departament";
$sth = $dbh->prepare($sql, array());
$result = $sth -> execute();
$nr = $sth->rowCount();

$indexHTML =  <<< EOF

<html lang="en">
  
  <body>
     <header>
                 <head>
        <title>iRooms</title>
                    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
                    <link href="css/index_css.css" rel="stylesheet" />
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="screen">    
  <script src="js/bootstrap.min.js" rel="stylesheet" /></script>  
  <link rel="stylesheet" href="css/media.css" type="text/css" media="print" />
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
  </header>
  <div id="show_table" style="padding-top: 4%;">
    <div class="center-on-page">   
      <h1>Επιλογή Προγράμματος Σπουδών:</h1>
<form>      
        <div class="select">
            <select name="Room" id="load">
              <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $indexHTML;
while ($row = $sth->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$id=$row->ID;
$indexHTML = <<< EOF
                <option value="$id">$name</option>
EOF;
echo $indexHTML;  
}
$indexHTML = <<< EOF
            </select> 
</form>          
       </div>
      <h1>Επιλογή Προγράμματος Εξεταστικής:</h1>
<form>      
        <div class="select">
            <select name="Room" id="load_exam">
              <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $indexHTML;
$sql = "SELECT * FROM departament";
$sth = $dbh->prepare($sql, array());
$result = $sth -> execute();
while ($row = $sth->fetch(PDO::FETCH_OBJ)){
$name = $row -> name;
$id=$row->ID;
$indexHTML = <<< EOF
                <option value="$id">$name</option>
EOF;
echo $indexHTML;  
}
$indexHTML = <<< EOF
            </select> 
</form>          
       </div>       
    </div>
    </div>    
  <footer>
        $footer
    </footer>
<script>
 $(document).ready(function(){  
      $('#load').change(function(){  
           var id = $(this).val();  
           $.ajax({  
                url:"load_sch.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                     $('#show_table').html(data);  
                }  
           });  
      });  
 }); 
  $(document).ready(function(){  
      $('#load_exam').change(function(){  
           var id = $(this).val();  
           $.ajax({  
                url:"load_sch_exam.php",  
                method:"POST",  
                data:{id:id},  
                success:function(data){  
                     $('#show_table').html(data);  
                }  
           });  
      });  
 }); 
 </script>
  </body>
</html>
EOF;
echo $indexHTML;
?>