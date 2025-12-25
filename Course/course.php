<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include ('modal_course.php');
$user_dp=$_SESSION['user_dp'];

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
			<tr>
EOF;
echo $printrooms;
if(isset($_SESSION['addcourse'])){
	if($_SESSION['addcourse']==1){
  		unset($_SESSION['addcourse']);
		echo "<div class='alert alert-success' role='alert'>"  ;
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		$message = "Το μάθημα έχει <strong>καταχωρηθεί</strong> με επιτυχία.";
		echo "$message</div>"  ;
	} elseif($_SESSION['addcourse']==2){
		unset($_SESSION['addcourse']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Έχετε καταχωρήσει ήδη το μάθημα.";
		echo "<strong>Προσοχη ! </strong>$message</div>"  ;
	}
}
if(isset($_SESSION['editcoursename'])){
	if($_SESSION['editcoursename']==1){
  		unset($_SESSION['editcoursename']);
		echo "<div class='alert alert-success' role='alert'>"  ;
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		$message = "Το μάθημα έχει <strong>επεξεργαστεί</strong> με επιτυχία.";
		echo "$message</div>"  ;
	}else{
		unset($_SESSION['editcoursename']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		$message = "Έχετε καταχωρήσει ήδη το μάθημα ή τον κωδικό.";
		echo "<strong>Προσοχη ! </strong>$message</div>"  ;
	}
}
if(isset($_SESSION['deletecourse'])){
	if($_SESSION['deletecourse']==1){
  		unset($_SESSION['deletecourse']);
		echo "<div class='alert alert-danger' role='alert'>"  ;
		echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
		$message = "Το μάθημα έχει <strong>διαγραφεί</strong> με επιτυχία.";
		echo "$message</div>"  ;
	} 
}

$printrooms = <<< EOF
								</tr>
                                <tr>
                                    <th style="text-align:center;">Όνομα</th>
									<th style="text-align:center;">Εξάμηνο</th>
									<th style="text-align:center;">Καθηγητής/<br>Καθηγήτρια</th>
									<th style="text-align:center;">Κωδικός</th>
									<th style="text-align:center;">Επιλογής</th> 
									<th style="text-align:center;">Ενέργειες </th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
		$query="SELECT course.ID,course.name,course.year,course.code,course.optional FROM  course inner join course_depart on course.ID=course_depart.ID_course WHERE course_depart.ID_departament=:id_depart ORDER BY course.name";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
        $stmt->execute();
         if($stmt->rowCount()>0)
         {
                while($row=$stmt->fetch(PDO::FETCH_OBJ))
                {              		
								$id=$row->ID;
								$name=$row ->name;
								$year=$row ->year;
								$code=$row ->code;
$printrooms = <<< EOF
								<tr  class="table-row">
								<td style="text-align:center; word-break:break-all; width:300px;"> $name 
EOF;
echo $printrooms;								
								$query1="SELECT name FROM  kateuthinsi inner join course_kateuthinsi on kateuthinsi.ID=course_kateuthinsi.ID_kat WHERE course_kateuthinsi.ID_department=:id_depart AND course_kateuthinsi.ID_course=:ID_course";
						        $stmt1 = $dbh->prepare($query1);
						        $stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
						        $stmt1->bindParam(':ID_course',$id,PDO::PARAM_STR);
						        $stmt1->execute();
						        if($stmt1->rowCount()>0){
							        while ( $row1=$stmt1 ->fetch(PDO::FETCH_OBJ)) {
							        $name1=$row1->name;	
						   		
$printrooms = <<< EOF

<br> <strong>$name1</strong>
EOF;
echo $printrooms;
}
}
$printrooms = <<< EOF
</td>
                                <td style="text-align:center; word-break:break-all; width:300px;">
EOF;
echo $printrooms;

$sql1="SELECT name,last_name FROM users INNER JOIN course_profesor ON course_profesor.ID_profesor=users.ID WHERE course_profesor.ID_course=:id AND course_profesor.ID_depart=:id_depart";
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':id',$id,PDO::PARAM_INT);
$stmt1->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt1-> execute();
$row1= $stmt1 ->fetch(PDO::FETCH_OBJ);
$num=$stmt1->rowCount();
if($num>0){
$name_user= $row1 -> name;
$last_name= $row1-> last_name;
}else{
	$name_user='';
	$last_name='';
}
$sql2 ="SELECT name FROM semester INNER JOIN semester_course ON semester_course.ID_semester=semester.ID WHERE semester_course.ID_course=:id AND semester_course.ID_depart=:id_depart";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id',$id,PDO::PARAM_STR);
$stmt2->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt2-> execute();
while($row2=$stmt2 ->fetch(PDO::FETCH_OBJ)){
$name_semester= $row2 -> name;

$printrooms = <<< EOF
								 $name_semester 
EOF;
echo $printrooms;
}
$printrooms = <<< EOF
                                  </td>	
								<td style="text-align:center; word-break:break-all; width:300px;"> $name_user <br> $last_name</td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $code </td>
								<td style="text-align:center; word-break:break-all; width:300px;"> 
EOF;
echo $printrooms;

$sql3 ="SELECT optional FROM course inner join course_depart on course.ID=course_depart.ID_course WHERE course.ID=:id AND course_depart.ID_departament=:id_depart";
$stmt3 = $dbh->prepare($sql3);
$stmt3->bindParam(':id',$id,PDO::PARAM_INT);
$stmt3->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
$stmt3-> execute();
while($row3=$stmt3 ->fetch(PDO::FETCH_OBJ)){
		$optional= $row3 -> optional;
        if($optional=="yes"){
            $optional1="Ναι";
        }else{
            $optional1="Όχι";
        }
$printrooms = <<< EOF
								$optional1<br> 
EOF;
echo $printrooms;
	}
$printrooms = <<< EOF
									</td>
								<td style="text-align:center; width:350px;">
									<a href="edit_course.php?ID=$id" class="btn btn-info">Επεξεργασία</a>
									 <a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>
								</td>
								<!-- Modal -->
								<div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
								<h3 id="myModalLabel">Διαγραφή</h3>
								</div>
								<div class="modal-body">
								<p><div style="font-size:larger;" >Είστε σίγουροι ότι θέλετε να διαγράψετε το μάθημα <b style="color:red;">$name</b>?</p>
								</div>
								<hr>
								<div class="modal-footer">
								<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
								<a href="delete_course.php?ID=$id" class="btn btn-danger">Ναι</a>
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
                <td>Δεν υπάρχουν δεδομένα στην βάση...</td>
                </tr>
EOF;
echo $printrooms; 
         }
$printrooms = <<< EOF
							
							<tr>
							</tr>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Μαθήματος</a><br>
							<div style="font-size: 25px;text-align: center;">Πίνακας Μαθημάτων</div>
							<div class="pagination">

							<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Αναζήτηση..">
							</div>
                        </table>

</div>				
<footer>
$footer
    </footer>

</body>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(900, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

    $(document).ready(function () {
        $('#sel').change(function () {
            if ($(this).val() == 2) {
                $(':checkbox').each(function () {
                    $(this).prop('disabled', false);
                    $('#lbl').text('Μπορείτε να επιλέξετε κατεύθυνση αν υπάρχει').show('slow');
                });
            }
            else {
                $(':checkbox').each(function () {
                    $(this).prop('disabled', true);
                    $(this).prop('checked', false);
                    $('#lbl').text('Για να ενεργοποιηθούν οι κατευθύνσεις πρέπει το πεδίο "Μάθημα επιλογής" να είναι "Οχι"').show('slow');
                });
            }
        });
    });
</script>
</html>

EOF;
echo $printrooms ;
?>