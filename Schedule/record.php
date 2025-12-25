<?php
session_start();
if(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Γραμματεια'){
require '../redirectHTTPS.php';
require_once('../connectDB.php');
include ('../header.php'); 
include ('../footer.php'); 
$printrooms = <<< EOF
<html>
<body>
<header class="header">
                 $head
				 $redirect
	</header>
$menu
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	
<div style="overflow-x:auto;">
<form>
Επιλέξτε έτος:
    <select name="Room"  id="load">
        <option value="" disabled selected>--Επιλέξτε--</option>
EOF;
echo $printrooms; 
$sql="SELECT ID,name FROM schedules order by name";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
  $id=$row->ID;
  $name=$row->name;
$printrooms = <<< EOF
		  <option value="$id.1">$name Εαρινό</option>
      <option value="$id.2">$name Χειμερινό</option>
EOF;
echo $printrooms;
}
$printrooms = <<< EOF
</select>
<div id="show_table"></div>
</form>
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
                url:"load_calendar.php",  
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
echo $printrooms ;
}else{
	echo "<script>window.location='../login.php'</script>";
}
?>