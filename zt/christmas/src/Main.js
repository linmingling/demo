/**
 * @author anlun214 QQ:58529016
 */

onAppRun();
/**
 * 程序入口
 */
function onAppRun(){
    LGlobal.designWidth = 640;
    LGlobal.designHeight = 1008;
    LGlobal.stageScale=LStageScaleMode.SHOW_ALL;
    LGlobal.align=LStageAlign.MIDDLE;
    init(33, "game", LGlobal.screenWidth, LGlobal.screenHeight, main);
}
function main(){
    LGlobal.updateFullScreen();
    /*
     LMouseEventContainer是一个鼠标事件监听器的容器，一般的鼠标事件监听需要遍历所有的可视对象，
     对程序消耗是比较大的，使用LMouseEventContainer后，鼠标监听对象变为只监听加载了鼠标事件的对象，
     可以大幅度提升鼠标事件监听的效率，但是，缺点是无法使用显示对象对鼠标事件进行遮挡。
     */
    LMouseEventContainer.set(LMouseEvent.MOUSE_MOVE,true);
    Flash2x.loadScene("christmas",null,function(){document.getElementById("Loading").style.display="none";LGlobal.stage.addChild(new christmas.Christmas())});
}
