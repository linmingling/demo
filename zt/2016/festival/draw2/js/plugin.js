/**		
 * Created by        宝哥哥  2014.10.1		
 */		
function plugin(pluginName,designW,designH){	
    switch(pluginName){		
        case "scaleMode"://适配兼容扩展插件		
            LGlobal.fixedMode = "middle";		
            LStageScaleMode.FIXED_WIDTH  ="FixedWidth";		
            LStageScaleMode.FIXED_HEIGHT  ="FixedHeight";		
            LStageScaleMode.FIXED_MODE_TOP  ="top";		
            LStageScaleMode.FIXED_MODE_BOTTOM  ="bottom";		
            LStageScaleMode.FIXED_MODE_MIDDLE  ="middle";//居中		
            LStageScaleMode.FIXED_MODE_LEFT  ="left";		
            LStageScaleMode.FIXED_MODE_RIGHT  ="right";	
            LGlobal.cutOffsetY =0;	
            LGlobal.resize = function (canvasW, canvasH) {		
                var w, h, t = 0, l = 0, ww = window.innerWidth, wh = window.innerHeight;		
                var ch = document.documentElement.clientHeight;		
                var cw = document.documentElement.clientWidth;		
		
                if (canvasW) {		
                    w = canvasW;		
                }		
                if (canvasH) {		
                    h = canvasH;		
                }		
                if (LGlobal.stageScale == "noScale") {		
                    w = canvasW || LGlobal.width;		
                    h = canvasH || LGlobal.height;		
                }		
                switch (LGlobal.stageScale) {		
                    case "FixedWidth":	
                        w = canvasW || ww;	
                        h = canvasH || wh;	
                        var designWidth = designW;//设计尺寸宽度	
                        var designHeight =designH;//设计尺寸高度	
                        var gameWidth =designWidth;//CANVAS内容宽度	
                        var gameHeight = h * gameWidth / w;//CANVAS内容高度	
                        var raio = w/gameWidth;//缩放比例	
                        LGlobal.cutOffsetY = (designHeight - gameHeight) * raio;	
                        switch (LGlobal.fixedMode){	
                            case "top":	
                                break;	
                            case "bottom":	
                                LGlobal.stage.y-=LGlobal.cutOffsetY;	
                                break;	
                            case "middle":	
                                LGlobal.stage.y-=LGlobal.cutOffsetY>>1;	
                                break;	
                        }	
                        $(LGlobal.canvasObj).attr("width",gameWidth+"px");	
                        $(LGlobal.canvasObj).attr("height",gameHeight+"px");	
                        break;		
                    case "FixedHeight":		
                        h = wh;		
                        w = LGlobal.width*(h/LGlobal.height);		
                        var radius = LGlobal.radius = w/LGlobal.weight;		
                        switch (LGlobal.fixedMode){		
                            case "left":		
                                l=0;		
                                break;		
                            case "right":		
                                l=-(w-cw);		
                                break;		
                            case "middle":		
                                l=-((w-cw)/2);		
                                break;		
                        }		
                        LGlobal.cutOffsetY = 0;		
                        $("#legend > div").eq(0).css({overflow:"hidden",width:cw+"px"})		
                        break;		
                    case "exactFit":	
                        w = canvasW || ww;	
                        h = canvasH || wh;	
                        break;		
                    case "noBorder":		
                        w = canvasW || ww;		
                        h = canvasH || LGlobal.height*ww/LGlobal.width;		
                        switch (LGlobal.align) {		
                            case LStageAlign.BOTTOM:		
                            case LStageAlign.BOTTOM_LEFT:		
                            case LStageAlign.BOTTOM_RIGHT:		
                            case LStageAlign.BOTTOM_MIDDLE:		
                                t = wh - h;		
                                break;		
                        }		
                        break;		
                    case "showAll":		
                        if (ww / wh > LGlobal.width / LGlobal.height) {		
                            h = canvasH || wh;		
                            w = canvasW || LGlobal.width * wh / LGlobal.height;		
                        } else {		
                            w = canvasW || ww;		
                            h = canvasH || LGlobal.height * ww / LGlobal.width;		
                        }		
                    case "noScale":		
                    default:		
                        switch (LGlobal.align) {		
                            case LStageAlign.BOTTOM:		
                            case LStageAlign.BOTTOM_LEFT:		
                                t = wh - h;		
                                break;		
                            case LStageAlign.RIGHT:		
                            case LStageAlign.TOP_RIGHT:		
                                l = ww - w;		
                                break;		
                            case LStageAlign.TOP_MIDDLE:		
                                l = (ww - w) * 0.5;		
                                break;		
                            case LStageAlign.BOTTOM_RIGHT:		
                                t = wh - h;		
                                l = ww - w;		
                                break;		
                            case LStageAlign.BOTTOM_MIDDLE:		
                                t = wh - h;		
                                l = (ww - w) * 0.5;		
                                break;		
                            case LStageAlign.MIDDLE:		
                                t = (wh - h) * 0.5;		
                                l = (ww - w) * 0.5;		
                                break;		
                            case LStageAlign.TOP:		
                            case LStageAlign.LEFT:		
                            case LStageAlign.TOP_LEFT:		
                            default:		
                        }		
                }		
                LGlobal.canvasObj.style.marginTop = t + "px";		
                LGlobal.canvasObj.style.marginLeft = l + "px";		
                if (LGlobal.isFirefox) {		
                    LGlobal.left = parseInt(LGlobal.canvasObj.style.marginLeft);		
                    LGlobal.top = parseInt(LGlobal.canvasObj.style.marginTop);		
                }		
                LGlobal.ll_setStageSize(w, h);		
            };		
            break;		
    }		
		
		
    //传入设计偏移Y轴的值，返回实际偏移Y轴的值		
    LGlobal.getOffsetY = function(offsetY) {		
        return (offsetY-LGlobal.cutOffsetY)/LGlobal.radius;		
    }		
		
		
		
    LGlobal.getOsVerison = function() {		
        //获取用户代理		
        var ua = navigator.userAgent;		
        if (ua.indexOf("Windows NT 5.1") != -1) return "Windows XP";		
        if (ua.indexOf("Windows NT 6.0") != -1) return "Windows Vista";		
        if (ua.indexOf("Windows NT 6.1") != -1) return "Windows 7";		
        if (ua.indexOf("Windows NT 6.2") != -1) return "Windows 8";		
        if (ua.indexOf("iPhone") != -1){		
            //		
            var cw = document.documentElement.clientWidth;		
            var ch = document.documentElement.clientHeight;		
//            alert(cw+"  "+ch);		
//            alert(cw/ch);		
            if(cw/ch<0.65){		
                return "iphone5";		
            }else{		
                return "iphone4";		
            }		
        }		
        if (ua.indexOf("iPad") != -1) return "iPad";		
        if (ua.indexOf("Linux") != -1) {		
            var index = ua.indexOf("Android");		
            if (index != -1) {		
//os以及版本		
                var os = ua.slice(index, index+13);		
		
//手机型号		
                var index1 = ua.lastIndexOf(";");		
		
                var index2 = ua.indexOf("Build");		
                var type = ua.slice(index1+1, index2);		
                return type + os;		
            } else {		
                return "Linux";		
            }		
        }		
        return "未知操作系统";		
    }		
		
}		
		
	
