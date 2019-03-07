<?php
include("inc/config.php");
    $mobile = isset($_GET["mobile"])?$_GET["mobile"]:null;
    $txtpwd = isset($_GET["txtpwd"])?$_GET["txtpwd"]:null;
    $register = isset($_GET["register"])?$_GET["register"]:null;
 
    //3.执行查询语句，得到查询结果集(对象)
    $res = $conn->query('select * from uname where mobile="'.$mobile.'" and txtpwd="'.$txtpwd.'"');
    // $res = $conn->query('select * from uname where  mobile="13533729788" and uname="abc"'); 
   // var_dump($res->num_rows);
    if($res->num_rows > 0){
        echo "登录成功";
    }else {
        echo "登录失败";
    }
        

     // echo json_encode($res,JSON_UNESCAPED_UNICODE);



?>