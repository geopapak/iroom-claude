<?php 
 session_start();
include ('../header.php'); 
include('../connectDB.php');
include ('../footer.php'); 
$editHTML=<<<EOF
<body>
<header>
                 $head
</header>
<form method="post" class="form" action="../date.php"  enctype="multipart/form-data">
                                <legend><h4>Περίοδος Εξεταστικής</h4></legend>
                                <hr>
								 <div>
                                    <label>Από</label>
									<div  class="search-box">
										<input type="date" name="start" required autocomplete="off" id="start">
										<div class="result"></div>
									</div>
									<label>Έως</label>
									<div  class="search-box">
										<input type="date" name="end" required autocomplete="off" id="end">
										<div class="result"></div>
									</div>
								<br>
								</div>
								<div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="update"><span>Αποθήκευση</button>
										<a href="exam_calendar.php" class="btn btn-danger" >Πίσω</a>
                                </div>
</form>
 <footer>
 $footer
    <script type="text/javascript"language="javascript">  
$(function(){
	var start = document.getElementById('start');
	var end = document.getElementById('end');
	start.addEventListener('change', function() {
    if (start.value)
        end.min = start.value;
	}, false);
	end.addEventLiseter('change', function() {
    if (end.value)
        start.max = end.value;
	}, false);
}); 
    </script>
</body>
EOF;
echo $editHTML;
?>