<?php
session_start();
require_once('../connectDB.php');
include ('../header.php'); 
require '../redirectHTTPS.php';
include ('../footer.php'); 
include_once 'pagination_university.php';
include ('modal_university.php');
include ('modal_departament.php');

$pagination = new paginate_1($dbh);
$printrooms = <<< EOF
<html>
<body>
$menu1
</div>

<header>
                 $head
				 $redirect
	</header>
<div id="main">
<span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>	

						<table id="myTable" >
						<thead>
                                <tr>
                                    <th style="text-align:center;">Πανεπιστήμιο</th>
									<th style="text-align:center;">Τμήμα</th>
									<th style="text-align:center;">Ενέργειες </th>
                                </tr>
								</thead>
								<tbody id="table-body">
EOF;
echo $printrooms; 
								$query="SELECT * FROM  university order by name";
								$data_per_Page=10;
								$query_1 = $pagination->paging($query,$data_per_Page);
								$pagination->dataview($query_1);  
$printrooms = <<< EOF
							</tbody>
							<a class="btn btn-primary" href="#UniversityModal" data-toggle="modal" style="margin-left: 1%;margin-bottom: 1%;">Προσθήκη Πανεπιστημίου</a>
							<a class="btn btn-primary" href="#DepartamentModal" data-toggle="modal" style="margin-left: 2%;margin-bottom: 1%;">Προσθήκη Τμήματος</a><br>
							<div id="titlos" style="font-size: 20px;text-align: center;">Πίνακας Πανεπιστημίων - Τμημάτων</div2
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