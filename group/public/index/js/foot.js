function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); 
     return null;

}
$(function() {
	var app = GetQueryString("app");
	console.log(app);
	if(app == 1){
		$("#footer").hide();
		$("#header").hide();
	}
})