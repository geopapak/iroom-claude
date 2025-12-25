<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include ('modal_gram.php');
$message=null;
//$pagination = new paginate_1($dbh);
$printrooms = <<< EOF
<html>
<body>
		$menu1
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
if(isset($_SESSION['add'])){
	if($_SESSION['add']==0){
  		unset($_SESSION['add']);
		echo "<div class='alert alert-success' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Ο χρήστης έχει <strong>καταχωρηθεί</strong> με επιτυχία.";
		echo "$message</div>";
	}elseif($_SESSION['add']==1){
		unset($_SESSION['add']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "<strong>Προχοχή!</strong> Έχετε καταχωρήσει ήδη τον χρήστη με αυτό το E-mail είτε για καθηγητή είτε για φοιτητή.";
		echo "$message</div>";
	}
}
if(isset($_SESSION['editroom'])){
	if($_SESSION['editroom']==1){
  		unset($_SESSION['editroom']);
		echo "<div class='alert alert-success' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Ο χρήστης έχει <strong>επεξεργαστεί</strong> με επιτυχία.";
		echo "$message</div>";
} elseif($_SESSION['editroom']==2){
	unset($_SESSION['editroom']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "<strong>Προχοχή!</strong> Έχετε καταχωρήσει ήδη τον χρήστη με αυτό το E-mail.";
	echo "$message</div>";
}else{
	unset($_SESSION['editroom']);
	echo "<div class='alert alert-danger' role='alert'>"  ;
	echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
	$message = "Αποτυχία επεξεργασίας";
	echo "$message</div>";
}
}
if(isset($_SESSION['delete'])){
	if($_SESSION['delete']==0){
  		unset($_SESSION['delete']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Ο χρήστης έχει <strong>διαγραφεί</strong> με επιτυχία.";
		echo "$message</div>";
	}
}
$printrooms = <<< EOF
                                <tr>
                                    <th style="text-align:center;">Όνομα</th>
									<th style="text-align:center;">Επώνυμο</th>
									<th style="text-align:center;">Τηλέφωνο</th>
									<th style="text-align:center;">E-mail </th>
									<th style="text-align:center;">Τμήμα</th>
									<th style="text-align:center;">Επίπεδο Χρήστη</th>
									<th style="text-align:center;">Ενέργειες</th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$query="SELECT * FROM  users WHERE user_type='Γραμματεια'";
         $stmt = $dbh->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
         $stmt->execute();
         if($stmt->rowCount()>0)
         {
                while($row=$stmt->fetch(PDO::FETCH_OBJ))
                {             
								$id=$row->ID;
								$name=$row ->name;
								$last_name=$row->last_name;
								$email=$row->email;
								$phone=$row->phone;
								$depart=$row->ID_departament;
								$type=$row->user_type;
								$sql="SELECT name FROM  departament where ID = :depart ";
								$stmt10 = $dbh->prepare($sql);
								$stmt10->bindParam(':depart',$depart,PDO::PARAM_INT);
								$stmt10-> execute();
								$row10=$stmt10->fetch(PDO::FETCH_OBJ);
								$depart1= $row10 -> name;
$printusers = <<< EOF
								<tr  class="table-row">
								<td style="text-align:center; word-break:break-all; width:300px;"> $name </td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $last_name</td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $phone</td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $email</td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $depart1</td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $type</td>
									<td style="text-align:center; width:350px;">
									<a href="../Users/edit_user.php?ID=$id" class="btn btn-info">Επεξεργασία</a>
									 <a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>
								</td>
								<!-- Modal -->
								<div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
								<h3 id="myModalLabel">Διαγραφή</h3>
								</div>
								<div class="modal-body">
								<p><div style="font-size:larger;color:#b94a48;background-color:#f2dede;border-color:#eed3d7;padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5); border-radius: 4px;opacity: 1;transition: opacity 0.6s;" class="">Είστε σίγουροι ότι θέλετε να διαγράψετε τον/την <b style="color:red;">$name $last_name</b>?</p>
								</div>
								<hr>
								<div class="modal-footer">
								<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
								<a href="../Users/delete.php?ID=$id" class="btn btn-danger">Ναι</a>
								</div>
								</div>
								</tr> 
EOF;
echo $printusers;
                }
         }
         else
         {
$printusers = <<< EOF
                <tr>
                <td>Δεν υπάρχει στην βάση...</td>
                </tr>
EOF;
echo $printusers; 
         }
$printusers = <<< EOF
							</tbody>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Γραμματειας</a><br>
							<div class="pagination">
EOF;
echo $printusers; 
							//$pagination->paginglink($query,$data_per_Page);
$printusers = <<< EOF
							<input class="form-control" id="myInput" type="text" placeholder="Αναζήτηση..">
							</div>
                        </table>
</div>				
<footer>
$footer
    </footer>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table-body tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
window.setTimeout(function() {
    $(".alert").fadeTo(700, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
</body>
</html>
EOF;
echo $printusers ;
?>
