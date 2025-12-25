<?php 
$sql= "SELECT * FROM users ";
$stmt = $dbh->prepare($sql);
$stmt-> execute();

$modal = <<< EOF
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη Χρήστη</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="../Users/insert_user.php"  enctype="multipart/form-data">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Όνομα</label></td>
							<td width="30"></td>
							<td><input type="text" name="Name" placeholder="Όνομα" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Επίθετο</label></td>
							<td width="30"></td>
							<td><input type="text" name="LastName" placeholder="Επίθετο" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Τηλέφωνο</label></td>
							<td width="30"></td>
							<td><input type="text" name="Phone" placeholder="Τηλέφωνο" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Email</label></td>
							<td width="30"></td>
							<td><input type="text" name="Email" placeholder="Email" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Τμήμα</label></td>
							<td width="30"></td>
							<td><select name="Departament" required>
									<option selected disabled>-- Eπιλέξτε Τμήμα --</option>
EOF;
echo $modal; 	
							$sql= "SELECT * FROM departament";
							$stmt = $dbh->prepare($sql);
							$stmt-> execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ)){	
								$id_depart=$row->ID;
								$depart=$row->name;
$modal = <<< EOF
									<option value="$depart">$depart</option>
EOF;
echo $modal; 
							}
$modal = <<< EOF
								</select>
							</td>
							<!-- <td><input type="text" name="depart" placeholder="Τμήμα" required /></td> -->
						</tr>
						<!-- <tr>
							<td><label style="color:#3a87ad; font-size:18px;">Επιπέδο Χρήστη</label></td>
							<td width="30"></td>
							 <td><select name="UserType" required>
										<option selected disabled>-- Eπιλέξτε Τμήμα --</option>
										<option value="Καθηγητής">Καθηγητής</option>
										<option value="Φοιτητης">Φοιτητης</option>
									</select>									
							</td> 
							<td><input type="hidden" name="UserType" value="Καθηγητής""/></td>
						</tr> -->
						<td><input type="hidden" name="UserType" value="Γραμματεια"/></td>
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