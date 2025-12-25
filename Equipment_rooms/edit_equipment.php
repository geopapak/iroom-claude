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
$sql="SELECT * FROM equipment where ID=:ID";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':ID',$ID,PDO::PARAM_INT);
$stmt-> execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	
$id=$row->ID;
$name=$row->name;

$editHTML=<<<EOF
<form method="post" class="form" action="edit_PDO_equipment.php?ID=$id"  enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Στοιχείων Εξοπλησμού</h4>
                                <hr>
								<div>
                                    <label>Όνομα Εξοπλησμού:</label>
									<input type="text" name="Name" required value="$name">
								</div>	
								 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>
										<a href="equipment.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>
EOF;
echo $editHTML;
 }
 $editHTML=<<<EOF
 <footer>
 $footer
 </footer>
</body>
</html>
EOF;
echo $editHTML;
?>
								