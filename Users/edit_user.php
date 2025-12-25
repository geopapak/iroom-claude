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
	</header>
EOF;
echo $editHTML;
$sql="SELECT * FROM users where ID=:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	
$id=$row->ID;
$name=$row->name;
$last_name=$row->last_name;
$phone=$row->phone;
$email=$row->email;
$user_type=$row->user_type;
$ID_departament=$row->ID_departament;
$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_user.php?ID=$id"  enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Στοιχεία Χρήστη</h4>
                                <hr>
								<div>
                                    <label>Όνομα:</label>
									<input type="text" name="Name" required value="$name">
								</div>	
								<div>
                                    <label>Επώνυμο:</label>
									<input type="text" name="Lname" required value="$last_name">
								</div>	
								<div>
                                    <label>Τηλέφωνο:</label>
									<input type="text" name="Phone" required value="$phone">
								</div>	
								<div>
                                    <label>E-mail:</label>
									<input type="text" name="Email" required value="$email">
								</div>	
								<div>
                                    <label>Τμήμα:</label>
									<select name="Depart">
EOF;
echo $editHTML;
$sql="SELECT * FROM departament where ID = :ID_departament";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID_departament',$ID_departament,PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$depart=$row->name;
$editHTML=<<<EOF
										<option value="$ID_departament" selected="selected">$depart</option>
EOF;
echo $editHTML;
$sql="SELECT * FROM departament where ID <> :ID_departament";
$stmt1 = $dbh->prepare($sql);
$stmt1->bindParam(':ID_departament',$ID_departament,PDO::PARAM_INT);
$stmt1-> execute();
while($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){
$iddepart=$row1->ID;	
$depart=$row1->name;
$editHTML=<<<EOF
									<option value="$iddepart">$depart</option>
									<!-- <input type="text" name="ID_departament" required value=$depart> -->
EOF;
echo $editHTML;	
}								
$editHTML=<<<EOF
									</select> 
								<div>
                                    <label>Αλλαγή κωδικού:</label>
									<input type="text" name="Pass" value="$pass">
								</div>										
								</div>	
								 <div class="button">
								 		<a class="btn btn-warning" href="#code$ID" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;margin-top: 1%;">Προσθήκη/Αλλαγή Κωδικού</a>
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>

EOF;
echo $editHTML;
if($user_type=='Καθηγητής'){
$editHTML=<<<EOF
			<a href="main_user.php" class="btn btn-danger" >Πίσω</a>
EOF;
echo $editHTML;			
		}elseif($user_type=='Γραμματεια'){
$editHTML=<<<EOF
			<a href="../Global/gramuser.php" class="btn btn-danger" >Πίσω</a>
EOF;
echo $editHTML;			
		}else{
$editHTML=<<<EOF
			<a href="userstudent.php" class="btn btn-danger" >Πίσω</a>
EOF;
echo $editHTML;			
		}
$editHTML=<<<EOF
										<!--<a href="main_user.php" class="btn btn-danger" >Πίσω</a>-->
                                </div>
                            </form>
EOF;
echo $editHTML;
 }
 $editHTML=<<<EOF

 <footer>
 $footer
 </footer>
 										<div id="code$ID" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-header">
											<h3 id="myModalLabel">Διαγραφή</h3>
										</div>
										<div class="modal-body">
										<p style="font-size:larger;color:#b94a48;background-color:#f2dede;border-color:#eed3d7;padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5); border-radius: 4px;opacity: 1;transition: opacity 0.6s;" class="">Είστε σίγουροι οτι θέλετε για να αλλάξετε ή προσθέσετε κωδικό στον <b style="color:red;">$name $last_name</b>? Και στις δυο περιπτώσεις θα σταλεί email, από το σύστημα, στο email που επιλέξατε με τον νέο κωδικό. 
										</p>
										</div>
										<hr>
										<div class="modal-footer">
											<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
											<a href="code.php?ID=$id" class="btn btn-danger">Ναι</a>
										</div>
									</div>
</body>
</html>
EOF;
echo $editHTML;
?>
								