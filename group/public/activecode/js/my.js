$(".form-submit").click(function(){
	var na=$("#name").val();
    var phone=$("#phone").val();
    var card=$("#card").val();
    var captcha=$("#captcha").val();
    $.ajax({
        async:false,
        url:'/phone/activecode/checkcode',
        data:{act:'add',name:na,phone:phone,num:card,code:captcha},
        type: "post",
        dataType:'json',
        success:function(result){
            //数据返回后执行
            if(result.errcode != 0){
            	console.log(result.errmsg);
                alert(result.errmsg);
                return false;
            }else{
                alert(result.errmsg);
                $(".money-page").show();
                return false;
            }
            
        }
    });
});

/*
$(".money-btn").click(function(){
	$.ajax({
        async:false,
        url:'../../phone/activecode/getmoney',
        type: "post",
        dataType:'json',
        success:function(result){
            //数据返回后执行
            if(result.errcode != 0){
            	console.log(result.errcode);
                alert(result.errmsg);
                return false;
            }else{
                alert(result.errmsg);
                return false;
            }
            
        }
    });
});
*/


