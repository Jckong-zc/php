<?php
include("inc/config.php");


$res = $conn -> query('select * from fruit_name ');
// var_dump($res);
if($res->num_rows > 0){
    $content = $res->fetch_all(MYSQLI_ASSOC);
    // var_dump($content);
    echo json_encode($content,JSON_UNESCAPED_UNICODE);
}else{
    echo "没有满足条件的数据";
}
$res->close();
$conn->close();
?>