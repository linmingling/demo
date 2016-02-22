/**
 *@author borey
 *@QQ 475773037
 *@Explain Powered by lufyLegend
 *@homepage http://lufylegend.com/lufylegend
 */
$("#Btn_close").on("touchstart", onMenuHandler);
$("#Btn_rank2").on("touchstart", onMenuHandler);
$("#Btn_go").on("touchstart", onMenuHandler);
$("#Btn_close2").on("touchstart", onMenuHandler);
$("#Btn_first").on("touchstart", onMenuHandler);
$("#Btn_second").on("touchstart", onMenuHandler);
function onMenuHandler(e) {
    switch (e.currentTarget.id) {
        case "Btn_close":
            $("#RuleModule").hide();
            break;
        case "Btn_rank2":
            $("#RuleModule").hide();
            $("#RankModule").css({display: "-webkit-box"});
            clickRank(1);
            break;
        case "Btn_go":
            $("#RuleModule").hide();
            StageScene.removeAllChild();
            StageScene.addChild(new GameScene());
            break;
        case "Btn_close2":
            $("#RankModule").hide();
            break;
        case "Btn_first":
            clickRank(1);
            break;
        case "Btn_second":
            clickRank(2);
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
            console.log(result);
            if (result.errcode != 0) {
                alert(result.errmsg);
            }
            wxTitle = "恒洁卫浴-雷锋历险记，我玩到" + GameScore + "分啦，来挑战吧!";
            var wxData = {
                "imgUrl": wxImgUrl,
                "link": wxLink,
                "desc": wxDesc,
                "title": wxTitle,
                success: function () {
                }
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
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
            if(arr.length>1){
                for (var i = 0; i < arr.length; i++) {
                    htmlblock += '<div><li>' + arr[i]['mingci'] + '</li><li><div><img src="' + arr[i]['headimgurl'] + '"  alt=""/></div></li><li>' + arr[i]['wechaname'] + '</li><li>' + arr[i]['score'] + '分</li><div style="clear: both;"></div></div>';
                }
            }else{
                htmlblock='<div>敬请期待!<div>';
            }
            $("#Mc_rank_content ul").html(htmlblock);
        },
        error: function (XMLHttpRequest) {
            if (XMLHttpRequest.readyState == '0') {
                alert("网络异常");
            }
        }
    });
}