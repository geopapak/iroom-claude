<?php 
$modal = <<< EOF
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη Αίθουσας</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="add_rooms.php"  enctype="multipart/form-data">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Όνομα αιθουσας</label></td>
							<td width="30"></td>
							<td><input type="text" name="Name" placeholder="Όνομα" required /></td>
						</tr>
						<tr>
<!--							<td><label style="color:#3a87ad; font-size:18px;">Είδος</label></td>
							<td width="30"></td>
							<td><select name="Kind" required>
								<option selected disabled>-- Eπιλέξτε --</option> -->
EOF;
echo $modal; 							
/*								$sql1= "SELECT type_room.ID,type_room.name FROM type_room inner join depart_room on depart_room.ID_type_room=type_room.ID WHERE depart_room.ID_departament=:id_depart";
								$stmt1 = $dbh->prepare($sql1);
								$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
								$stmt1-> execute();
								while($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){
									$id=$row1->ID;
									$type=$row1->name;	*/
$modal = <<< EOF
EOF;
echo $modal; 
							//	}
$modal = <<< EOF
								<!-- <input type="text" name="Kind" placeholder="Είδος" required /> -->
								<!-- </td>
						</tr> -->
						<tr>
							<td><label style="color:#3a87ad; font-size:18px; margin-right: 10px;">Εξοπλισμός</label></td>
						</tr>
						
EOF;
echo $modal; 
$sql= "SELECT equipment.ID,equipment.name FROM equipment INNER JOIN equipment_depart ON equipment.ID=equipment_depart.ID_equipment WHERE equipment_depart.ID_departament=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt-> execute();
$row = $stmt->rowCount();
if($row>0){
while($row = $stmt ->fetch(PDO::FETCH_OBJ))
					{
							$ID=$row -> ID;
							$name=$row -> name;
$modal = <<< EOF
							<tr>
							<td><input type= "checkbox" name="choosenEquipments[]" value="$ID" />$name</td>
							</tr>
EOF;
echo $modal;
					} 
}else{
	echo("<tr><td>Δεν υπάρχουν δεδομενα...<br></td></tr>");
}
$modal = <<< EOF
					</table>
					
	
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
<button type="submit" name="Submit" class="btn btn-primary">Προσθήκη</button>
    </div>
	

					</form>
    </div>			
EOF;
echo $modal; 	
?>