<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include ('modal_kateuthinsi.php');


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
                <th style="text-align:center;">Κατεύθυνση</th>
				<th style="text-align:center;">Ενέργειες </th>
             </tr>
		</thead>
		<tbody id="table-body">
EOF;
echo $printrooms; 
								$query="SELECT * FROM  kateuthinsi where ID_department=:id_depart";
						        $stmt = $dbh->prepare($query);
						        $stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
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
									<!-- <a href="edit_type.php?ID=$id" class="btn btn-info">Επεξεργασία</a> -->
									 <a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>
								</td>
								<!-- Modal -->
								<div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
								<h3 id="myModalLabel">Διαγραφή</h3>
								</div>
								<div class="modal-body">
								<p><div style="font-size:larger;" >Είστε σίγουροι ότι θέλετε να διαγράψετε την κατεύθυνση <b style="color:red;">$name</b>?</p>
								</div>
								<hr>
								<div class="modal-footer">
								<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
								<a href="delete_kateuthinsi.php?ID=$id" class="btn btn-danger">Ναι</a>
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
							</tbody>
							<tr>
							</tr>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Κατεύθυνσης</a><br>
							<div class="pagination">
EOF;
echo $printrooms; 
							//$pagination->paginglink($query,$data_per_Page);
$printrooms = <<< EOF
							<input class="form-control" id="myInput" type="text" placeholder="Αναζήτηση..">
							</div>
                        </table>

</div>				
<footer>
$footer
    </footer>

</body>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(700, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
</html>

EOF;
echo $printrooms ;
?>