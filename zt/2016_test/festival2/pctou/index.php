<?
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../../data/config.php');
$_SESSION['swith_sign'] = '0';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>投票页面</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="contant">
        <ul class="ticket">
            <li class="one"><span class="onemath">0票</span></li>
            <li class="two"><span class="twomath">0票</span></li>
            <li class="three"><span class="threemath">0票</span></li>
        </ul>
        <ol class="company">
            <li>家居</li>
            <li>优居</li>
            <li>OMG</li>
        </ol>
        <input type="button" value="开始" class="btn" />
    </div>
    
    <div class="contant2">
        <ul class="ticket2">
            <li class="one2"><span class="onemath2">0票</span></li>
            <li class="two2"><span class="twomath2">0票</span></li>
            <li class="three2"><span class="threemath2">0票</span></li>
        </ul>
        <ol class="company2">
            <li>家居</li>
            <li>优居</li>
            <li>OMG</li>
        </ol>
</body>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>

