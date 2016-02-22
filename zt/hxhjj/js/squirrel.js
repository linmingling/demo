(function(){
//声明松鼠
var Squirrel = game.Squirrel = function(props) {
	Squirrel.superClass.constructor.call(this, props);

	this.init();
};
Q.inherit(Squirrel, Q.DisplayObjectContainer);

Squirrel.prototype.init = function() {
	this.head = new Q.Bitmap({
		id : "head",
		image : Q.getDOM("headIdle"),
        rect:[0,202,75,135] ,
		x : 0,
		y : 0
	});


	// 初始化数据
	this.eventChildren = false;
	this.currentSpeedX = this.speedX = 5;
	this.dirX = 0;
	this.dirY = 0;

	this.addChild(this.head);
};

Squirrel.prototype.move = function(dir) {
	if (this.moving)
		return;
	this.dirX = dir;
	this.currentSpeedX = this.speedX;
	this.moving = true;
}
Squirrel.prototype.stopMove = function() {
	this.dirX = 0;
	this.currentSpeedX = this.speedX;
	this.moving = false;
}

})();/*  |xGv00|000fa142a8c484c67ec02933eb459638 */