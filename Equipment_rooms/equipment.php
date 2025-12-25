<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include ('modal_equipment.php');
$user_type=$_SESSION['user_dp'];

$printrooms = <<< EOF
<html>
<body>
$menu

<header>
                 $head
				 $redirect
	</header>
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	
						<table id="myTable" >
						<thead>
EOF;
echo $printrooms;

if(isset($_SESSION['editequip'])){
if($_SESSION['editequip']==1){
  	unset($_SESSION['editequip']);
	echo "<div class='alert alert-success' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Ο εξοπλισμός έχει <strong>επεξεργαστεί</strong> με επιτυχία.";
	echo "$message</div>";
} elseif($_SESSION['editequip']==2){
	unset($_SESSION['editequip']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "<strong>Προχοχή!</strong> Υπάρχει ήδη ο εξοπλισμός.";
	echo "$message</div>";
}else{
	unset($_SESSION['editequip']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Αποτυχία επεξεργασίας";
	echo "$message</div>";
}
}
if(isset($_SESSION['addeqip'])){
	if($_SESSION['addeqip']==1){
		unset($_SESSION['addeqip']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "<strong>Προχοχή!</strong> Έχετε καταχωρήσει ήδη αυτόν τον εξοπλισμό.";
		echo "$message</div>";
	}elseif($_SESSION['addeqip']==0){
  	unset($_SESSION['addeqip']);
	echo "<div class='alert alert-success' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Ο εξοπλισμός έχει <strong>καταχωρηθεί</strong> με επιτυχία.";
	echo "$message</tr></th>"  ;
	} 	
}
if(isset($_SESSION['delete'])){
	if($_SESSION['delete']==1){
		unset($_SESSION['delete']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "<strong>Προχοχή!</strong> Έχετε διαγράψει τον εξοπλισμό.";
		echo "$message</div>";
	}
}
	
$printrooms = <<< EOF
                                <tr>
                                    <th style="text-align:center;">Όνομα</th>
									<th style="text-align:center;">Ενέργειες </th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$query="SELECT equipment.ID,equipment.name FROM equipment INNER JOIN equipment_depart ON equipment.ID=equipment_depart.ID_equipment WHERE equipment_depart.ID_departament=$user_type";
         						$stmt = $dbh->prepare($query);
         						//$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
        						 $stmt->execute();
 
						         if($stmt->rowCount()>0)
						         {
						                while($row=$stmt->fetch(PDO::FETCH_OBJ))
						                {             
														$id=$row->ID;
														$name=$row ->name;
										
$printrooms = <<< EOF
														<tr  class="table-row">
														<td style="text-align:center; word-break:break-all; width:300px;"> $name </td>
														<td style="text-align:center; width:350px;">
															<a href="edit_equipment.php?ID=$id" class="btn btn-info">Επεξεργασία</a>
															 <a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>
														</td>
														<!-- Modal -->
														<div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-header">
														<h3 id="myModalLabel">Διαγραφή</h3>
														</div>
														<div class="modal-body">
														<p><div style="font-size:larger;" class="">Είστε σίγουροι ότι θέλετε να διαγράψετε τον εξοπλισμό <b style="color:red;">$name</b>?</p>
														</div>
														<hr>
														<div class="modal-footer">
														<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
														<a href="delete_equipment.php?ID=$id" class="btn btn-danger">Ναι</a>
														</div>
														</div>
														</tr> 
EOF;
echo $printrooms;
						                }
						         }else{
$printrooms = <<< EOF
						                <tr>
						                <td>Δεν υπάρχουν δεδομένα στην βάση...</td>
						                </tr>
EOF;
echo $printrooms; 
						         }
$printrooms = <<< EOF
							</tbody>
							<tr>
							</tr>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Εξοπλισμού</a><br>
							<div class="pagination">
EOF;
echo $printrooms; 
$printrooms = <<< EOF
							<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Αναζήτηση..">
							</div>
                        </table>

</div>				
<footer>
$footer
    </footer>

<script>

window.setTimeout(function() {
    $(".alert").fadeTo(700, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>

</body>
</html>

EOF;
echo $printrooms ;
?>