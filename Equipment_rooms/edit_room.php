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
$sql="SELECT * FROM rooms WHERE ID=:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt-> execute();
$table_equip=array();

while($row = $stmt->fetch(PDO::FETCH_OBJ)){	
$id=$row->ID;
$name=$row->name;
//$kind=$row->kind;

/*$sql="SELECT name FROM  type_room where ID = :kind ";
$stmt10 = $dbh->prepare($sql);
$stmt10->bindParam(':kind',$kind,PDO::PARAM_INT);
$stmt10-> execute();
$row10=$stmt10->fetch(PDO::FETCH_OBJ);
$kind1= $row10 -> name;*/
}
$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_room.php?ID=$id"  enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Στοιχείων Αίθουσας</h4>
                                <hr>
								<div>
                                    <label>Όνομα Αίθουσας:</label>
									<input type="text" name="Name" value='$name' required>
								</div>	
								<div>
                                    <label for="kind">Εξοπλησμός:</label>
                                    <table style="margin: auto;"> 
									
EOF;
echo $editHTML;
								$sql1="SELECT * FROM equipment_room where ID_rooms = :id AND ID_departament=:id_depart";
								$stmt1 = $dbh->prepare($sql1);
								$stmt1->bindParam(':id',$id,PDO::PARAM_INT);
								$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
								$stmt1-> execute();
								while($row = $stmt1->fetch(PDO::FETCH_OBJ)){
									$id_equip=$row -> ID_equipment;	
									$sql2="SELECT * FROM equipment ORDER by name";
									$stmt2= $dbh->prepare($sql2); 
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
						$sql="SELECT * FROM equipment ORDER by name";
						$stmt= $dbh->prepare($sql); 
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
								$sql="SELECT * FROM equipment ORDER by name";
								$stmt= $dbh->prepare($sql); 
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
										<a href="rooms.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>

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
</script>
</body>
</html>
EOF;
echo $editHTML;
?>
								