<?
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../../data/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>特等奖</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="contant">
        <!-- <div style="padding-top:20px;">
            <div class="one_people"> <span class="one_name"></span></div>
            <div class="two_people"><span class="two_name"></span></div>
            <div class="three_people"><span class="three_name"></span></div>
        </div> -->
        <ul class="ticket">
            <li class="one"  >
                <div></div>
                <span class="onemath"></span>
            </li>
            <li class="two"><span class="twomath"></span></li>
            <li class="three"><span class="threemath"></span></li>  
        </ul>
        <ol class="company">
            <li><span class="one_name name"></span></li>
            <li><span class="two_name name"></span></li>
            <li style="margin-top:-1px"><span class="three_name name"></span></li>
        </ol>
       <!--  <input type="button" value="开始" class="btn" /> -->
        <img  class="btn" src="images/Begin_03.png" alt="" />
        <div class="clock">5</div> 
        <div class="special">特等奖</div> 
         
        <!-- <input type="button" value="候选人" class="btn3" /> -->
        <img  class="btn3" src="images/houxuan_03.png" alt="" />
    </div>
    <div class="contant2">
        <ul class="ticket2">
            <li class="one2 math"><span class="onemath2"></span></li>
            <li class="two2 math"><span class="twomath2"></span></li>
            <li class="three2 math"><span class="threemath2"></span></li>
        </ul>
        <ol class="company2">
            <li><span class="one_name name"></span></li>
            <li><span class="two_name name"></span></li>
            <li style="margin-top:-1px name"><span class="three_name"></span></li>
        </ol>
        <div class="special">特等奖</div> 

    </div>
</body>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>

