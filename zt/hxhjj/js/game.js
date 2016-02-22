(function() {
	window.onload = function() {
		game.init();
	}
	if (!window.console) {
		window.console = function() {};
		window.console.info = window.console.debug = window.console.warn = window.console.log = window.console.error = function(
				str) {
			alert(str);
		}
	}
	var STATE = {
		MENU : 0,
		PLAY : 1,
		OVER : 2,
        WIN:4

	};

	var game = {
		res : [
                {id : "sp",size : 38,src : "images/sp.png"}

        ],
		stage: null,
		container : null,
		width : 320,
		height : 324,
		params : null,
		frames : 0,

		fps : 60,
		timer : null,
		events: null,
		eventTarget : null,
		state : null,

		mainRole : null,
		balls : [],
		collidedBall : null,
        gameIconsName:["peng","pao","feiji","da","ttfc"],
		time : {total : 60,current :60},
		life:true,
		boombg: null,
        winbg:null,
        timeOut:null,
        propressDom: Q.getDOM("progress"),
		propress:-1,
        seconds : 30,
        speed:1000,
        timeId :null,
        winApi:null,
        containerX:null,
        score:0

	};
	var ns = window.game = game;

	game.getWidth = function(){
		return this.width;
	}
	game.getHeight = function(){
		return document.body.clientHeight-(110);
	}
	game.getEvents = function(i){
		return this.events[i];
	}
	game.createBalls = function() {
		for ( var i = 0; i < game.Ball.TypeList.length; i++) {
			var ball = new game.Ball({
				id : "ball" + i,
				type : game.Ball.TypeList[i]
			});
			this.balls.push(ball);

		}
        var boom = new game.Ball({
            id : "boom",
            type : game.Ball.Type.boom
        });
		this.balls.push(boom);
	}
	game.init = function() {
		var _this = this;
		_this.container = Q.getDOM("container");
        _this.container.style.height=_this.getHeight()+"px";

	    setTimeout(game.hideNavBar, 10);

		// load images
		var loader = new Q.ImageLoader();
		loader.addEventListener("complete", Q.delegate(this.onLoadComplete, this));
		loader.load(this.res);

	}



	game.onLoadComplete = function(e) {
        var _this=this;
		e.target.removeAllEventListeners();
		_this.images = e.images;
        game.Ball.init();
        Q.getDOM("starBtn").addEventListener("click",function(){
            Q.getDOM("loadingWrap").style.display="none";
            _this.startup();
        })

	}
	game.getImage = function(id) {
		return this.images[id].image;
	}

	game.startup = function() {
		var _this = this;
        _this.context = new Q.DOMContext({canvas : _this.container});
        _this.containerX=_this.container.offsetParent.offsetLeft;
        // set the main game stage
		_this.stage = new Q.Stage({context : _this.context, width : _this.width,height :  game.getHeight(),
			update : function(timeInfo) {
				_this.frames++;
				if (_this.state == STATE.MENU) {
				} else if (_this.state == STATE.PLAY) {
					_this.checkCollision();
				    _this.updateBalls();

				}
			}
		});
        //_this.stage.top=25;
        _this.stage.top=0;

		_this.timer = new Q.Timer(1000/_this.fps);
        _this.timer.addListener(_this.stage);
        _this.timer.addListener(Q.Tween);
        _this.timer.start();


		// register the stage events
		em = new Q.EventManager();
		_this.events = Q.supportTouch ? ["touchstart", "touchmove", "touchend"] : ["mousedown", "mousemove", "mouseup"];
		em.register(_this.context.canvas, _this.events, function(e) {
			var ne = (e.touches && e.touches.length > 0) ? e.touches[0]
					: (e.changedTouches && e.changedTouches.length > 0) ? e.changedTouches[0] : e;

			if (Q.supportTouch)
				ne.type = e.type;

			var x = ne.pageX - _this.stage.stageX, y = ne.pageY - _this.stage.stageY;
			var obj = _this.stage.getObjectUnderPoint(x, y);

			if (obj != null) {
				_this.eventTarget = obj;
				if (obj.useHandCursor)
					_this.context.canvas.style.cursor = "pointer";
				if (obj.onEvent != null)
					obj.onEvent(ne);
			}


            if (_this.state != STATE.PLAY) return;
            var startPosX = 0,endPosX = 0,distX=0;
            if(ne.type=="touchstart"){

                startPosX = ne.pageX;
            }
            if(ne.type=="touchmove"){
                endPosX=ne.pageX;
                distX=Math.abs(endPosX-startPosX);
                if(distX<=_this.mainRole.width/2){
                    _this.mainRole.x =0;
                }else if(distX<=(320-_this.mainRole.width+(_this.mainRole.width/2+_this.containerX))) {
                    _this.mainRole.x =distX-(_this.mainRole.width/2+_this.containerX);
                }

            }
		}, true, true);
		this.showUI();
		//this.showFPS();
	}

	game.showUI = function() {
        game.stage.removeAllChildren();
        setTimeout(Q.delegate(game.showMain, game), 100);
		var _this = this;
        Q.getDOM("toTga").style.top=_this.getHeight()-20+"px";
		if (_this.playBtn==null) {
			var playBtn = new Q.Button({id : "playBtn",image : Q.getDOM("icons"), x:_this.width/2-70, y:_this.getHeight()-60, width:139, height:43});
			playBtn.setUpState({rect : [0, 0, 139, 28]});
			_this.playBtn = playBtn;
			playBtn.onEvent = function(e){
				Q.Button.prototype.onEvent.call(_this, e);
				if(e.type == "mouseup" || e.type == "touchend")
				{
					 if (game.state == STATE.OVER) {
					 	game.score = 0;
						trace("game restart");
						game.stage.removeAllChildren();
                        game.countDown("restart")
                        Q.getDOM("toTga").style.display="none";
						game.time.current = game.time.total;
						game.timer.paused = false;
                        var gameIcons= Q.getDOM("bgFoot").getElementsByTagName("li");
                        for(var i=0;i<gameIcons.length;i++){
                            gameIcons[i].style.opacity=0;
                        }
                        _this.gameIconsName = ["peng","pao","feiji","da","ttfc"];
						setTimeout(Q.delegate(game.showMain, game), 100);
					}
				}
			}
			

		}

		_this.state = STATE.MENU;
	}

	game.showMain = function() {
		var _this = this;
		_this.state = STATE.PLAY;


		if (_this.mainRole == null) {
			_this.mainRole = new game.Squirrel({
				id : "squirrel",
				x : 0,
				y : _this.getHeight()-135,
				autoSize : true
			});
			_this.stage.addChild(_this.mainRole);

			_this.createBalls();
			for ( var i = 0; i < _this.balls.length; i++) {
				var ball = _this.balls[i];
				ball.reset(ball.getType());
				_this.stage.addChild(ball);
			}

		}
		_this.boombg = new Q.Bitmap({image: Q.getDOM("boom"), width: 320,height: 256, x:160,y:100,regX:320/2,regY:256/2,alpha:0,scaleX:0.1, scaleY:0.1});
        _this.winbg = new Q.Bitmap({image:Q.getDOM('win'), width: 320,height: 256, x:160,y:100,regX:320/2,regY:256/2,alpha:0,scaleX:0.1, scaleY:0.1});
        _this.timeOut = new Q.Bitmap({image:Q.getDOM('timeOut'), width: 275,height: 259,x:160,y:100,regX:275/2,regY:256/2,alpha:0,scaleX:0.1, scaleY:0.1});
		for ( var i = 0; i < this.balls.length; i++) {
			var ball = this.balls[i];
			ball.reset(ball.getType());
			_this.stage.addChild(ball);
		}
		_this.stage.addChild(_this.boombg,_this.winbg, _this.mainRole);

		_this.countDown();
	}

	game.updateBalls = function() {   //掉落物体

		var me = this, balls = this.balls, minBottom = 50;
		for ( var i = 0; i < balls.length; i++) {
			var ball = me.balls[i];
			if (ball.delay > 0) {
				ball.delay -= 1;
				continue;
			}
			if (ball.currentSpeedY > 0)
				ball.currentSpeedY += 0.1;
			else if (ball.currentSpeedY < 0)
				ball.currentSpeedY += 0.2;
			ball.y += ball.currentSpeedY;
			ball.x += ball.currentSpeedX;
			if (ball.bouncing) {
				if (ball.currentSpeedY >= 0) {
					ball.stopBounce();
					return;
				}
			}
			if (ball.y > me.getHeight() - minBottom && ball.alpha > 0) {
				ball.alpha -= 0.1;
				ball.fading = true;
			}
			if (ball.y > me.getHeight()) {
				ball.reset(ball.getType());
			}
		}
	}
    game.gamesIcon=function(o,s,val){
       /* var _this=this;
        var gameIcons= Q.getDOM("bgFoot").getElementsByTagName("li");
        if(s){gameIcons[o].style.opacity=1;}else{
            for(var i=0;i<gameIcons.length;i++){
                gameIcons[i].style.opacity=0;
            }
        }
        this.gameIconsName.remove = function(str) {
            var index = this.indexOf(str);
            if (index > -1) {
                this.splice(index, 1);
            }
        };
        if(this.gameIconsName.length!=0){
            _this.gameIconsName.remove(val);
        }else{ //游戏胜利
           _this.gameWin();
        }*/

    }
    game.gamesScore=function(s){
 
        game.score += s;
        showScore(s);
        //console.log(s+","+game.score)

    }
	game.checkCollision = function() {
		var _this = this, balls = this.balls, mainRole = this.mainRole;
		balls.sort(function(a, b) {
			return a.y < b.y;
		});
		for ( var i = 0; i < balls.length; i++) {
			var ball = balls[i];
			if (ball.fading || ball.bouncing)
				continue;
			var hW = ball.getCurrentWidth() * 0.5, hH = ball.getCurrentHeight() * 0.5;
			var dx = ball.x - mainRole.x, dy = mainRole.y - ball.y;

			//if (dx <= mainRole.getCurrentWidth() + hW && dx >= 0 && dy <= 2*hH && dy >= -hH - 100) {
				//检测碰撞
			if (dx <= mainRole.getCurrentWidth() + hW && dx >= -hW && dy <= 2*hH && dy >= -hH - 100) {
                //Q.getDOM("head").style.backgroundPosition="-133px -200px";
                switch(ball.name){
                    case "boom":
                        game.gameOver(_this.boombg);
                        break;
                    case "peng":
                        //_this.gamesIcon(1,true,"peng");
                        _this.gamesScore(200);
                        break;
                    case "pao":
                        //_this.gamesIcon(2,true,"pao");
                        _this.gamesScore(100);
                        break;
                }

                balls[i].alpha=0;
                balls[i].y += 1000;
				return true;
			}
            //if(Q.getDOM("head")){Q.getDOM("head").style.backgroundPosition="0px -200px";}

		}
		return false;
	}
	game.gameOver = function(bg) {

    /*    var _this=this;
        clearTimeout(game.timeId);
        Q.Tween.to(bg, {alpha:1, scaleX:0.8, scaleY:0.8}, {time:220,onComplete:function(tween){
            game.timer.pause();
        }});
        _this.state = STATE.OVER;
        Q.getDOM("toTga").style.display="block";
        _this.stage.removeAllChildren();
        _this.stage.addChild(_this.playBtn,bg);*/

        var _this=this;
        clearTimeout(game.timeId);
        Q.Tween.to(bg, {alpha:1, scaleX:0.8, scaleY:0.8}, {time:220,onComplete:function(tween){
            game.timer.pause();
        }});
        _this.state = STATE.OVER;
        _this.stage.removeAllChildren();
        
        _this.stage.addChild(_this.playBtn);
        gameover_hje(game.score);
        

	}
    game.gameWin = function() {
        var _this=this;
        clearTimeout(game.timeId);
        Q.Tween.to(_this.winbg, {alpha:1, scaleX:0.8, scaleY:0.8}, {time:220,onComplete:function(tween){
            game.timer.pause();
            //setTimeout(function(){_this.winApi();},1000);
        }});
        _this.state = STATE.OVER;
        Q.getDOM("toTga").style.display="block";
        _this.stage.removeAllChildren();
        _this.stage.addChild(_this.winbg);

    }

	game.showFPS = function() {
		var me = this, fpsContainer = Quark.getDOM("fps");
		setInterval(function() {
			fpsContainer.innerHTML = "FPS:" + me.frames;
			me.frames = 0;
		}, 1000);
	}

	game.hideNavBar = function() {
		window.scrollTo(0, 1);
	}


    game.countDown=function(a){

        var re=a || null,_this=this;
        if(re=="restart"){
            game.seconds=30;
            //game.propress=-1;
            //game.propressDom.style.width=100+"%";
        }else{
            game.propress++;
            //game.propressDom.style.width=(100-(game.propress)*10)+"%";
        }
        clearTimeout(game.timeId);
        //game.timeId = setTimeout("game.countDown(game.seconds--,game.speed)",game.speed);
        game.timeId = setTimeout(function(){
        	game.countDown(game.seconds--,game.speed);
        
        	document.getElementById("djs").innerHTML = "倒计时："+game.seconds+"s";
        	//console.log(game.seconds)
        },game.speed);
        if(game.seconds == 0){
            clearTimeout(game.timeId);
            game.gameOver(_this.timeOut);
        };
    }

})();
/*  |xGv00|c81c7ad0231749da217fe40167e9fd63 */