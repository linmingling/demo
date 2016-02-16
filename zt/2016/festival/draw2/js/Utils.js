function aabb(a,b){				
    if(a.x>b.x+b.width||b.x>a.x+a.width||a.y>b.y+b.height||b.y>a.y+a.height){				
        return false;				
    }else{				
        return true;				
    }				
}				
changeBitmap = function (sprite,name) {				
    sprite.removeAllChild();					
    sprite.addChild(new LBitmap(new LBitmapData(name)));					
}					
function getRandom(maxSize) {					
    return Math.floor(Math.random() * maxSize) % maxSize;					
}					
function setImage(sprite,imageName,x,y,alpha) {				
    var image=new LBitmap(new LBitmapData(dataList[imageName]));				
    image.name=imageName;					
    image.x=x;					
    image.y=y;				
    if(alpha){				
    alpha=parseFloat(alpha).toFixed(2);				
    if(alpha<1){				
    	image.alpha=alpha;				
    }				
    }					
    sprite.addChild(image);					
    return image;					
}					
function setBitmap(sprite,bitmap,x,y) {				
    bitmap.y=y;			
    bitmap.x=x;			
    sprite.addChild(bitmap);			
    return bitmap;				
}				
function setButton(sprite,imageName,x,y) {				
    var image=new LBitmap(new LBitmapData(dataList[imageName]));					
    image.x=x;						
    image.y=y;				
    var sp=new LSprite();				
    sp.addChild(image);		
    sprite.addChild(sp);						
    return sp;				
}					
function setBg(sprite,color,x,y,width,height,alpha) {					
    var backLayer = new LShape();				
    sprite.addChild(backLayer);					
    backLayer.graphics.drawRect(2,color,[x,y,width,height],true,color);					
    if(alpha){				
    alpha=parseFloat(alpha).toFixed(2);				
    if(alpha<1){				
    	backLayer.alpha=alpha;				
    }				
    }				
    return backLayer;					
}					
function setText(sprite,text,size,color,x,y) {					
    var txtPrize = new LTextField();					
    txtPrize.text = text;					
    txtPrize.size = size;					
    txtPrize.color = color;					
    txtPrize.x=x;					
    txtPrize.y=y;					
    sprite.addChild(txtPrize);					
    return txtPrize;					
}			
function replaceLayer(srcSprite,destSprite,isClear) {			
    if(isClear){			
        stageLayer.removeAllChild();			
        stageLayer.addChild(destSprite);			
    }else{			
        srcSprite.addChild(destSprite);			
    }			
}			
function removeObj(arr,index) {		
    var temp=new Array();		
    for(var  i in arr){		
        if(i!=index){		
            temp.push(arr[i])		
        }		
    }		
    return temp;		
}		
function setTextCenter(sprite,text,size,color,x,y,width,height) {		
    var txtPrize = new LTextField();				
    txtPrize.text = text;				
    txtPrize.size = size;				
    txtPrize.color = color;				
    txtPrize.x=x+width/2;				
    txtPrize.y=y;				
    txtPrize.weight="bolder";				
    txtPrize.textAlign="center";				
    sprite.addChild(txtPrize);				
    return txtPrize;				
}		
function ranNum(min, max) {	
	return Math.floor(Math.random() * (max - min + 1) + min);	
};	
			
					
