<?php

require_once('../include/conn.php');


$mysqli = new mysqli($server_name,$username,$password,$db_name);
if($mysqli->connect_error != 0 ){
    echo $mysqli->connect_error;
    exit();
}

$sql = "SELECT
news.news_ID ,
news.news_title ,
news.news_date,
news.news_content,
unit.unit_name,
personnel.personnel_name
FROM
news AS news,
unit AS unit,
personnel AS personnel
WHERE
news.news_ID = unit.unit_ID AND news.news_ID = personnel.personnel_ID;";


$result = $mysqli->query($sql);

while($news = $result->fetch_assoc()){
    $newsData[] = $news;
}
echo json_encode($newsData);

?>