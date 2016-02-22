/**
 *@author borey
 *@date 2015/12/17
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */
var isSound=false;
$(".Btn_close").on("touchstart", onModuleHandler);
$("#Btn_rank").on("touchstart", onModuleHandler);
$("#Btn_go").on("touchstart", onModuleHandler);
$("#Btn_Fir").on("touchstart", onModuleHandler);
$("#Btn_Sec").on("touchstart", onModuleHandler);
$("#Btn_Thr").on("touchstart", onModuleHandler);
$("#Btn_Fou").on("touchstart", onModuleHandler);
$("#Btn_sound").on("touchstart", onModuleHandler);
function onModuleHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_close1":
            $("#" + $(e.currentTarget).attr("for")).fadeOut();
            break;
        case "Btn_close2":
            $("#" + $(e.currentTarget).attr("for")).fadeOut();
            break;
        case "Btn_rank":
            $("#RuleModule").fadeOut();
            $("#RankModule").fadeIn();
            clickRank(1);
            break;
        case "Btn_go":
            $("#RuleModule").fadeOut();
            window.setTimeout(onPlayHandler, 500);
            break;
        case "Btn_Fir":
            clickRank(1);
            break;
        case "Btn_Sec":
            clickRank(2);
            break;
        case "Btn_Thr":
            clickRank(3);
            break;
        case "Btn_Fou":
            clickRank(4);
            break;
        case "Btn_sound":
            if (isSound) {
                isSound = false;
                $("#Sound_bg")[0].pause();
                $("#Btn_sound").removeClass("SoundAni");
                $("#Btn_sound").attr({src: "images/Btn_sound2.png"});
            } else {
                isSound = true;
                $("#Sound_bg")[0].play();
                $("#Btn_sound").addClass("SoundAni");
                $("#Btn_sound").attr({src: "images/Btn_sound1.png"});
            }
            break;
    }
}

function onPostData() {
    //提交积分
    var _0x3dd1 = ["\x70\x61\x72\x73\x65", "\x55\x74\x66\x38", "\x65\x6E\x63", "\x32\x30\x31\x35\x30\x33\x31\x33\x35\x38\x34\x35\x32\x36\x39\x31", "\x65\x6E\x63\x72\x79\x70\x74", "\x41\x45\x53"];
    var md5_secret = CryptoJS.MD5(secret);
	
    var key = CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](md5_secret);
    var iv = CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](_0x3dd1[3]);
    var encrypted = CryptoJS[_0x3dd1[5]][_0x3dd1[4]](GameScore.toString(), key, {iv: iv});
    var scoreStr = encrypted.toString();

    $.ajax({
        async: false,
        url: 'server.php',
        data: {
            act: 'add',
            score: scoreStr
        },
        type: "post",
        dataType: 'json',
        success: function (result) {
            if (result.errcode != 0) {
                alert(result.errmsg);
            }
        },
        error: function (XMLHttpRequest) {
            if (XMLHttpRequest.readyState != '4') {
                alert("网络异常,分数提交失败");
                window.location.reload()
            }
        }
    });
}

// 点击查看排名
function clickRank(num) {
    $.ajax({
        async: false,
        url: 'server.php',
        data: {act: 'rank', per: num.toString()},
        type: "post",
        dataType: 'json',
        success: function (result) {
            var arr = result['paihang'];
            var htmlblock = '';
            if(arr.length>=1){
                for (var i = 0; i < arr.length; i++) {
                    htmlblock += '<div><li>' + arr[i]['mingci'] + '</li><li><div><img src="' + arr[i]['headimgurl'] + '"  alt=""/></div></li><li>' + arr[i]['wechaname'] + '</li><li>' + arr[i]['score'] + '分</li><div style="clear: both;"></div></div>';
                }
            }else{
                htmlblock='<p style="font-size: 50px;text-align: center">敬请期待!</p>';
            }
            $("#RankBox ul").html(htmlblock);
        },
        error: function (XMLHttpRequest) {
            if (XMLHttpRequest.readyState == '0') {
                alert("网络异常");
            }
        }
    });
}