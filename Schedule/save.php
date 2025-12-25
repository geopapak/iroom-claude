<?php
session_start();
require_once('../connectDB.php');
    $sql="SELECT * FROM programme WHERE ID_departament=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['user_dp'],PDO::PARAM_STR);
    $stmt-> execute();
    $ID_schedule=$_POST['schedule'];
    while($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $ID_semester_course=$row->ID_semester_course;
        $ID_day=$row->ID_day;
        $ID_hour=$row->ID_hour;
        $ID_user=$row->ID_user;
        $ID_departament=$row->ID_departament;
        $sql="SELECT * FROM programme_history WHERE ID_semester_course=:ID_semester_course AND ID_day=:ID_day AND ID_hour=:ID_hour AND ID_user=:ID_user AND ID_schedule=:ID_schedule AND ID_departament=:ID_departament AND type=:type";
        $stmt2 = $dbh->prepare($sql);  
        $stmt2->bindParam(':ID_semester_course',$ID_semester_course,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_day',$ID_day,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_hour',$ID_hour,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_user',$ID_user,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
        $stmt2->bindParam(':type',$_POST['type'],PDO::PARAM_STR);
        $stmt2-> execute();
        $row2 = $stmt2->fetch(PDO::FETCH_OBJ);
        $num=$stmt2->rowCount();
        if($num>0){
            $ID=$row2->ID;
            $ID_semester_course1=$row2->ID_semester_course;
            $ID_day1=$row2->ID_day;
            $ID_hour1=$row2->ID_hour;
            $ID_user1=$row2->ID_user;
            $ID_schedule1=$row2->ID_schedule;
            $ID_departament1=$row2->ID_departament;
            $type1=$row2->type;
        }else{
            $ID='';
            $ID_semester_course1='';
            $ID_day1='';
            $ID_hour1='';
            $ID_user1='';
            $ID_schedule1='';
            $ID_departament1='';
            $type1='';           
        }

        if($ID_semester_course==$ID_semester_course1 AND $ID_day==$ID_day1 AND $ID_hour==$ID_hour1 AND $ID_user==$ID_user1 AND $ID_schedule==$ID_schedule1 AND $ID_departament==$ID_departament1 AND $type1==$_POST['type'] ){
            $sql7 = "UPDATE programme_history SET ID_semester_course=:ID_semester_course, ID_day=:ID_day,ID_hour=:ID_hour,ID_user=:ID_user,ID_schedule=:ID_schedule,ID_departament=:ID_departament, type=:type WHERE  ID=:id";
            $stmt1 = $dbh->prepare($sql7);  
            $stmt1->bindParam(':ID_semester_course',$ID_semester_course,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_day',$ID_day,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_hour',$ID_hour,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_user',$ID_user,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
            $stmt1->bindParam(':type',$_POST['type'],PDO::PARAM_STR);
            $stmt1->bindParam(':id',$ID,PDO::PARAM_INT);
            $res=$stmt1-> execute();         
        }else{
            $sql="INSERT INTO programme_history (ID_semester_course, ID_day, ID_hour,ID_user,ID_schedule,ID_departament,type) VALUES (:ID_semester_course,:ID_day,:ID_hour,:ID_user,:ID_schedule,:ID_departament,:type)";
            $stmt1 = $dbh->prepare($sql);
            $stmt1->bindParam(':ID_semester_course',$ID_semester_course,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_day',$ID_day,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_hour',$ID_hour,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_user',$ID_user,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
            $stmt1->bindParam(':type',$_POST['type'],PDO::PARAM_STR);
            $res1=$stmt1-> execute();        
        }
    }


    $sql="SELECT * FROM programme_rooms WHERE ID_departament=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['user_dp'],PDO::PARAM_STR);
    $stmt-> execute();
    $ID_schedule=$_POST['schedule'];
    while($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $ID_day_hour=$row->ID_day_hour;
        $ID_room=$row->ID_room;
        $ID_course=$row->ID_course;
        $ID_departament=$row->ID_departament;
        $sql="SELECT * FROM programme_rooms_history WHERE ID_day_hour=:ID_day_hour AND ID_room=:ID_room AND ID_course=:ID_course AND ID_schedule=:ID_schedule AND ID_departament=:ID_departament";
        $stmt2 = $dbh->prepare($sql);  
        $stmt2->bindParam(':ID_day_hour',$ID_day_hour,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_room',$ID_room,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_course',$ID_course,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
        $stmt2->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
        $stmt2-> execute();
        $row2 = $stmt2->fetch(PDO::FETCH_OBJ);
        $num=$stmt2->rowCount();
        if($num>0){
            $ID=$row2->ID;
            $ID_room1=$row2->ID_room;
            $ID_day_hour1=$row2->ID_day_hour;
            $ID_course1=$row2->ID_course;
            $ID_schedule1=$row2->ID_schedule;
            $ID_departament1=$row2->ID_departament;
        }else{
            $ID='';
            $ID_room1='';
            $ID_day_hour1='';
            $ID_course1='';
            $ID_schedule1='';
            $ID_departament1='';         
        }

        if($ID_room==$ID_room1 AND $ID_day_hour==$ID_day_hour1 AND $ID_course==$ID_course1 AND $ID_schedule==$ID_schedule1 AND $ID_departament==$ID_departament1){
            $sql7 = "UPDATE programme_rooms_history SET ID_day_hour=:ID_day_hour, ID_room=:ID_room,ID_course=:ID_course,ID_schedule=:ID_schedule,ID_departament=:ID_departament WHERE  ID=:id";
            $stmt1 = $dbh->prepare($sql7);  
            $stmt1->bindParam(':ID_day_hour',$ID_day_hour,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_room',$ID_room,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_course',$ID_course,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
            $stmt1->bindParam(':id',$ID,PDO::PARAM_INT);            
            $res=$stmt1-> execute();            
        }else{
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="INSERT INTO programme_rooms_history(ID_day_hour,ID_room,ID_course,ID_schedule,ID_departament) VALUES (:ID_day_hour,:ID_room,:ID_course,:ID_schedule,:ID_departament)";
            $stmt1 = $dbh->prepare($sql);
            $stmt1->bindParam(':ID_day_hour',$ID_day_hour,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_room',$ID_room,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_course',$ID_course,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_schedule',$ID_schedule,PDO::PARAM_STR);
            $stmt1->bindParam(':ID_departament',$ID_departament,PDO::PARAM_STR);
            $res1=$stmt1-> execute();     
        }
    }
    /*
    $sql="INSERT INTO programme_rooms_history (ID_day_hour, ID_room, active,ID_departament) SELECT ID_departament, ID_room, active,ID_departament FROM programme_rooms WHERE ID_departament=:id_depart";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_depart',$_SESSION['user_dp'],PDO::PARAM_STR);
    $stmt-> execute();
    */
$_SESSION['save']=1;
header('location: calendar.php');
?>