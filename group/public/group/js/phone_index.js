/*倒计时*/
function showTime_new(deadline,dom) {
		var countdown = new Date(deadline) - new Date();
		
		var restDays = dom.find(".days");
		var restHours = dom.find(".hours");
		var restMinutes = dom.find(".minutes");
		var restSeconds = dom.find(".seconds");

		var timer = setInterval(function() {
			if(countdown<0){
				clearInterval(timer);
				return false;
			}
			var days = Math.floor(countdown / 86400000) < 0 ? 0 : Math.floor(countdown / 86400000);
			var hours = Math.floor((countdown - days * 86400000) / 3600000) < 0 ? 0 : Math.floor((countdown - days * 86400000) / 3600000);
			var minutes = Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000);
			var seconds = Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000);			
			days < 10 ? days = "0" + days : days = days;
			hours < 10 ? hou000s = "0" + hours : hours = hours;
			minutes < 10 ? minutes = "0" + minutes : minutes = minutes;
			seconds < 10 ? seconds = "0" + seconds : seconds = seconds;

			//alert(days+", "+hours+", "+minutes+", "+seconds);
			restDays.html(days);
			restHours.html(hours);
			restMinutes.html(minutes);
			restSeconds.html(seconds);
			countdown -= 1000;
		}, 1000)
		
	}
function showTime(deadline,id) {
	var countdown = deadline - new Date();
	var restDays = $("#"+id+" .days");
	var restHours = $("#"+id+" .hours");
	var restMinutes = $("#"+id+" .minutes");
	var restSeconds = $("#"+id+" .seconds");

	var timer = setInterval(function() {
		if(countdown<0){
			clearInterval(timer);
			return false;
		}
		var days = Math.floor(countdown / 86400000) < 0 ? 0 : Math.floor(countdown / 86400000);
		var hours = Math.floor((countdown - days * 86400000) / 3600000) < 0 ? 0 : Math.floor((countdown - days * 86400000) / 3600000);
		var minutes = Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000);
		var seconds = Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000);			
		days < 10 ? days = "0" + days : days = days;
		hours < 10 ? hou000s = "0" + hours : hours = hours;
		minutes < 10 ? minutes = "0" + minutes : minutes = minutes;
		seconds < 10 ? seconds = "0" + seconds : seconds = seconds;

		//alert(days+", "+hours+", "+minutes+", "+seconds);
		restDays.html(days);
		//hours = days*24+hours;
		restHours.html(hours);
		restMinutes.html(minutes);
		restSeconds.html(seconds);
		countdown -= 1000;
	}, 1000);
}
function tips(text){
	$("body").append("<div class='comTips'>"+text+"</div>")
	setTimeout(function(){
		$(".comTips").remove();
	},3000);
}





