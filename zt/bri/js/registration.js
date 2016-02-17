$(function(){
	/*************滚动***************/
    //goToTop
    $(window).scroll(function(){
        if($(window).scrollTop()>1000){
            $("#goToTop").show(100);
        }else{
            $("#goToTop").hide(100);
        }
    });
    $("#goToTop").click(function(){
        if(scroll=="off") return;
        $("html,body").animate({scrollTop: 0}, 300);
    });
	//增加样式
    $('#sign .select .chk').each(function(index){
        var s1= '免费试用';
        var s2= '上门检测';
        $(this).click(function(){
            if ($(this).hasClass('checked')){
                 $(this).removeClass('checked');
                if(index==0){
                    s1= '';
                } else {
                    s2= '';
                }
            } else {
                $(this).addClass('checked');
                if(index==0){
                    s1= $(this).attr('value');
                } else {
                    s2= $(this).attr('value');
                }
            }
            $('#select').val(s1+'  '+s2);
        })
    })
    
    //提交活动报名信息
    $('.sure').click(function(){
        //报名信息1
        var name= returnVal('name');
        var phone= returnVal('phone');
        var city= returnVal('city');
        var select= returnVal('select');
        if(checkForm(name,phone,city,select)){
            $.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'trial', name:name, phone:phone, city:city, select:select},
                type: "post",
                dataType:'json',
                success:function(result){
                	if(parseInt(result.code) == 1){
                		alert(result.msg);
                	}else if(parseInt(result.code) == 2001){
                		alert(result.msg);
                	} else {
                		alert(result.msg);
                	}
                }
            });
            
        }
    })




	/*********************函数***************/
    //return value
    function returnVal(id){
        return $('#'+id).attr('value');
    }
	// 验证表单1
    function checkForm(name,tel,city,select){
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        var telp = /^0\d{2,3}-?\d{7,8}$/;
        //判断收货人是否为空
        if(name == ""){
           alert("请输入姓名！");
           return false;
        }
        //判断电话格式
        if(tel == ""){
            alert("请输入电话！");
            return false;
        }else if(!telp.test(tel) && !mob.test(tel)){
            alert("请输入正确的电话！");
            return false;
        }
        
        if(city == ""){
            alert("请选择城市！");
            return false;
        }
        //判断小区
        if(select == ""){
            alert("请选择方式！");
            return false;
        }
        return true;
    }
})