<?php

require_once('../include/conn.php');

$mysqli = new mysqli($server_name,$username,$password,$db_name);
if($mysqli->connect_error != 0 ){
    echo $mysqli->connect_error;
    exit();
}

$sql = "SELECT
studentProfile.student_ID,
studentProfile.student_name,
class.class_name,
department.department_name,
grade.grade_level,
qrcode.qrcode_ing,
studentStatus.status_ing,
transportation.transportation_name
FROM
studentProfile,
class,
department,
grade,
qrcode,
studentStatus,
transportation
WHERE
studentProfile.class_ID = class.class_ID AND 
studentProfile.department_ID = department.department_ID AND 
studentProfile.grade_ID = grade.grade_ID AND 
studentProfile.qrcode_ID = qrcode.qrcode_ID AND 
studentProfile.status_ID = studentStatus.status_ID AND 
studentProfile.transportation_ID = transportation.transportation_ID;";


$result = $mysqli->query($sql);

while($student = $result->fetch_assoc()){
    $students[] = $student;
}
echo json_encode($students);

?>
