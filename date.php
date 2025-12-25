<?php
/*$monday = strtotime("last monday");
$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
 
$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
 
$this_week_sd = date("Y-m-d",$monday);
$this_week_ed = date("Y-m-d",$sunday);
 
echo "Current week range from $this_week_sd to $this_week_ed ";
*/
session_start();
require_once('connectDB.php');
try{
$daystart=$_POST['start'];
$dayend=$_POST['end'];
$begin = new DateTime($daystart);
$end = new DateTime($dayend);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
echo('<br>');
foreach ($period as $dt) {
	//echo('<br>');
    //echo $dt->format("l Y-m-d\n"); // H:i:s
    $date=$dt->format("l d-m\n");
    echo "$date";
    $sql= "INSERT INTO exam_days(name,ID_departament) VALUES (:name,:id_depart)";
    $stmt = $dbh->prepare($sql,array());
    $stmt -> execute(array(':name'=>$date,':id_depart'=>$_SESSION['user_dp']));
    if ($stmt){
    $_SESSION['date']=1;
	   header('Location:Schedule/exam_calendar.php');
    }else{
        $_SESSION['date']=2;
	   header('Location:Schedule/exam_calendar.php');
    }
}
}catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>