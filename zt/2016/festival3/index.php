<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';

// 获取未中奖的人员
$mem_sql = "select wxInfo.head_icon,usInfo.user_id,usInfo.name,usInfo.row_num,usInfo.column_num,usInfo.company_nm from $fest_user as usInfo,$fest_weixin as wxInfo where wxInfo.user_id = usInfo.user_id and usInfo.is_prize=0 order by rand() limit 50";
$mem_res = mysqli_query($db, $mem_sql);

$tmp = array();
$i = 0;
$strJson = '';
$str = array();
$tmp_2 = null;
while ($row = $mem_res->fetch_assoc()) {
    $tmp = null;

    $tmp[$i]['id'] = $row['user_id'];
    $tmp[$i]['name'] = $row['name'];
    $tmp[$i]['src'] = $row['head_icon'];
    $tmp[$i]['company_nm'] = $row['company_nm'];

    $tmp_2[] = $row;

    $strJson .= '{"name":"' . $tmp[$i]['name'] . '","src":"' . $tmp[$i]['src'] . '","id":"' . $tmp[$i]['id'] . '","com_nm":"' . $tmp[$i]['company_nm'] . '"},';
    $str [] = $tmp;
    $i++;
}

//json字符串
$strJson = substr($strJson, 0, strlen($strJson) - 1);
$strJson = '[' . $strJson . ']';
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>2015腾讯优居年会一等奖</title>
    <style>
        body {
            background: black;
        }

        canvas {
            position: absolute;
            z-index: 2;
        }

        .stage_area {
            width: 900px;
            min-height: 100px;
            margin-left: auto;
            margin-right: auto;
            padding: 100px 50px;
            -webkit-perspective: 800px;
            -moz-perspective: 800px;
            perspective: 800px;
            -webkit-transition: top .5s;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -450px;
            margin-top: -150px;
            z-index: 3;
        }

        .container {
            width: 128px;
            height: 100px;
            margin-left: -64px;
            -webkit-transition: -webkit-transform 1s;
            -moz-transition: -moz-transform 1s;
            transition: transform 1s;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            transform-style: preserve-3d;
            position: absolute;
            left: 50%;
        }

        .piece {
            width: 40px;
            height: 50px;
            -webkit-transition: opacity 1s, -webkit-transform 1s;
            -moz-transition: opacity 1s, -moz-transform 1s;
            transition: opacity 1s, transform 1s;
            position: absolute;
            bottom: 0;
        }

        .winner {
            top: 50%;
            margin-top: -1px;
            left: 50%;
            position: absolute;
            z-index: 5;
            height: 2px;
            width: 2px;
            display: none;
        }

        .winner_txt {
            position: absolute;
            margin-top: 210px;
            font-family: "Microsoft YaHei";
            font-size: 20px;
            text-align: center;
            width: 200px;
            line-height: 20px;
            color: white;
        }
    </style>
    <script src="js/jquery-1.7.2.min.js?v=1.0"></script>
    <script src="js/index.js?v=1.0"></script>
</head>
<body>
<div id="main">
    <div id="body" class="light">
        <div id="content" class="show">
            <div class="demo">
                <div id="stage" class="stage_area">
                    <div id="container" class="container" style="transform: rotateY(0deg);">
                    </div>
                </div>
                <canvas id="html5_3d_animation">Internet Explorer Not
                    Supported
                </canvas>
                <div id="show"></div>
                <div id="winer0" class="winner">
                    <div class="winner_txt"><span id="winer0_txt"></span></div>
                </div>
                <div id="winer1" class="winner">
                    <div class="winner_txt"><span id="winer1_txt"></span></div>
                </div>
                <div id="winer2" class="winner">
                    <div class="winner_txt"><span id="winer2_txt"></span></div>
                </div>
                <div class="title" style="background:url(images/test.png);width:237px;height:93px;position:absolute;left:50%;margin-left:-118px;top:50%;margin-top:-250px;z-index:10;">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        //初始化参数
        var w = document.body.offsetWidth;
        var h = document.body.offsetHeight;
        $("#html5_3d_animation").space3d({
            window_width: w,
            window_height: h,
            window_background: 'black',
            star_count: '500',
            star_color: 'white',
            star_depth: '100'
        });
        if (typeof window.screenX === "number") {
            // CSS transform变换应用
            transform = function (element, value, key) {
                key = key || "Transform";
                ["Moz", "O", "Ms", "Webkit", ""].forEach(function (prefix) {
                    element.style[prefix + key] = value;
                });
                return element;
            }
            // 浏览器选择器API
            , aa = function (selector) {
                return document.querySelector(selector);
            }, ab = function (selector) {
                return document.querySelectorAll(selector);
            };

            // 显示图片
            var imgArr = <?php echo json_encode($tmp_2);?>;
            var yongArr =<?php echo $strJson;?>;
            var htmlPic = '';
            var arrayPic = [];
            for (var i = 0; i
            < yongArr.length; i++) {
                arrayPic[i] = yongArr[i].id;
            }

            //获取图片转盘角度
            var rotate = 360 / arrayPic.length;

            //给转盘元素设置图片及id
            for (var i = 0; i
            < yongArr.length; i++) {
                htmlPic = htmlPic + '<img id="piece' + yongArr[i].id + '" src="' + yongArr[i].src + '" class="piece" />';
            }

            // 元素stage
            var eleStage = aa("#stage"), eleContainer = aa("#container"), indexPiece = 0;
            // 元素piece参数设置，设置transZ值
            var elePics = ab(".piece"), transZ = 30 / Math.tan((rotate / 2 / 180) * Math.PI);

            eleContainer.innerHTML = htmlPic;

            var click_flag = 1;//点击flag，如果为0则点击事件不执行

            //点击事件
            document.addEventListener("click", function () {
                if (click_flag == 1) {
                    var imgList = document.getElementById("container").getElementsByTagName("img");
                    //转盘动画（周长收缩）
                    for (var i = 0; i < imgList.length; i++) {
                        imgList[i].style.webkitTransform = "rotateY(" + rotateArr[i] + "deg) translateZ(0)"
                    }
                    //转盘动画（图片变小）
                    setTimeout(function () {
                        $('#container img').animate({
                            height: '-=200px',
                            width: '-=300px',
                            opacity: '0'
                        }, 900)
                    }, 400)
                    //ajax请求数据
                    var str_img_data = JSON.stringify(imgArr);
                    $.ajax({
                        async: false,
                        url: 'draw.php',
                        data: {
                            act: 'draw2',
                            arrInfo: str_img_data,
                            priNum: 3,
                            priRank: "一等奖"
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function (result) {
                            if (result.errcode == 0) {
                                jsonData = eval("(" + result.str + ")");
                                for (var i = 0; i < 3; i++) {
                                    Wname[i] = jsonData[i].name;
                                    imgUrl[i] = jsonData[i].src;
                                }

                                setTimeout(function () {//延迟待转盘动画结束将转盘删除
                                    document.getElementById("container").innerHTML = "";
                                    end();
                                }, 900);

                            }
                            click_flag = 0;//将点击flag设置成0
                        },
                        error: function (XMLHttpRequest) {
                            if (XMLHttpRequest.readyState != '4') {
                                alert("网络异常,请稍后重试");
                            }
                        }
                    });
                }
            });
            
            //旋转速度
            setInterval(function () {
                transform(aa('#container'), "rotateY(" + (-0.1 * rotate * ++indexPiece) + "deg)");
            }, 100);

            //转盘图片矩阵
            var rotateArr = [];//
            arrayPic.forEach(function (i, j) {
                rotateArr.push(j * rotate)
                transform(aa("#piece" + i), "rotateY(" + j * rotate + "deg) translateZ(" + (transZ + 20) + "px)");
            });
        }
    })();

    var Wname = [];
    var imgUrl = [];
    function end() {//设置结束显示中奖人信息
        for (var i = 0; i < 3; i++) {
            $('#winer' + i).css("background", "url(" + imgUrl[i] + ") center center");
            $('#winer' + i).css("background-size", "200px 100%");
            $('#winer' + i + "_txt").html(Wname[i]);
            $('#winer' + i).css("display", "block");
        }
        $('#winer0').animate({
            height: '200px',
            width: '200px',
            marginLeft: '-420px',
            marginTop: '-100px'
        }, 500)
        $('#winer1').animate({
            height: '200px',
            width: '200px',
            marginLeft: '-100px',
            marginTop: '-100px'
        }, 500)
        $('#winer2').animate({
            height: '200px',
            width: '200px',
            marginLeft: '220px',
            marginTop: '-100px'
        }, 500)
    }
</script>
</body>
</html>