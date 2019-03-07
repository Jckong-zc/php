<?php
include("inc/config.php");
$jxbtn = isset($_GET["jxbtn"])?$_GET["jxbtn"]:null;


$res = $conn -> query('select * from fruit_name ');

if($res->num_rows > 0){
    $content = $res->fetch_all(MYSQLI_ASSOC);
    $content = json_encode($content,JSON_UNESCAPED_UNICODE);
    $content = json_decode($content,true);
    $len = count($content);
    echo json_encode($content,JSON_UNESCAPED_UNICODE);
}else{
    echo "没有满足条件的数据";
}
$res->close();
$conn->close();
   
?>