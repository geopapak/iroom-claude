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
$sql="SELECT course.ID,course.name,course.year,course.code,course.optional FROM course inner join course_depart on course.ID=course_depart.ID_course where course.ID=:ID AND course_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt-> execute();
$table_type=array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){	
	$id=$row->ID;
	$name=$row->name;
	$year=$row->year;
	$code=$row->code;
$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_course.php?ID=$id"  enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Στοιχείων Μαθήματος</h4>
                                <hr>
								<div>
                                    <label>Όνομα Μαθήματος:</label>
									<input type="text" name="Name" required value='$name'>
								</div>	
								<div>
                                    <label>Χρονιά διαδασκαλιας μαθήματος:</label>
									<input type="text" name="Year" required value=$year>
								</div>
								<div>
                                    <label>Κωδικός μαθήματος:</label>
									<input type="text" name="Code" required value=$code>
								</div>
								<div>
                                    <label>Όνομα καθηγητή/τριας μαθήματος:</label>
									<select class="select_form" name="IDUser">
EOF;
echo $editHTML;
$sql1="SELECT users.ID as ID_user,name,last_name,user_type FROM users INNER JOIN course_profesor ON course_profesor.ID_profesor=users.ID WHERE course_profesor.ID_course=:id";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':id',$id,PDO::PARAM_INT);
//$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt1-> execute();
$count = $stmt1->rowCount();
if($count>0){
$row1= $stmt1 ->fetch(PDO::FETCH_OBJ);
$id_user= $row1 -> ID_user;
$name_user= $row1 -> name;
$last_name= $row1-> last_name;
$user_type=$row1-> user_type;	
$editHTML=<<<EOF
										<option value="$id_user" selected="selected">$name_user $last_name</option>
EOF;
echo $editHTML;
$sql="SELECT ID,name,last_name FROM users WHERE user_type=:user_type AND ID <> :id_user";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_user',$id_user,PDO::PARAM_STR);
$stmt->bindParam(':user_type',$user_type,PDO::PARAM_STR);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_user=$row->ID;
$name=$row->name;			
$last_name=$row->last_name;
$editHTML= <<<EOF
								<option value="$id_user">$name $last_name</option>
EOF;
echo $editHTML;
}
}else{
$editHTML=<<<EOF
		<option value="">-- Επιλέξτε Καθηγητή --</option>
EOF;
echo $editHTML;	
$user_type='Καθηγητής';
$sql="SELECT ID,name,last_name FROM users WHERE user_type=:user_type";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_type',$user_type,PDO::PARAM_STR);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_user=$row->ID;
$name=$row->name;			
$last_name=$row->last_name;
$editHTML=<<<EOF
		<option value="$id_user">$name $last_name</option>
EOF;
echo $editHTML;		
}
}
$editHTML=<<<EOF
										</select>
									<!--<input type="text" name="Name1" required value=$name_user>-->
								</div>
								<!--<div>
                                    <label>Επίθετο καθηγητή/τριας μαθήματος:</label>
									<input type="text" name="LastName" required value=$last_name>
								</div>-->
								<div>
                                    <label>Εξάμηνο μαθήματος:</label>
									<select class="select_form" name="Semester">
EOF;
echo $editHTML;									
$sql2 ="SELECT semester.ID as IDsem,name FROM semester INNER JOIN semester_course ON semester_course.ID_semester=semester.ID WHERE semester_course.ID_course=:id AND semester_course.ID_depart=:id_depart";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id',$id,PDO::PARAM_STR);
$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt2-> execute();
$row2=$stmt2 ->fetch(PDO::FETCH_OBJ);
$id_sem= $row2 -> IDsem;		
$name_semester= $row2 -> name;	
$_SESSION['Semester']=$id_sem;	
$editHTML=<<<EOF
									<option value="$id_sem" selected="selected">$name_semester εξάμηνο</option>
EOF;
echo $editHTML;	
$sql2 ="SELECT ID,name FROM semester WHERE ID<>:id_sem";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id_sem',$id_sem,PDO::PARAM_STR);
$stmt2-> execute();
while($row2=$stmt2 ->fetch(PDO::FETCH_OBJ)){
$id_sem= $row2 -> ID;		
$name_semester= $row2 -> name;	
$editHTML= <<<EOF
									<option value="$id_sem">$name_semester εξάμηνο</option>
EOF;
echo $editHTML;
}
$editHTML= <<<EOF
									</select>
									<!--<input type="text" name="Semester" required value=$name_semester>-->							
								</div>								
								<div>
                                    <label>Μάθημα Επιλογής:</label>
									<select class="select_form" name="optional" id="sel">
EOF;
echo $editHTML;
$sql ="SELECT optional FROM course WHERE ID=:get_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':get_id',$ID,PDO::PARAM_STR);
$stmt-> execute();
$count = $stmt->rowCount();
if($count>0){
	$row= $stmt ->fetch(PDO::FETCH_OBJ);
	$optional= $row -> optional;
	if($optional=="yes"){
$editHTML= <<<EOF
		<option value="1" selected="selected">Ναι</option>
		<option value="2">Όχι</option>
EOF;
echo $editHTML;	
	}else{
$editHTML= <<<EOF
		<option value="1">Ναι</option>
		<option value="2" selected="selected">Όχι</option>
EOF;
echo $editHTML;	
	}

}else{
$editHTML= <<<EOF
										<option selected disabled>-- Eπιλέξτε Τμήμα --</option>									
										<option value="1">Ναι</option>
										<option value="2">Όχι</option>
EOF;
echo $editHTML;	
}
$editHTML= <<<EOF
									</select>
									<!--<input type="text" name="Semester" required value=$name_semester>-->							
								</div>


<!-- --------------------------------------------------------------------------------------------------------------- kaT ------------------------------------------- -->


								<div>
                                    <label for="kind">Κατεύθυνση:</label>
                                    <table style="margin: auto;"> 
									
EOF;
echo $editHTML;
$table_equip=array();
								$sql1="SELECT * FROM course_kateuthinsi where ID_course = :id AND ID_department=:id_depart";
								$stmt1 = $dbh->prepare($sql1);
								$stmt1->bindParam(':id',$ID,PDO::PARAM_INT);
								$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
								$stmt1-> execute();
								while($row = $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_equip=$row -> ID_kat;	
									$sql2="SELECT * FROM kateuthinsi where ID_department=:id_depart";
									$stmt2= $dbh->prepare($sql2); 
									$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
								    $stmt2-> execute();
									for($i=0; $row1 = $stmt2 ->fetch(PDO::FETCH_OBJ); $i++){
										$id_equip2=$row1 -> ID;
										$name_equip= $row1 -> name;
										if($id_equip2==$id_equip){
											$table_equip[$i]=$id_equip2;
$editHTML=<<<EOF
										<!-- <div class="checkbox">
										<input type="checkbox" id="name_equip" name="choosenEquipments[]" value="[id_equip2]" checked="checked" >
										<input type="hidden" id="name_equip" name="chosenEquipmnets_hidden[]" value="[id_equip2]">
										<label><span>&nbsp $name_equip</span></label>
										</div> -->
										<tr>
											<td align='center'>
												<span class="delete" id="$id_equip2.$ID" style="color:blue"><i class="fa fa-trash" style="font-size:20px;color:red;"></i></span>
											</td>
											<td align='center'>
											<label>$name_equip</label> 
											</td>
										</tr>
EOF;
echo $editHTML;
									}
								}
							}						
					if(sizeof($table_equip)>0 ){
						$sql="SELECT * FROM kateuthinsi where ID_department=:id_depart";
						$stmt= $dbh->prepare($sql); 
						$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						$stmt-> execute();		
						while($row = $stmt ->fetch(PDO::FETCH_OBJ)){		
							$id_equip3=$row -> ID;
							$name_equip= $row -> name;
							$flag=0;
							$table_equip1=$table_equip;
							foreach($table_equip1 as $value){
								if($value==$id_equip3){
									$flag=1;
								}
							}
							if($flag !=1){
$editHTML=<<<EOF
								<tr>
									<td align='center'>
										<input type="checkbox" id="name_equip" name="choosenEquipments1[]" value="$id_equip3" class="custom-control-input" id="customCheck1">
									</td>
									<td align='center'>	
										<label class="custom-control-label" for="customCheck1">$name_equip</label>
									</td>
										<input type="hidden" id="name_equip" name="chosenEquipmnets_hidden[]" value="[id_equip2]">
								</tr>
EOF;
echo $editHTML;
							}
						}
					}else{	
								$sql="SELECT * FROM kateuthinsi where ID_department=:id_depart";
								$stmt= $dbh->prepare($sql); 
								$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
								$stmt-> execute();		
								while($row = $stmt ->fetch(PDO::FETCH_OBJ)){		 
									$id_equip3=$row -> ID;
									$name_equip= $row -> name;
$editHTML=<<<EOF
								<tr>
									<td align='center'>
		   								<input type="checkbox" id="name_equip" name="choosenEquipments1[]" value=$id_equip3" > 
		   								<input type="hidden" id="name_equip" name="chosenEquipmnets_hidden[]" value="[id_equip2]">
		   							</td>
		   							<td>	
		   								<label><span>&nbsp $name_equip</span></label>
		   							</td>
		   						</tr>	
EOF;
echo $editHTML;
								}	
					}
$editHTML=<<<EOF
								</table>
                                </div>





								 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>
										<a href="course.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>
EOF;
echo $editHTML;
 }
 $editHTML=<<<EOF
 <footer>
 $footer
 </footer>
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
    $(document).ready(function () {
        $('#sel').change(function () {
            if ($(this).val() == 2) {
                $(':checkbox').each(function () {
                    $(this).prop('disabled', false);
                    $('#lbl').text('Μπορείτε να επιλέξετε κατεύθυνση αν υπάρχει').show('slow');
                });
            }
            else {
                $(':checkbox').each(function () {
                    $(this).prop('disabled', true);
                    $(this).prop('checked', false);
                    $('#lbl').text('Για να ενεργοποιηθούν οι κατευθύνσεις πρέπει το πεδίο "Μάθημα επιλογής" να είναι "Οχι"').show('slow');
                });
            }
        });
    });
</script>
</body>
</html>
EOF;
echo $editHTML;
?>					