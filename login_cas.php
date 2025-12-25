<?php
  include_once('CAS.php');	
  include_once('cas_config.php');
  require_once('connectDB.php');
  include 'Global/email.php';
  phpCAS::client($cas_protocol, $cas_sso_server,$cas_port, '');
  phpCAS::setCasServerCACert($cas_cert); 	
  phpCAS::handleLogoutRequests(true , array($cas_sso_server));
  phpCAS::forceAuthentication();

  	foreach (phpCAS::getAttributes() as $key => $value) {
      	if (is_array($value)) {
        	foreach ($value as $item) {
				if($key=='sn'){
                 	$keysn=true;
                 	$_SESSION["valuesn"]=$value[0];
				}else if($key=='givenName'){
					$keyname=true;
					$_SESSION["valuename"]=$value[0];
				}
       		}
    	} else {
		    if($key=='uid'){
				$keypid=true;
				$_SESSION["valuepid"]=$value;
            }else if($key=='mail'){
				$keymail=true;
				$_SESSION["valuemail"]=$value;
            }else if($key=='schGrAcEnrollment'){
				$keyschGrAcEnrollment=true;
				$valueschGrAcEnrollment=$value;
				$tmp=explode(':',$valueschGrAcEnrollment);
				$depid=$tmp[9];
				$_SESSION["valueedu"]=$depid;
            }else if($key=='schacPersonalPosition'){
				$keyschacPersonalPosition=true;
				$valuesschacPersonalPosition=$value;
				$tmp=explode(':',$valuesschacPersonalPosition);
				$depid=$tmp[9];
				$_SESSION["valueedu"]=$depid;
            }else if($key=='eduPersonAffiliation'){
				$keyname=true;
				$_SESSION["valueeduPersonAffiliation"]=$value;
            }
      	}
    }
	
	$_POST['Username'] = $_SESSION["valuemail"];
	
	$sql="SELECT * FROM users WHERE email=:email";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':email',$_SESSION["valuemail"],PDO::PARAM_STR);
	$stmt->execute();       
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count=$stmt->rowCount();   
	$num_get_rows = $stmt->fetchColumn();

	if($count==0){
		$sql="SELECT * FROM departament WHERE sso_depart=:sso_depart";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':sso_depart',$_SESSION["valueedu"],PDO::PARAM_STR);
		$stmt->execute();
		$num_get_rows = $stmt->rowCount();  
		if($num_get_rows==0){
			echo("Δεν έχει καταχωρηθεί το τμήμα με κωδικό.");
			var_dump($_SESSION['valueedu']);
		}else{
			$row=($stmt ->fetch(PDO::FETCH_OBJ));
			$ID_departament= $row -> ID;
			
			if($_SESSION["valueeduPersonAffiliation"]=="student"){
				$user_type="Φοιτητης";
			}elseif ($_SESSION["valueeduPersonAffiliation"]=="faculty"){
				$user_type="Καθηγητής";
			}
		
			$phone=0;
			
	        $sql= "INSERT INTO users(name, last_name,phone,email,ID_departament,user_type,sso_id) VALUES (:name,:last_name,:phone,:email,:ID_departament,:user_type,:sso_id)";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':name', $_SESSION["valuename"], PDO::PARAM_STR);       
			$stmt->bindParam(':last_name',$_SESSION["valuesn"], PDO::PARAM_STR); 
			$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindParam(':email', $_SESSION["valuemail"], PDO::PARAM_STR); 
			$stmt->bindParam(':ID_departament', $ID_departament, PDO::PARAM_STR);   
			$stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);   
			$stmt->bindParam(':sso_id', $_SESSION["valuepid"], PDO::PARAM_STR);
			//$stmt->execute();   
			if ($stmt -> execute()){
				$last_id = $dbh->lastInsertId();
				$pass = rand();
				$password = password_hash($pass, PASSWORD_BCRYPT );
				$sql= "INSERT INTO password(ID_user,pass) VALUES (:id_user,:pass)";
    			$stmt = $dbh->prepare($sql,array());
    			$stmt -> execute(array(':id_user'=>$last_id,  ':pass'=>$password));
    			$email=sent_email($_SESSION["valuename"],$_SESSION["valuesn"],$_SESSION["valuemail"],$pass); 
    		}
		}
			if($_SESSION["valueeduPersonAffiliation"]=="student"){
				$_SESSION['user_id']=$_SESSION["valuemail"];
				$_SESSION['user_level']='Φοιτητης';
				header("Location: Schedule/calendar_student.php");
			}elseif($_SESSION["valueeduPersonAffiliation"]=="faculty"){
				$_SESSION['user_id']=$_SESSION["valuemail"];
				$_SESSION['user_level']='Καθηγητής';
				header("Location: Schedule/calendar_profesor.php");
			}else {
				header("Location: index.php");
			}
	}else {
		if($_SESSION["valueeduPersonAffiliation"]=="student"){
			$_SESSION['user_id']=$_SESSION["valuemail"];
			$_SESSION['user_level']='Φοιτητης';
			header("Location: Schedule/calendar_student.php");
		}elseif($_SESSION["valueeduPersonAffiliation"]=="faculty"){
			$_SESSION['user_id']=$_SESSION["valuemail"];
			$_SESSION['user_level']='Καθηγητής';
			header("Location: Schedule/calendar_profesor.php");
		}else {
			header("Location: index.php");
		}
	}
?>