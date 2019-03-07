<?php
function save_file($content){
    if(is_array($content)){
        write_file(rand(100000,999999).'.txt',print_r($content,true));
    } else {
        write_file(rand(100000,999999).'.txt',$content);
    }
}
/**格式化输出数组
 * @param $array
 */
function dump($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

/**json格式化
 * @param $data
 * @param string $action
 * @return array|mixed
 */
function json_data($data, $action='encode'){
    if($action=='encode'){
        if(!function_exists('unidecode')){
            function unidecode($match){
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }
        }
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', json_encode($data));
    }else{
        return (array)json_decode($data, true);
    }
}

/**输出json
 * @param string $msg
 * @param int $ret
 */
function e_json($msg='', $ret=0){
    is_bool($ret) && $ret=$ret?1:0;
    exit(json_data(array(
            'msg'	=>	$msg,
            'ret'	=>	$ret
        )
    ));
}

function get_ext_name($filename=''){   //返回文件后辍名（小写）
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

function img_width_height($show_img_width, $show_img_height, $picpath, $echo_width_height=1){   //按比例缩小图片
    if(is_file($picpath)){
        $img_info   = getimagesize($picpath);
        $width      = $img_info[0];
        $height     = $img_info[1];

        if($width>$show_img_width){
            $ratio=$width/$show_img_width;
            $width=floor($width/$ratio);
            $height=floor($height/$ratio);
        }
        if($height>$show_img_height){
            $ratio=$height/$show_img_height;
            $width=floor($width/$ratio);
            $height=floor($height/$ratio);
        }
        if($echo_width_height==1){
            return "width='$width' height='$height'";
        }else{
            return array($width, $height);
        }
    }
    return '';
}

function js_location($url, $alert='', $top=''){
    if($alert=='' && $top==''){
        header("Location: $url");
        exit;
    }
    echo '<script language="javascript">';
    if($alert){
        echo 'alert(\''.($alert).'\');';
    }
    echo "window{$top}.location='$url';";
    echo '</script>';
    exit;
}

/**
返回类型：string
$un array
 */
function query_string($un=''){	//组织url参数
    !is_array($un) && $un=array($un);
    if($_SERVER['QUERY_STRING']){
        $q=@explode('&', $_SERVER['QUERY_STRING']);
        $v='';
        for($i=0; $i<count($q); $i++){
            $t=@explode('=', $q[$i]);
            if(in_array($t[0], $un)){
                continue;
            }
            $v.=$t[0].'='.urlencode(urldecode($t[1])).'&';
        }
        $v=substr($v, 0, -1);
        $v=='=' && $v='';
        return $v;
    }else{
        return '';
    }
}

/**字符截取
 * @param $str
 * @param $lenth
 * @param int $start
 * @return mixed
 */
function cut_str($str, $lenth, $start=0){	//剪切字符串
    $str=str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $str);
    $len=strlen($str);
    if($len<=$length){
        return str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $str);
    }
    $substr='';
    $n=$m=0;
    for($i=0; $i<$len; $i++){
        $x=substr($str, $i, 1);
        $a=base_convert(ord($x), 10, 2);
        $a=substr('00000000'.$a, -8);
        if($n<$start){
            if(substr($a, 0, 3)==110){
                $i+=1;
            }elseif(substr($a, 0, 4)==1110){
                $i+=2;
            }
            $n++;
        }else{
            if(substr($a, 0, 1)==0){
                $substr.=substr($str, $i, 1);
            }elseif(substr($a, 0, 3)==110){
                $substr.=substr($str, $i, 2);
                $i+=1;
            }elseif(substr($a, 0, 4)==1110){
                $substr.=substr($str, $i, 3);
                $i+=2;
            }else{
                $substr.='';
            }

            if(++$m>=$lenth){
                break;
            }
        }
    }
    return str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $substr);
}

/**获取ip地址
 * @return mixed
 */
function get_ip(){
    $CI =& get_instance();
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * 文本格式化
 */
function format_text($text){	//格式化文本
    $text=htmlspecialchars($text);
    $text=str_replace('  ', '&nbsp;&nbsp;', $text);
    $text=nl2br($text);
    return $text;
}

/**日期格式化
 * @param $date
 * @param string $type
 * @return bool|string
 */

function date_time($date,$type='Y-m-d H:i:s'){
    $date=date($type,$date);
    return $date;
}


function get_data($array,$obj=''){
    $data=array();
    foreach($array as $k=>$v){
        if(strstr($k,'-mod')){
            $filed=str_replace('-mod','',$k);
            $data[$filed]=$v;
        }
    }
    return $data;
}

?>