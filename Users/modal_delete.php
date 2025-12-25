<?php 
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$link = explode('/', $actual_link);
if($link[5]=="userstudent.php"){
	$user_type='Φοιτητης ';
}elseif($link[5]=="main_user.php"){
	$user_type='Καθηγητής';
}
$sql= "SELECT * FROM users where ID_departament=:id_depart AND user_type=:user";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
$stmt->bindParam(':user',$user_type,PDO::PARAM_INT);
$stmt-> execute();
$modal = <<< EOF
    <!-- Modal -->
    <div id="code" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη νέου κωδικού ή ανανέωση του υπάρχον.</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="code.php"  enctype="multipart/form-data">
					<table class="table1">
					<p style="font-size:larger;color:#b94a48;background-color:#f2dede;border-color:#eed3d7;padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5); border-radius: 4px;opacity: 1;transition: opacity 0.6s;" class="">Επιλέξτε το email που θέλετε για να αλλάξετε ή προσθέσετε κωδικό. Και στις δυο περιπτώσεις θα σταλεί email, από το σύστημα, στο email που επιλέξατε με τον νέο κωδικό. 
					</p>
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Email</label></td>
							<td width="30"></td>
							<td>
							<select name="id">
								<option value="" selected>-- Επιλέξτε Email -- </option>
EOF;
echo $modal;
								while($row = $stmt->fetch(PDO::FETCH_OBJ)){	
									$id=$row->ID;
									$email=$row->email;
$modal = <<< EOF
								<option value="$id"> $email</option>
EOF;
echo $modal;

								}
$modal = <<< EOF
							</select>
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