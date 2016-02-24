var youju = {
	time:0,
	allTime:5,
	score:0

}
var createBallTime, gameTime;

//添加球球
function createBall (){
	var i = Math.round(Math.random()*4);
	//console.log(i);
	var ball;
	switch (i){
		case 1: ball = "<span class='ball ball1' score='10' onclick='checkClick($(this))' style='left:"+Math.random()*80+"%'></span>";break;
		case 2: ball = "<span class='ball ball2' score='10' onclick='checkClick($(this))' style='left:"+Math.random()*80+"%'></span>";break;
		case 3: ball = "<span class='ball ball3' score='20' onclick='checkClick($(this))' style='left:"+Math.random()*80+"%'></span>";break;
		default: ball = "<span class='ball ball4' score='10' onclick='checkClick($(this))' style='left:"+Math.random()*80+"%'></span>";break;
	}
	$("#ballBox").append(ball);
}

//游戏开始
function gameStart(){
	youju.time = youju.allTime;
	youju.score = 0;
	createBallTime = setInterval(createBall,500);
	checkTime();
}

//游戏结束
function gameOver(){
	$("#gameOver .orange").html(youju.score);
	$("#gameOver").fadeIn();
	//alert(youju.score);
}

//检查时间
function checkTime(){
	gameTime = setTimeout(function(){
		if(youju.time<0){
			clearTimeout(gameTime);
			clearTimeout(createBallTime);
			gameOver();
		}else{
			$("#time").html(youju.time);
			youju.time--;
			checkTime();
		}
	},1000);
}

//检查点击
function checkClick(dom){
	var score = Math.round(dom.attr("score"))
	youju.score += score;
	var gray = "grayscale("+(100-(youju.score/5))+"%)";

	$("#game .gameBg").css({"-webkit-filter": gray,"filter":gray});
	$("#score").html(youju.score);
	dom.hide();
}
$(function(){
	$(".startBtn").click(function(){
		$(".page").hide();
		$("#game").show();
		gameStart();
	})
})
