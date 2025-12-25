<?php 
session_start();
include ('../header.php'); 
include('../connectDB.php');
include ('../footer.php'); 

$ID=filter_var( $_GET['ID'] , FILTER_SANITIZE_NUMBER_INT);
$editHTML=<<<EOF
<htm>
<body>
<header>
                 $head
				<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>		
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	</header>
EOF;
echo $editHTML;
$sql="SELECT university.ID as iduni,departament.ID as iddep,university.name as uni,departament.name as depart,departament.sso_depart as sso FROM university INNER JOIN departament ON university.ID=departament.ID_university WHERE university.ID= :ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt-> execute();
$table_id=array();
$table_sso=array();
$table_sem=array();
$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_depart.php?ID=$ID"  enctype="multipart/form-data" style="   width: 60%;margin-left: 20%;margin-right: 20%;margin-top: 1%;text-align: center;border-radius: 10%;background: url(../img/index_header.jpg) repeat center;">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Στοιχείων Πανεπιστημίου </h4>
                                <hr>
									<div>
                                    <label>Όνομα Πανεπιστημίου:</label>
EOF;
echo $editHTML;								
$row = $stmt->fetch(PDO::FETCH_OBJ);
$iduni=$row->iduni;
$uni=$row->uni;
$editHTML=<<<EOF

									<input type="text" name="uni" required value="$uni">
								</div>	
								<div>                                    
								<label>Τμήματα:</label>
EOF;
echo $editHTML;
$sql="SELECT university.ID as iduni,departament.ID as iddep,university.name as uni,departament.name as depart,departament.sso_depart as sso FROM university INNER JOIN departament ON university.ID=departament.ID_university WHERE university.ID= :ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt-> execute();
for($i=0; $row1 = $stmt ->fetch(PDO::FETCH_OBJ); $i++){
$iddep=$row1->iddep;
$depart=$row1->depart;
$sso=$row1->sso;
$sql2="SELECT * FROM admin_sem  WHERE ID_department= :ID";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':ID',$iddep,PDO::PARAM_INT);
$stmt2-> execute();
$row2 = $stmt2 ->fetch(PDO::FETCH_OBJ);
$id_sem_admin=$row2->ID;
$id_sem=$row2->ID_sem;
$editHTML=<<<EOF
								<input type="text" name="table_id[$iddep]" required value="$depart"> <input type="text" name="table_sso[$iddep]" required value="$sso"> 
                
EOF;
echo $editHTML;
if($id_sem==1){
$editHTML=<<<EOF
              <select name="table_sem[$iddep]"><option value="1" selected>Χειμερινό</option><option value="2">Εαρινό</option></select><br>

EOF;
echo $editHTML;
}else{
$editHTML=<<<EOF
              <select name="table_sem[$iddep]"><option value="1">Χειμερινό</option><option value="2" selected>Εαρινό</option></select><br>
EOF;
echo $editHTML;              
}
}				
$editHTML=<<<EOF
                                </div>
								 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>
										<a href="university.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>

<footer>
$footer
</footer>
EOF;
echo $editHTML;				
$editHTML=<<<EOF
<script type="text/javascript">
$(document).ready(function(){

 // Delete 
 $('.delete').click (function(){
	 
    var el = this;
   var id = this.id;
   var splitid = id.split(".");
		

   // Delete id
   //var deleteid = id;
	//alert(+id);
 
    // AJAX Request
   $.ajax({
     url: 'remove.php',
     type: 'POST',
     data: { id:id },
     success: function(response){
	//alert(+response);
	console.log(response);
      if(response == 1){
	 // Remove row from HTML Table
	 //$(el).closest('tr').css('background','tomato');
	 $(el).closest('tr').fadeOut(0,function(){
	    $(this).remove();
	 });
      }else{
	 alert('Invalid ID.');
      }

    }
   });  

 });

});
</script>
</body>
</html>
EOF;
echo $editHTML;
?>
								