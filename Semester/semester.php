<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include_once 'pagination_semester.php';
include ('modal_semester.php');

$pagination = new paginate_1($dbh);

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
/*
if(isset($_SESSION['editequip'])){
if($_SESSION['editequip']==1){
  unset($_SESSION['editequip']);
echo "<tr><th  style='color:green'>"  ;
$message = "Επιτυχια Επεξεργασιας";
echo "$message</tr></th>"  ;
} elseif($_SESSION['editequip']==2){
	unset($_SESSION['editequip']);
	echo "<tr><th style='color:red'>"  ;
	$message = "Υπαρχει ηδη";
	echo "$message</tr></th>"  ;
}else{
	unset($_SESSION['editequip']);
	echo "<tr><th style='color:red'>"  ;
	$message = "Αποτυχια επεξεργασιας";
	echo "$message</tr></th>"  ;
}
}*/
$printrooms = <<< EOF
                                <tr>
                                    <th style="text-align:center;">Όνομα</th>
									<th style="text-align:center;">Ενέργειες </th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$query="SELECT * FROM  semester ";
								$data_per_Page=10;
								$query_1 = $pagination->paging($query,$data_per_Page);
								$pagination->dataview($query_1);  
$printrooms = <<< EOF
							</tbody>
							<tr>
							</tr>
							<a class="btn btn-primary" href="#myModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Εξαμήνου</a><br>
							<div class="pagination">
EOF;
echo $printrooms; 
							$pagination->paginglink($query,$data_per_Page);
$printrooms = <<< EOF
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

</script>

</body>
</html>

EOF;
echo $printrooms ;
?>