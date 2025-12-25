<?php
$sql= "SELECT * FROM university ";
$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$result=$sth-> execute();
$modal= <<<EOF
    <!-- Modal -->
    <div id="DepartamentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη Τμήματος</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="add_departament.php"  enctype="multipart/form-data">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Τμήμα</label></td>
							<td width="30"></td>
							<td><input type="text" name="Name" placeholder="Όνομα" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Κωδικός Τμήματος</label></td>
							<td width="30"></td>
							<td><input type="text" name="Code" placeholder="Όνομα" required /></td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Πανεπιστήμιο</label></td>
							<td width="30"></td>
							<td>
							<select name="UniName">
EOF;
echo $modal; 
 while($row = $sth ->fetch(PDO::FETCH_OBJ))
                {             
							$ID=$row -> ID;
							$name=$row -> name;
$modal= <<<EOF
							<option value="$name"> $name </option>
EOF;
echo $modal; 
				}
$modal= <<<EOF
						</select>
							</td>
						</tr>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Εξάμηνο</label></td>
							<td width="30"></td>
							<td><select name="sem_admin"><option value="1">Χειμερινό</option><option value="2">Εαρινό</option></select></td>
						</tr>						
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