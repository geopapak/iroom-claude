<?php
session_start();
include ('../header.php'); 
include('../connectDB.php');
include ('../footer.php'); 
$editHTML=<<<EOF
<html>
<head>
<script src="../js/javascript_pass.js" rel="stylesheet" /></script>
</head>
<body>
$menu
<header>
  $head
</header>
 <div id="main"> 
 <span style="font-size:30px;cursor:pointer;" onclick="openNav();">&#9776; Menu</span>  
EOF;
echo $editHTML;
if(isset($_SESSION['message'])) { 
    echo "<div class='alert alert-success' role='alert'>"  ;
    echo "<span class='closebtn1' onclick='this.parentElement.style.display='none';'>&times;</span> ";
    $message = $_SESSION['message'];
    echo "$message</div>"; 
    unset($_SESSION['message'] );
}
$editHTML=<<<EOF
 <form method="post" class="form" action="password.php" onSubmit="return validatePassword()"  name="frmChange" enctype="multipart/form-data">
                                <legend><h4>Επεξεργασία</h4></legend>
                                <h4>Αλλαγή κωδικού</h4>
                                <hr>
                                <div>
                                    <label>Τωρινός κωδικός</label>
                                    <input type="password" name="currentPassword" class="txtField" autocomplete="on"/><span id="currentPassword" class="required"></span>
                                </div>  
                                <div>
                                    <label>Νέος κωδικός</label>
                                    <input type="password" name="newPassword" class="txtField" autocomplete="on"/><span id="newPassword" class="required"></span>
                                </div>
                                <div>
                                    <label>Επαλήθευση κωδικού</label>
                                    <input type="password" name="confirmPassword" class="txtField" autocomplete="on"/><span id="confirmPassword" class="required"></span>
                                </div>
                                 <div class="button">
                                        <button class="btn btn-info" style="vertical-align:middle" type="submit" name="submit" value="Submit"><span>Αποθήκευση</button>
                                </div>
                            </form>   
</div>                         
 <footer>
 $footer
 </footer>
</body>
</html>
EOF;
echo $editHTML;
?>