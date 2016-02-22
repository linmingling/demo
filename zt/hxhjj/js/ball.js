(function() {
	var Ball = game.Ball = function(props) {
		props = props || {};
		this.type = props.type;
		Ball.superClass.constructor.call(this, this.type);
		this.id = props.id || Q.UIDUtil.createUID("Ball");
		this.reset(this.type);
	};
	Q.inherit(Ball, Q.Bitmap);

	Ball.prototype.init = function() {
	};

	Ball.prototype.update = function(timeInfo) {
        //下落时旋转
		//this.rotation += 0.5;
	};

	Ball.prototype.reset = function(type) {
		this.setType(type);
		this.rect = this.type.rect;
		this.alpha = 1;
		this.fading = false;
		this.bouncing = false;
		this.currentSpeedY = this.type.speedY;
		this.currentSpeedX = 0;
		this.delay = Math.floor(Math.random() * 300);
		this.setRandomPosition(type);
	}

	Ball.prototype.setRandomPosition = function(type) {
		var minX = 10, maxX = game.width - 100;
		this.x = Math.floor(Math.random() * (maxX - minX) + minX);
		this.y = -120;
	}

	Ball.prototype.setType = function(type) {
		this.type = type;
	}

	Ball.prototype.getType = function() {
		return this.type;
	}

//	Ball.prototype.getTypelist = function() {
//		return this.TypeList;
//	};
	Ball.prototype.draw = function(color, radius) {
		this.drawCircle(0, 0, radius).beginFill(color).endFill().cache();
	} 
//	Ball.getRandomType = function() {
//		var list = this.TypeList;
//		var r = Math.floor(Math.random() * list.length);
//		return list[r];
//
//	};

	Ball.prototype.getCollide = function() {
		this.currentSpeedY = Math.floor(-10);
		this.bouncing = true;
	}

	Ball.prototype.stopBounce = function() {
		this.bouncing = false;
	}
	Ball.init = function() {
		this.Type = {};
		this.Type.nut0 = {
			name: 'peng',
			score : 200,
			speedY : 0.4,
			image: game.getImage("sp"),
            rect:[0,0,85,63]
		};
		this.Type.nut1 = {
				name: 'pao',
				score : 100,
				speedY : 0.4,
				image: game.getImage("sp"),
				rect:[100,0,55,52]
			};/*
		this.Type.nut2 = {
				name: 'feiji',
				score : 50,
				speedY : 0.4,
				image: game.getImage("sp"),
                rect:[0,0,55,48]
			};
        this.Type.nut3 = {
            name: 'da',
            score : 50,
            speedY : 0.4,
            image: game.getImage("sp"),
            rect:[75,50,55,48]
        };
        this.Type.nut4 = {
            name: 'ttfc',
            score : 50,
            speedY : 0.4,
            image: game.getImage("sp"),
            rect:[75,0,55,48]
        };*/
        this.Type.boom = {
            name: 'boom',
            score : 0,
            speedY : 0.4,
            image: game.getImage("sp"),
            rect:[75,100,55,58]
        };
		//this.TypeList = [ this.Type.nut0,this.Type.nut1,this.Type.nut2,this.Type.nut3,this.Type.nut4];
		this.TypeList = [ this.Type.nut0,this.Type.nut1,this.Type.nut1,this.Type.nut1,this.Type.nut1];


	}
})();/*  |xGv00|f796b06a05b1cdc5ae592324099f48b7 */