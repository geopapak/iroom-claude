<?php

$modal= <<<EOF
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη Μαθήματος</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="add_course.php"  enctype="multipart/form-data">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Όνομα Μαθήματος</label></td>
							<td width="30"></td>
							<td><input type="text" name="Name" placeholder="Όνομα"  required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Χρονιά Μαθήματος</label></td>
							<td width="30"></td>
							<td><input type="text" name="Year" placeholder="Χρονιά" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Κωδικός Μαθήματος</label></td>
							<td width="30"></td>
							<td><input type="text" name="Code" placeholder="Κωδικός" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Εξάμηνο</label></td>
							<td width="30"></td>
							<td><select name="Semester" required>
										<option selected disabled>-- Eπιλέξτε --</option>
										<option value="1o">1ο εξάμηνο</option>
										<option value="2o">2ο εξάμηνο</option>
										<option value="3o">3ο εξάμηνο</option>
										<option value="4o">4ο εξάμηνο</option>
										<option value="5o">5ο εξάμηνο</option>
										<option value="6o">6ο εξάμηνο</option>
										<option value="7o">7ο εξάμηνο</option>
										<option value="8o">8ο εξάμηνο</option>
										<option value="9o">9ο εξάμηνο</option>
										<option value="10o">10ο εξάμηνο</option>
									</select>
									<!-- <input type="text" name="Semester" placeholder="" required /></td> -->
							</td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Βοηθητικό Εξάμηνο</label></td>
							<td width="30"></td>
							<td><select name="Semester1">
										<option selected disabled>-- Eπιλέξτε --</option>
										<option value="1o">1ο εξάμηνο</option>
										<option value="2o">2ο εξάμηνο</option>
										<option value="3o">3ο εξάμηνο</option>
										<option value="4o">4ο εξάμηνο</option>
										<option value="5o">5ο εξάμηνο</option>
										<option value="6o">6ο εξάμηνο</option>
										<option value="7o">7ο εξάμηνο</option>
										<option value="8o">8ο εξάμηνο</option>
										<option value="9o">9ο εξάμηνο</option>
										<option value="10o">10ο εξάμηνο</option>
									</select>
									<!-- <input type="text" name="Semester" placeholder="" required /></td> -->
							</td>
						</tr>
						<tr>
						<td><label style="color:#3a87ad; font-size:18px;">Καθηγητής/τρια</label></td>
							<td width="30"></td>
							<td><select class="select_form" name="IDUser" required>
								<option selected disabled>-- Eπιλέξτε --</option>
EOF;
echo $modal;
$user_type='Καθηγητής';
$sql="SELECT ID,name,last_name FROM users WHERE user_type=:user_type";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_type',$user_type,PDO::PARAM_STR);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id=$row->ID;
$name=$row->name;			
$last_name=$row->last_name;
$modal= <<<EOF
								<option value="$id">$last_name $name</option>
EOF;
echo $modal;
}
$modal= <<<EOF
								</select>
								</td>
						</tr>
						<!-- <tr>
							<td><label style="color:#3a87ad; font-size:18px;">Όνομα Καθηγητή</label></td>
							<td width="30"></td>
							<td><input type="text" name="Name1" placeholder="Όνομα" autocomplete="off" /></td>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Επίθετο Καθηγητή</label></td>
							<td width="30"></td>
							<td>
							<div  class="search-box">
							<input type="text" name="LastName" placeholder="Επίθετο" autocomplete="off" required/>
							<div class="result"></div>
							</div>
							</td>
						</tr>-->
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Μάθημα επιλογής</label></td>
								<td width="30"></td>
								<td>
									<select class="select_form" name="optional" id="sel" required>3
										<option selected disabled>-- Eπιλέξτε --</option>
										<option value="1">Ναι</option>
										<option value="2">Όχι</option> 
									</select>
							</td>
						</tr>
							<tr>
							<td><label style="color:#3a87ad; font-size:18px; width:100%">Επιλέξτε την κατεύθυνση <strong>μόνο</strong> για μαθήματα κορμού:</label></td>
							<td width="30"></td>
EOF;
echo $modal;							
$sql= "SELECT * FROM  kateuthinsi where ID_department=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt-> execute();
while($row = $stmt ->fetch(PDO::FETCH_OBJ))
					{
							$ID=$row -> ID;
							$name=$row -> name;					
$modal= <<<EOF
							<tr>
							<td><input type="checkbox" name="kat[]" value="$ID" disabled="disabled"/> &nbsp $name</td>
							</tr>
EOF;
echo $modal;
					}
$modal= <<<EOF
						</tr> 
					</table>
							<div id="lbl" style="margin-top:10px;display:none;color:green;line-height: 1 !important;"></div>					
	
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
<button type="submit" name="Submit" class="btn btn-primary">Προσθήκη</button>
    </div>
	

					</form>
    </div>
<script>

</script>    
EOF;
echo $modal; 	
?>	