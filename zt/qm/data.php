<?php
header("Content-type: text/html; charset=utf-8");
// $db = mysqli_connect("115.29.233.98","test360","yatai3.14159") or die("Error");
$db = mysqli_connect("121.40.146.108","test_user","test!@#") or die("Error");
//$db = mysqli_connect("localhost","root","") or die("Error");
mysqli_select_db($db, "qm");
$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

if(!empty($id)){
	$result ="SELECT * FROM qm_list WhERE id = ".$id;
	$re = mysqli_query($db, $result);
	while($list = mysqli_fetch_array($re)){
		$url_arr[] = $list;
	}

	$sql = "update qm_list set clicks = ".($url_arr[0]['clicks'] + 1)." where id=".$id;
	$url = mysqli_query($db, $sql);
	if($url){
		echo 1;exit;
	} else {
		echo 0;exit;
	}

} else {
	if(!json_encode($_GET['img_url'])){
		echo 2;exit;
	}
	$url = $_GET['img_url'];
	$filename = $_GET['filename'];
	$phone = trim($_GET['phone']);
	$time = json_encode(date('Y-m-d H:i:s',time()));

	$sql = "insert into qm_list(img_url, filename, phone, add_time) values('".$url."','".$filename."','".$phone."',".$time.")";
	//die($sql);
	$url = mysqli_query($db, $sql);
	if($url){
		echo 1;exit;
	} else {
		echo 0;exit;
	}
}
?>