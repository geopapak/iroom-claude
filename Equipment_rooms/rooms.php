<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
//include_once 'pagination_room.php';
include ('modal_rooms.php');
$user_dp=$_SESSION['user_dp'];
$message=null;
//$pagination = new paginate_1($dbh);
$printrooms = <<< EOF
<html>
<body>
$menu

<header>
                 $head
				 $redirect
				 <script type="text/javascript" src="../js/scripts.js"></script>
	</header>
	 
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	
						<table id="myTable" >
						<thead>
						
								
EOF;
echo $printrooms;

if(isset($_SESSION['editroom'])){
if($_SESSION['editroom']==1){
  	unset($_SESSION['editroom']);
	echo "<div class='alert success'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Η αίθουσα έχει <strong>επεξεργαστεί</strong> με επιτυχία.";
	echo "$message</div>"  ;
} elseif($_SESSION['editroom']==2){
	unset($_SESSION['editroom']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "<strong>Προχοχή!</strong> Έχετε καταχωρήσει ήδη αίθουσα με αυτό το όνομα ή κωδικό.";
	echo "$message</div>";
}else{
	unset($_SESSION['editroom']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "<strong>Προχοχή!</strong> Αποτυχία επεξεργασίας.";
	echo "$message</div>";
}
}
if(isset($_SESSION['addroom'])){
	if($_SESSION['addroom']==0){
		unset($_SESSION['addroom']);
		echo "<div class='alert success'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Η αίθουσα έχει <strong>καταχωρηθεί</strong> με επιτυχία.";
		echo "$message</div>";
	}elseif($_SESSION['addroom']==1){
		unset($_SESSION['addroom']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "<strong>Προχοχή!</strong> Έχετε καταχωρήσει ήδη αίθουσα με αυτό το όνομα ή κωδικό.";
		echo "$message</div>";
	}
}
if(isset($_SESSION['deleteroom'])){
	if($_SESSION['deleteroom']==1){
		unset($_SESSION['deleteroom']);
		echo "<div class='alert alert-success' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Η αίθουσα έχει <strong>διαγραφεί</strong> με επιτυχία.";
		echo "$message</div>";
	}
}
$printrooms = <<< EOF
                                <tr>
                                    <th style="text-align:center;">Όνομα</th>
									<!-- <th style="text-align:center;">Είδος</th> -->
									<th style="text-align:center;">Εξοπλισμός</th>
									<th style="text-align:center;">Ενέργειες </th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
if (isset($user_dp)) { 
								$query="SELECT rooms.ID,rooms.name FROM  rooms inner join room_depart on rooms.ID=room_depart.ID_room WHERE room_depart.ID_departament=$user_dp order by rooms.name";
}
else
{
								$query="SELECT rooms.ID,rooms.name FROM  rooms inner join room_depart on rooms.ID=room_depart.ID_room order by rooms.name";
}
         $stmt = $dbh->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
         //$stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
         $stmt->execute();
 
         if($stmt->rowCount()>0)
         {
                while($row=$stmt->fetch(PDO::FETCH_OBJ))
                {             
								$id=$row->ID;
								$name=$row ->name;
								/*$kind=$row->kind; 
								$sql="SELECT name FROM  type_room where ID = :kind ";
								$stmt10 = $this->db->prepare($sql);
								$stmt10->bindParam(':kind',$kind,PDO::PARAM_INT);
								$stmt10-> execute();
								$row10=$stmt10->fetch(PDO::FETCH_OBJ);
								$kind1= $row10 -> name;*/
$printrooms = <<< EOF
								<tr  class="table-row">
								<td style="text-align:center; word-break:break-all; width:300px;"> $name </td>
								<!-- <td style="text-align:center; word-break:break-all; width:300px;">  </td> -->
								<td style="text-align:center; word-break:break-all; width:300px;">
EOF;
echo $printrooms; 

								$sql="SELECT * FROM  equipment_room where ID_rooms = :id AND ID_departament=:id_depart";
								$stmt1 = $dbh->prepare($sql);
								$stmt1->bindParam(':id',$id,PDO::PARAM_INT);
                                $stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_INT);
								$stmt1-> execute();
								while($row1=$stmt1->fetch(PDO::FETCH_OBJ)){
									$id_equip = $row1->ID_equipment;
									$sql1="SELECT * FROM  equipment where ID= :id_equip";
									$stmt2 = $dbh->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
									$stmt2->bindParam(':id_equip',$id_equip,PDO::PARAM_INT);
									$stmt2->execute();
									$row2=($stmt2 ->fetch(PDO::FETCH_OBJ));
									$name_equip= $row2 -> name;
$printrooms = <<< EOF
								$name_equip <br>
EOF;
echo $printrooms; 
								}		
$printrooms = <<< EOF
									</td>
									<td style="text-align:center; width:350px;">
									<a href="edit_room.php?ID=$id" class="btn btn-info">Επεξεργασία</a>
									 <a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>
								</td>
								<!-- Modal -->
								<div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
								<h3 id="myModalLabel">Διαγραφή</h3>
								</div>
								<div class="modal-body">
								<p><div style="font-size:larger;" class="">Είστε σίγουροι ότι θέλετε να διαγράψετε την αίθουσα <b style="color:red;">$name</b>?</p>
								</div>
								<hr>
								<div class="modal-footer">
								<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
								<a href="delete_room.php?ID=$id" class="btn btn-danger">Ναι</a>
								</div>
								</div>
								</tr> 
EOF;
echo $printrooms;
                }
         }
		 
         else
         {
$printrooms = <<< EOF
                <tr>
                <td>Δεν υπάρχουν δεδομένα στη βάση...</td>
                </tr>
EOF;
echo $printrooms; 
         }
$printrooms = <<< EOF
</tbody>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Αίθουσας</a><br>
							<div style="font-size: 25px;text-align: center;">Πίνακας Αιθουσών</div>
							<div class="pagination">
							<!-- <input class="form-control" id="myInput" type="text" placeholder="Αναζήτηση.."> -->
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
