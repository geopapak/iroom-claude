<?php
/*
*
*
*Created by Giwrgos Papakis 614 
*
* Arxeio gia dhmiourgia tis db kai twn diaforwn pinakwn ka8ws kai tou logariasmou tou admin
*
*
*/
include 'errorReporting.php';
ini_set('display_errors',1);


// LOCAL DEVELOPMENT SETTINGS
// Update these for your local MySQL installation
$host = "localhost";  // or '127.0.0.1'

$user = 'root';        // Your MySQL username (typically 'root' for local dev)
$pass = '';            // Your MySQL password (leave empty if no password)
$dbname = 'iRoom';


try
{
 	// Using TCP connection for local development
 	$dbh = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
 	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 	$dbh->query('set character_set_client=utf8');
 	$dbh->query('set character_set_connection=utf8');
	$dbh->query('set character_set_results=utf8');
 	$dbh->query('set character_set_server=utf8');

 	

}catch(PDOException $e){
	die('Connection error:' . $e->getmessage()); 
}

 $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
 $dbh ->exec($sql);
 $sql = "use $dbname";
 $dbh->exec($sql);

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $sql = "CREATE TABLE IF NOT EXISTS days (
 ID int(10) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
 name varchar(50) NOT NULL
)";
 $dbh->exec($sql);

 $sql = "CREATE TABLE IF NOT EXISTS equipment (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL
)";
 $dbh->exec($sql);

 $sql = "CREATE TABLE IF NOT EXISTS hours (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  start_hour int(10) NOT NULL,
  end_hour int(10)NOT NULL
)";
$dbh->exec($sql);


$sql = "CREATE TABLE IF NOT EXISTS schedules (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(20) NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS semester (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(5) NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS university (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS exam_days (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS rooms (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL
)";
$dbh->exec($sql);

 $sql = "CREATE TABLE IF NOT EXISTS course (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL,
  year int(20) NOT NULL,
  code varchar(20) NOT NULL,
  optional enum('yes','no') NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS programme_rooms (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_day_hour int(10),
  ID_room int(10) NOT NULL,
  ID_course int(10),
  ID_departament int(10) NOT NULL,
  ID_schedule int(10) NOT NULL,
  INDEX (ID_room),
  INDEX (ID_course),
  INDEX (ID_departament),
  INDEX (ID_schedule),  
  FOREIGN KEY (ID_room) REFERENCES rooms (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_schedule) REFERENCES schedules (ID) ON UPDATE CASCADE ON DELETE CASCADE  
 )";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS programme_rooms_history (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_day_hour int(10),
  ID_room int(10) NOT NULL,
  ID_course int(10) NOT NULL,
  ID_schedule int(10) NOT NULL,
  INDEX (ID_room),
  INDEX (ID_course),
  INDEX (ID_schedule),
  FOREIGN KEY (ID_room) REFERENCES rooms (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_schedule) REFERENCES schedules (ID) ON UPDATE CASCADE ON DELETE CASCADE
 )";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS departament (
  ID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL,
  ID_university int(11) NOT NULL,
  sso_depart int(11) NOT NULL,
  INDEX (ID_university),
  FOREIGN KEY (ID_university) REFERENCES university (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
 $dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS users (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(25) NOT NULL,
  last_name varchar(25) NOT NULL,
  phone int(10) NOT NULL,
  email varchar(25) NOT NULL,
  ID_departament int(10) NOT NULL,
  user_type varchar(25) NOT NULL,
  sso_id varchar(255) NOT NULL,
  INDEX (ID_departament),
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS course_profesor (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_course int(10) NOT NULL,
  ID_profesor int(10) NOT NULL,
  ID_depart int(10) NOT NULL,
  INDEX (ID_course),
  INDEX (ID_profesor),
  INDEX (ID_depart),	
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_depart) REFERENCES departament (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_profesor) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
$dbh->exec($sql);

 $sql = "CREATE TABLE IF NOT EXISTS equipment_room(
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_rooms int(10) NOT NULL,
  ID_equipment int(10) NOT NULL,
  ID_departament int(11) NOT NULL,
  INDEX (ID_rooms),
  INDEX (ID_equipment),
  INDEX (ID_departament),
  FOREIGN KEY (ID_rooms) REFERENCES rooms (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_equipment) REFERENCES equipment (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
 $dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS semester_course (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_course int(11) NOT NULL,
  ID_semester int(11) NOT NULL,
  ID_depart int(11) NOT NULL,
  INDEX (ID_course),
  INDEX (ID_semester),
  INDEX (ID_depart),
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_depart) REFERENCES departament (ID) ON UPDATE CASCADE ON DELETE CASCADE,  
  FOREIGN KEY (ID_semester) REFERENCES semester (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS programme (   
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_semester_course int(10) NOT NULL,
  ID_day int(10) NOT NULL,
  ID_hour int(10) NOT NULL,
  ID_user int(10) NOT NULL,
  ID_schedule int(10) NOT NULL,
  INDEX (ID_semester_course),
  INDEX (ID_day),
  INDEX (ID_user),
  INDEX (ID_schedule),
  FOREIGN KEY (ID_semester_course) REFERENCES semester_course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_user) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_schedule) REFERENCES schedules (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_day) REFERENCES days (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS notification (   
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_user int(10) NOT NULL,
  ID_day_hour int(10) NOT NULL,
  ID_departament int(10) NOT NULL,
  ID_course int(10) NOT NULL,
  ID_room int(10)NOT NULL,
  subject varchar(250) NOT NULL,
  status int(10) NOT NULL
)";
$dbh->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS exam_programme (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_semester_course int(10) NOT NULL,
  ID_day int(10) NOT NULL,
  ID_hour int(10) NOT NULL,
  ID_user int(10) NOT NULL,
  ID_schedule int(10) NOT NULL,
  INDEX ID_semester_course (ID_semester_course),
  INDEX ID_day (ID_day),
  INDEX ID_user (ID_user),
  INDEX ID_schedule (ID_schedule),
  FOREIGN KEY (ID_semester_course) REFERENCES semester_course (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_user) REFERENCES users (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_schedule) REFERENCES schedules (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_day) REFERENCES exam_days (ID) ON DELETE CASCADE ON UPDATE CASCADE
  )";
  $dbh->exec($sql);
  
  $sql = "CREATE TABLE IF NOT EXISTS exam_programme_rooms (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_day_hour int(10) DEFAULT NULL,
  ID_room int(10) NOT NULL,
  ID_course int(10) DEFAULT NULL,
  active enum('active','inactive') NOT NULL,
  INDEX ID_room (ID_room),
  INDEX ID_course (ID_course),
  FOREIGN KEY (ID_room) REFERENCES rooms (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON DELETE CASCADE ON UPDATE CASCADE
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS my_course (
  ID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_user int(1) NOT NULL,
  ID_course int(1) NOT NULL,
  INDEX ID_user (ID_user),
  INDEX ID_course (ID_course),
  FOREIGN KEY (ID_user) REFERENCES users (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON DELETE CASCADE ON UPDATE CASCADE
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS type_user (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  type varchar(50) NOT NULL
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS admin (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  phone varchar(50) NOT NULL,
  email varchar(25) NOT NULL,
  user_type varchar(25) NOT NULL,
  pass varchar(25) NOT NULL
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS password (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_user int(10) NOT NULL,
  pass varchar(50) NOT NULL,
  INDEX ID_user (ID_user),
  FOREIGN KEY (ID_user) REFERENCES users (ID) ON DELETE CASCADE ON UPDATE CASCADE    
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS course_depart (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_course int(10) NOT NULL,
  ID_departament int(10) NOT NULL,
  INDEX (ID_course),
  INDEX (ID_departament),
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON DELETE CASCADE ON UPDATE CASCADE    
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS kateuthinsi (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  ID_department int(10) NOT NULL,
  INDEX (ID_department),
  FOREIGN KEY (ID_department) REFERENCES departament (ID) ON DELETE CASCADE ON UPDATE CASCADE 
  )";
  $dbh->exec($sql); 

  $sql = "CREATE TABLE IF NOT EXISTS course_kateuthinsi (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_course int(10) NOT NULL,
  ID_kat int(10) NOT NULL,
  ID_department int(10) NOT NULL,  
  INDEX (ID_course),
  INDEX (ID_kat),
  INDEX (ID_department),
  FOREIGN KEY (ID_course) REFERENCES course (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_department) REFERENCES departament (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_kat) REFERENCES kateuthinsi (ID) ON DELETE CASCADE ON UPDATE CASCADE   
  )";
  $dbh->exec($sql); 

  $sql = "CREATE TABLE IF NOT EXISTS admin_sem (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_department int(10) NOT NULL,
  ID_sem int(10) NOT NULL 
  )";
  $dbh->exec($sql); 

  $sql = "CREATE TABLE IF NOT EXISTS equipment_depart (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_equipment int(10) NOT NULL,
  ID_departament int(10) NOT NULL,  
  INDEX (ID_course),
  INDEX (ID_department),
  FOREIGN KEY (ID_equipment) REFERENCES equipment (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON DELETE CASCADE ON UPDATE CASCADE
  )";
  $dbh->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS programme_history (   
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_semester_course int(10) NOT NULL,
  ID_day int(10) NOT NULL,
  ID_hour int(10) NOT NULL,
  ID_user int(10) NOT NULL,
  ID_schedule int(10) NOT NULL,
  type varchar(10) NOT NULL,
  INDEX (ID_semester_course),
  INDEX (ID_day),
  INDEX (ID_user),
  INDEX (ID_schedule),
  FOREIGN KEY (ID_semester_course) REFERENCES semester_course (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_user) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_schedule) REFERENCES schedules (ID) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (ID_day) REFERENCES days (ID) ON UPDATE CASCADE ON DELETE CASCADE
)";
$dbh->exec($sql); 

  $sql = "CREATE TABLE IF NOT EXISTS room_depart (
  ID int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ID_room int(10) NOT NULL,
  ID_departament int(10) NOT NULL,  
  INDEX (ID_room),
  INDEX (ID_department),
  FOREIGN KEY (ID_room) REFERENCES rooms (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ID_departament) REFERENCES departament (ID) ON DELETE CASCADE ON UPDATE CASCADE
  )";
  $dbh->exec($sql);


  $sql = "INSERT INTO admin(name,last_name,phone,email,user_type,pass) VALUES ('admin','admin','123456789','admin@admin.gr','Διαχειριστής','admin')";
  $dbh->exec($sql);

  $sql = "INSERT INTO type_user(type) VALUES ('Γραμματεια'),('Φοιτητης'),('Καθηγητής')";
  $dbh->exec($sql); 
?>
