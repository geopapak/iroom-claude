<?php
  require_once('connectDB.php');
   $output = '';
   if(isset($_POST['sem'])){
   	$sem=$_POST['sem'];
   }
     if(isset($_POST["id"])){

        $id_sch=$_POST["id"]; 
        $sql="SELECT * FROM  departament WHERE ID=:id_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
		$stmt-> execute();
		$row = $stmt ->fetch(PDO::FETCH_OBJ); 
		$room1=$row->name; 
		$nr = $stmt->rowCount();
	$output .= '
	<link href="css/myTable.css" rel="stylesheet" /> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">';
	if(isset($_POST['sem'])){
	$output .= '<div style="text-align: center;font-size: 25px;">Πρόγραμμα εξαμήνου για το πρόγραμμα σπουδών <br>"'.$room1.' και Εξάμηνο '.$sem.'"</div><br>';
	}else{
	$output .= '<div style="text-align: center;font-size: 25px;">Πρόγραμμα εξαμήνου για το πρόγραμμα σπουδών <br>"'.$room1.'"</div><br>';		
	}
$output .= '<div class="select-after" style="padding-left: 38%;">
	<select name="Room" id="load">
		<option value="'.$id_sch.'">'.$room1.'</option>';
        $sql="SELECT * FROM  departament where ID<>:id_sch order by name";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id_sch',$id_sch,PDO::PARAM_INT);
		$stmt-> execute();
		while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
		$name = $row -> name;
		$id=$row->ID;	
		               $output .= ' <option value='.$id.'>'.$name.'</option>';
		}
	$output .= '</select></div>
	<div class="select-after" style="padding-left: 10px;">	
            <select name="sem" id="load_sem">
              <option value=""  selected>-- Επιλέξτε Εξάμηνο--</option>';
$sql="SELECT * FROM admin_sem where ID_department=:id_depart";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_depart',$id_sch,PDO::PARAM_INT);
$stmt-> execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id_sem_a=$row->ID_sem;
if($id_sem_a==2){

$sql="SELECT ID,name FROM semester where mod(id,2)=0";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
	while($row = $stmt->fetch(PDO::FETCH_OBJ)){
		$id_sem=$row->ID;
		$name=$row->name;
		$output .= '<option value="'.$id_sem.'">'.$name.'</option>';
	}
}else{
$sql="SELECT ID,name FROM semester where mod(id,2)<>0";
$stmt = $dbh->prepare($sql);
$stmt-> execute();
	while($row = $stmt->fetch(PDO::FETCH_OBJ)){
		$id_sem=$row->ID;
		$name=$row->name;
		$output .= '<option value="$id_sem">'.$name.'</option>';
	}
}
$output .= '</select>	</div>';
	if(isset($sem)){
$output .= '<a style="float: left; padding-left:10px" class="like-button" href="printarea.php?depart='.$id_sch.'&ndepart='.$room1.'&sem='.$sem.'" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a><br>';
	}else{
$output .= '<a style="float: left; padding-left:10px" class="like-button" href="printarea.php?depart='.$id_sch.'&ndepart='.$room1.'" target="_blank"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a><br>';
	}
	$output .= '<div id="printableArea">
	<table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Ημέρα/Ωρα</th>';
											$sql="SELECT * FROM  days";
											$stmt = $dbh->prepare($sql);
											$stmt-> execute();
											$count_days=$stmt->rowCount();
											while($row=$stmt->fetch(PDO::FETCH_OBJ)){
												$name_day = $row->name;
		$output .= '<th style="text-align:center;">'.$name_day.'</th>';
											}
						$output .= '</tr>
								</thead>
								<tbody id="table-body">';
												$sql="SELECT * FROM  hours ";
												$stmt = $dbh->prepare($sql);
												$stmt-> execute();
												$row = $stmt ->fetch(PDO::FETCH_OBJ); 
												$id=$row->ID;
												$start_hour=$row ->start_hour;
												$end_hour=$row ->end_hour;
												for($i=$start_hour; $i<$end_hour; $i++){  
													$start_hour1=$i+1;
				$output .= '<tr  class="table-row">
									<td style="text-align:center; word-break:break-all; width:300px;"> '.$i.'.00 - '.$start_hour1.'.00</td>';							
													for($j=1; $j<=$count_days; $j++){
														$sql= "SELECT programme.ID,programme.ID_semester_course,programme.ID_user, semester_course.ID_course FROM programme inner join semester_course on semester_course.ID=programme.ID_semester_course WHERE ID_hour=:start_hour AND ID_day=:id_day AND ID_departament=:id_sch";
														$clauses = array();
														if (isset($sem) and $sem != '') {
															$column1 = $sem;
														    $clauses[] = 'semester_course.ID_semester = '.$column1.'';
														}		
														if ( count($clauses) > 0 ) {
														     $sql .= ' AND '.implode(' AND ', $clauses).';';
														}											
														$stmt1 = $dbh->prepare($sql);
														$stmt1->bindParam(':start_hour',$i,PDO::PARAM_INT);
														$stmt1->bindParam(':id_day',$j,PDO::PARAM_INT);
														$stmt1->bindParam(':id_sch',$id_sch,PDO::PARAM_INT);
														$stmt1-> execute();
														if($stmt1->rowCount()>0){
							$output .= '<td id='.$i.'.'.$j.' style="text-align:center;  word-break:inherit; width:375px;">';
															while($row1= $stmt1->fetch(PDO::FETCH_OBJ)){
																$id_programme=$row1->ID;
																$id_semester_course=$row1->ID_semester_course;
																$id_user=$row1->ID_user;		
																$sql="SELECT course.ID,course.name,semester_course.ID_semester FROM course INNER JOIN semester_course ON semester_course.ID_course=course.ID WHERE semester_course.ID=:id_semester_course";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_semester_course',$id_semester_course,PDO::PARAM_INT);
																$stmt-> execute();
																$row = $stmt->fetch(PDO::FETCH_OBJ);
																$id_course=$row->ID;
																$name_course=$row->name;
																$id_sc=$row->ID_semester;
									
																$sql="SELECT name FROM semester WHERE ID=:id_sc";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_sc',$id_sc,PDO::PARAM_INT);
																$stmt-> execute();
																$row = $stmt->fetch(PDO::FETCH_OBJ);
																$name_semester=$row->name;
									
																$sql="SELECT name,last_name FROM users WHERE ID=:id_user";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
																$stmt-> execute();
																$row = $stmt->fetch(PDO::FETCH_OBJ);
																$name_user=$row->name;
																$lname_user=$row->last_name;
									$output .= ''.$name_course.'<br>'.$name_user.''. $lname_user.'<br>'.$name_semester.'<br>';								
																$id_day_hour=(int)($i.$j);
																$sql="SELECT name FROM rooms INNER JOIN programme_rooms ON rooms.ID=programme_rooms.ID_room WHERE ID_day_hour=:id_day_hour AND ID_course=:id_course";
																$stmt = $dbh->prepare($sql);
																$stmt->bindParam(':id_day_hour',$id_day_hour,PDO::PARAM_INT);
																$stmt->bindParam(':id_course',$id_course,PDO::PARAM_INT);
																$stmt-> execute();
																while($row = $stmt->fetch(PDO::FETCH_OBJ)){
																	$room=$row->name;
										$output .= ''.$room.'<br>';
																}
									$output .= '<hr>';
															}
									$output .= '<br>';
														}else{
									$output .= '<td id='.$i.'.'.$j.'" style="text-align:center; word-break:break-all; width:300px;"></td>';
														}
													}	
				$output .= '</tr>';			
												}
							$output .= '</tbody>
							</div>
                        </table>
                        </div>';
	 }
$output .= '<script>
 $(document).ready(function(){  
      $("#load,#load_sem").change(function(){  
           var id = $(load).val();  
           var sem = $(load_sem).val(); 
           $.ajax({  
                url:"load_sch.php",  
                method:"POST",  
                data:{id:id,
                	sem:sem},  
                success:function(data){  
                     $("#show_table").html(data);  
                }  
           });  
      });  
 }); 
 </script>';
	   echo $output;  						
?>	