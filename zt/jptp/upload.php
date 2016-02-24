<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$table = 'jptp';

if(empty($_SESSION['jptp_openid']))
{
    $ajax_result['errcode'] = 1000;
    $ajax_result['errmsg'] = "参数异常，请退出重试！";
    die(json_encode($ajax_result));
}

function image_png_size_add($imgsrc,$imgdst){ 
      list($width,$height,$type)=getimagesize($imgsrc); 
      $new_width = ($width>600?600:$width)*0.9; 
      $new_height =($height>600?600:$height)*0.9; 
      switch($type){ 
        case 1: 
          $giftype=check_gifcartoon($imgsrc); 
          if($giftype){ 
            header('Content-Type:image/gif'); 
            $image_wp=imagecreatetruecolor($new_width, $new_height); 
            $image = imagecreatefromgif($imgsrc); 
            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
            imagejpeg($image_wp, $imgdst,75); 
            imagedestroy($image_wp); 
          } 
          break; 
        case 2: 
          header('Content-Type:image/jpeg'); 
          $image_wp=imagecreatetruecolor($new_width, $new_height); 
          $image = imagecreatefromjpeg($imgsrc); 
          imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
          imagejpeg($image_wp, $imgdst,75); 
          imagedestroy($image_wp); 
          break; 
        case 3: 
          header('Content-Type:image/png'); 
          $image_wp=imagecreatetruecolor($new_width, $new_height); 
          $image = imagecreatefrompng($imgsrc); 
          imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
          imagejpeg($image_wp, $imgdst,75); 
          imagedestroy($image_wp); 
          break; 
      } 
      return true;
} 

function check_gifcartoon($image_file){ 
      $fp = fopen($image_file,'rb'); 
      $image_head = fread($fp,1024); 
      fclose($fp); 
      return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true; 
} 


$upload = isset($_FILES['fileToUpload'])?$_FILES['fileToUpload']:'';

$imgType = substr($upload["type"],6);
if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) 
{
    $ajax_result['errcode'] = 1003;
    $ajax_result['errmsg'] = "只能上传 jpeg png gif 格式图片！";
    die(json_encode($ajax_result));
}

$imgName = date('YmdHis').rand(100,999).".".$imgType;
move_uploaded_file($upload["tmp_name"],"uploads/img/".$imgName);

$sql = "update {$table} set imgurl='{$imgName}' where openid='" . $_SESSION['jptp_openid'] . "'";
mysqli_query($db, $sql);

image_png_size_add("uploads/img/".$imgName,'uploads/img/'.$imgName);

$ajax_result['errcode'] = 0;
$ajax_result['errmsg'] = "ok";
die(json_encode($ajax_result));



?>