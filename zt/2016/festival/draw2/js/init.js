/**			
 * Created by Administrator on 14-8-4.			
 */		
var engine_url="./libs/";		
var js_url="./js/";		
var images_url="./images/";		
//定义加载JS文件数组		
var jsArr =[		
		engine_url+"lufylegend-1.9.9.min.js",
	js_url+"bg.js",
	js_url+"init.js",
	js_url+"jquery-2.1.js",
	js_url+"Main.js",
	js_url+"plugin.js",
	js_url+"sha1.js",
	js_url+"Utils.js"		
		//js_url+"chou.min.js"		
];		
		
//定义游戏引擎类型		
Lufylegend_engine = "lufylegend";		
CreateJs_engine = "createJs";		
		
//定义当前游戏引擎类型		
Engine_type = Lufylegend_engine;		
		
//URL参数名称定义		
URL_id = "id";		
URL_uid = "uid";		
URL_lid = "lid";		
		
//接口名称定义		
API_leaderboard_update= "leaderboard_update";		
API_leaderboard_get = "leaderboard_get";		
API_lottery_dolottery = "lottery_dolottery";		
API_lottery_get = "lottery_get";		
API_game_json = "game_json";		
		
		
		
//地址栏获取参数		
var url_id = getQueryString(URL_id);		
var url_uid = getQueryString(URL_uid);		
var url_lid = getQueryString(URL_lid);		
		
var next_url = "";		
var gameData={};//游戏的所有信息		
var loadData=[];//加载的图片数组		
		
$(function() {		
    //获取游戏加载数据		
    getGameJson(Engine_type);		
    gameData.loading_icon = "./images/loading.png";		
    gameData.loading_bg_color = "#FFFFFF";		
    gameData.loading_text_color = "#fff";		
    //指定容器添加canvas		
    var body= '<div style="text-align: center"><div class="dialog" id="loading"><div style="text-align: center"><div><img src="'+gameData.loading_icon+'"></div><div class="txt" id="txt" style="color:'+gameData.loading_text_color+'">0%</div></div></div><div id="legend"></div></body>';		
    var container = $("#pangtang_game_content").length>0?$("#pangtang_game_content"):$("body");			
    container.append(body);			
    container.addClass("bodycss");			
			
    //头部要引入的JS文件			
    var head_js = '' +			
        '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">' +			
        '<style>body, canvas, div {-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;-khtml-user-select: none;-webkit-tap-highlight-color: rgba(0, 0, 0, 0);}.bodycss{margin: 0;overflow: hidden;background-color: #5a7d8c}</style>'+		
        '<style>' +			
        '.dialog{position:absolute;-webkit-transform: scale(0.8);height: 160px;width: 240px;left:50%;top:50%;margin-top: -80px;margin-left: -120px; }.dialog .txt{font-size: 30px;color: #fff;}'+'</style>';			
    $("head").append(head_js);		
    loadJs(jsArr,"startGame");		
});		
//动态加载JS文件		
function loadJs(jsArr,callback,loadedNumber){		
    loadedNumber = typeof loadedNumber!="undefined"?loadedNumber:0;		
    var script = document.createElement("script");		
    script.onload = script.onreadystatechange = function(){		
		
        if(  ! this.readyState//这是FF的判断语句，因为ff下没有readyState这人值，IE的readyState肯定有值		
		
            || this.readyState=='loaded' || this.readyState=='complete'   // 这是IE的判断语句		
		
            ){		
            loadedNumber++;		
            if(loadedNumber==jsArr.length){		
                eval(callback+"()");		
            }else{		
                loadJs(jsArr,callback,loadedNumber);		
            }		
		
        }		
		
    };		
    script.src = jsArr[loadedNumber];		
    script.type = "text/javascript";		
    document.querySelector('head').appendChild(script);		
		
}		
//获取地址栏参数		
function getQueryString(name) {		
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");		
    var r = window.location.search.substr(1).match(reg);		
    if (r != null) return unescape(r[2]); return null;		
}		
//获取接口地址		
function getAPI(name){		
    var api_url="http://www.pangtang.com.cn/";		
		
    switch(name){		
        case API_leaderboard_update://提交分数		
            api_url+="leaderboard/update?id="+url_id+"&uid="+url_uid+"&lid="+url_lid+"&time="+(new Date()).valueOf();		
            break;		
        case API_leaderboard_get://获取排行榜		
            api_url+="leaderboard/get?id="+url_id+"&uid="+url_uid+"&lid="+url_lid+"&time="+(new Date()).valueOf();		
            break;		
        case API_lottery_dolottery://抽奖		
            api_url+="lottery/dolottery?id="+url_id+"&uid="+url_uid+"&lid="+url_lid+"&time="+(new Date()).valueOf();		
            break;		
        case API_lottery_get://获取抽奖的奖品数据		
            api_url+="lottery/get?id="+url_id+"&uid="+url_uid+"&lid="+url_lid+"&time="+(new Date()).valueOf();		
            break;		
        case API_game_json://获取游戏加载素材JSON		
            api_url +="letgo/game/json?id="+url_id+"&uid="+url_uid+"&lid="+url_lid+"&time="+(new Date()).valueOf();		
            break;		
    }		
    return api_url ?  api_url: false;		
}		
		
//获取游戏数据		
function getGameJson(engine_type) {		
    $.ajax({		
        url: getAPI(API_game_json),		
        data: "",		
        success: function (data) {		
            gameData = data;		
            next_url = data.lottery_url ? data.lottery_url : "";		
            next_url = next_url ? next_url : data.forms_url;		
            for (var item in data.json) {		
                switch (engine_type) {		
                    case Lufylegend_engine:		
                        loadData.push({name: data.json[item].name, path: data.json[item].path});		
                        break;		
                    case CreateJs_engine:		
                        loadData.push({id: data.json[item].name, src: data.json[item].path});		
                        break;		
                }		
            }		
        },		
        async: false,		
        dataType: "json",		
        error: function (XMLHttpRequest, textStatus, errorThrown) {		
            console.log(textStatus);		
            console.log(errorThrown);		
        }		
    });		
}		
