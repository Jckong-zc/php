<?php
include("inc/config.php");
include("inc/fun.php");

$mobile = isset($_GET["mobile"])?$_GET["mobile"]:null;
$txtpwd = isset($_GET["txtpwd"])?$_GET["txtpwd"]:null;
$register = isset($_GET["register"])?$_GET["register"]:null;
$uname = isset($_GET["uname"])?$_GET["uname"]:null;


//3.执行查询语句，得到查询结果集(对象)
$res = $conn->query('select * from uname where mobile="'.$mobile.'"');
// var_dump($res->num_rows);
if($res->num_rows > 0){
    echo "该用户名已被注册";
}else{
    if($register){
        // $res = $conn->query('insert into uname (mobile,txtpwd) values ("'.$mobile.'","'.$txtpwd.'")');
        $res = $conn->query('insert into uname (mobile,txtpwd,uname) values ("'.$mobile.'","'.$txtpwd.'","'.$uname.'")');
            // $res = $conn->query('insert into register (possword) values ('.$txtpwd.')');                
        if($res){
            echo "插入成功";
        }else{
            echo "插入失败";
        }
    }else{
        echo "该用户名可用";
    }
};
    echo json_encode($res,JSON_UNESCAPED_UNICODE);



?>