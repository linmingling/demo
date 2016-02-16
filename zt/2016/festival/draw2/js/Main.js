var stageLayer;	
var dataList;	
var mfps = 60;	
var designWidth = $(window).width();	
var designHeight =  $(window).height();	
var gameHeight = designHeight;	
if (LGlobal.canTouch) {	
    gameHeight = $(window).height() * designWidth / $(window).width();	
}	
plugin("scaleMode", designWidth, designHeight);	
init(1000 / mfps, "legend", designWidth, gameHeight, main);	
//屏幕自适应	
	
function main() {	
    if (LGlobal.canTouch) {	
        LGlobal.stageScale = LStageScaleMode.FIXED_WIDTH;	
        LGlobal.fixedMode = LStageScaleMode.FIXED_MODE_BOTTOM;	
    } else {	
        LGlobal.stageScale = LStageScaleMode.SHOW_ALL;	
    }	
    LSystem.screen(LStage.FULL_SCREEN);	
    LMouseEventContainer.set(LMouseEvent.MOUSE_MOVE,true)	
    LLoadManage.load(loadData, function (progress) {	
//  	console.log(progress)
//      document.getElementById("loading_txt").innerHTML = progress + "%";	
    }, imgLoadComplete);	
}	
function imgLoadComplete(result){	
	dataList = result;	
	document.getElementById("loading").style.display =  "none";	
		
	stageLayer = new LSprite();	
	addChild(stageLayer);	
    stageLayer.addChild(new bg());	

}	
