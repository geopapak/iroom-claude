<?php 
session_start();
//f(isset($_SESSION['user_id'])AND $_SESSION['user_level']=='Γραμματεια'){
include ('../header.php'); 
include('../connectDB.php');
include ('../footer.php'); 

$editHTML=<<<EOF
<body>
<header>
                 $head
	</header>
EOF;
echo $editHTML;
$editHTML=<<<EOF
<form method="post" class="form" action="add_course.php?ID=$ID"  enctype="multipart/form-data">
                                <legend><h4>Δημιουργία ωραρίου</h4></legend>
                                <hr>
								<div>
                                    <label><strong>Αρχή:</strong></label>
									<select name="Start_hour">
										<option value="8">8.00</option>
										<option value="9">9.00</option>
										<option value="10">10.00</option>
										<option value="11">11.00</option>
										<option value="12">12.00</option>
										<option value="13">13.00</option>
										<option value="14">14.00</option>
										<option value="15">15.00</option>
										<option value="16">16.00</option>
										<option value="17">17.00</option>
										<option value="18">18.00</option>
										<option value="19">19.00</option>
										<option value="20">20.00</option>
									</select>
								</div>	
								<br>
								<div>
                                    <label><strong>Τέλος:</strong></label>
                                    <select name="Start_hour">
										<option value="8">8.00</option>
										<option value="9">9.00</option>
										<option value="10">10.00</option>
										<option value="11">11.00</option>
										<option value="12">12.00</option>
										<option value="13">13.00</option>
										<option value="14">14.00</option>
										<option value="15">15.00</option>
										<option value="16">16.00</option>
										<option value="17">17.00</option>
										<option value="18">18.00</option>
										<option value="19">19.00</option>
										<option value="20">20.00</option>
									</select>
								 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update" ><span>Αποθήκευση</button>
										<a href="calendar.php" class="btn btn-danger" >Πίσω</a>
                                </div>
                            </form>
 <footer>
 $footer
 </footer>
</body>
EOF;
echo $editHTML;
/*}else{
		header('Location:../login.php');
}*/
?>
								