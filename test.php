<?php
include("inc/config.php");

$jxbtn = isset($_GET["jxbtn"])?$_GET["jxbtn"]:null;
$qty = isset($_GET["qty"])? $_GET["qty"]: 10;
$currentPage = isset($_GET["currentPage"])? $_GET["currentPage"]: 1;
$res = $conn -> query('select * from fruit_name ');

if($jxbtn == "true"){   
   $res = $conn -> query('select * from fruit_name order by  price desc ');
} else if($jxbtn=="false"){
    $res = $conn -> query('select * from fruit_name order by  price asc ');
}
        


if($res->num_rows > 0){
$content = $res->fetch_all(MYSQLI_ASSOC);
$content = json_encode($content,JSON_UNESCAPED_UNICODE);
$content = json_decode($content,true);
$len = count($content);
$data = array_slice($content,($currentPage-1)*$qty,$qty);
$res = array(
        "data" => $data,
        "len" => $len,
        "qty" => $qty,
        "currentPage" => $currentPage
);
echo json_encode($res,JSON_UNESCAPED_UNICODE);
}
// $res->close();
// $conn->close();
    
   

?>