// 倒计时
var djsTime;
function djs(time){
    if(time > 1){
        $("#baoming .getCode").addClass("false").html(time+"s后重新获取");
        time--;
        setTimeout(function(){
            djsTime = djs(time);
        },1000)
    }else{
        getImgCode();
        $("#baoming .getCode").removeClass("false").html("获取验证码");
        clearTimeout(djsTime);
    }
}
// 重新获取图片验证码
function getImgCode(){
    $("#baoming .getImgCode").attr("src","/phone/zhan/captcha?"+new Date().getTime());
    $("#baoming .imgCode").val("");
}
function budian(btnId,zhanId,cId,fr){
	if(btnId,zhanId,cId){
		$.ajax({
			async:true,
			url:'/phone/zhan/budian',
			data:"btnId="+btnId+"&type=1&zhanId="+zhanId+"&cId="+cId+"&from="+fr,
			type: 'post',
			dataType:'json',
			success:function(result){
				if(result.errcode){

				} else {
					
				}
			}
		});
	}
}

// 布点
function distribution(){
    var win = $(window);
    var distribution = $(".distribution");
    var dt = new Array();
    var wh = win.height();
    var wt = win.scrollTop() + wh/2;
    var view=0;
    if(win.scrollTop() == 0){
        view=1;
    }else{
        distribution.each(function(i){
            // console.log(distribution.eq(i).height());
            if(i>0){
                dt[i] = dt[i-1] + distribution.eq(i-1).height();
            }else{
                dt[i] = 40;
            }
        });
        // console.log(dt+" , "+wt);
        
        for(view=0;view<dt.length;view++){
            if(dt[view]>wt){
                
                break;
            }
        }
    }   
    var lm = $(".distribution").eq(view-1).attr("lanmu");
    // console.log(lm)
    return lm;
}

//获取验证码
function getVerify(cId,tel){
    $.ajax({
        async:true,
        url:'/phone/zhan/verify',
        data:"cId="+cId+"&phone="+tel+"&captcha="+$("#baoming .imgCode").val(),
        type: 'post',
        dataType:'json',
        success:function(result){
            $("#baoming .getCode").removeClass("false2");
            if(result.code ==1){
                djs(60);
                // alert(result.errmsg);
            }else if(result.code ==2){
                alert("图片验证码错误，请重新输入！");
            }
        }
    });
}

// 打开报名层 转化代码 2015-12-11
function pyRegisterCvt(){
    var w=window,d=document,e=encodeURIComponent;
    var b=location.href,c=d.referrer,f,g=d.cookie,h=g.match(/(^|;)\s*ipycookie=([^;]*)/),i=g.match(/(^|;)\s*ipysession=([^;]*)/);
    if (w.parent!=w){f=b;b=c;c=f;};u='//stats.ipinyou.com/cvt?a='+e('NLs.pTs.wqGTkRV5RFnI-xLaKoCSlX')+'&c='+e(h?h[2]:'')+'&s='+e(i?i[2].match(/jump\%3D(\d+)/)[1]:'')+'&u='+e(b)+'&r='+e(c)+'&rd='+(new Date()).getTime()+'&e=';
    (new Image()).src=u;
}
$(function(){
    $("#loading").hide();

    // lazyload
    $('.lazy').lazyload({
        effect : "fadeIn" ,
        threshold : 50
    });

    // 后台布点用数据
    var zhan_id = $("#baoming").attr("data-zhan");
    var c_id = $("#baoming").attr("data-id");
    var from = $("#baoming").attr("data-from");
    // 百度布点用数据
    var zhan_name = $("#zhan_name").val();
    var city_name = $("#city_name").val();
    // var version = $("#version").val();
    var tab_name = $("#tab_name").val();
    var comInfo = tab_name+'_'+city_name+'_';

    var first = true;
    $(window).scroll(function(){
        console.log($(window).scrollTop())
        // 显示回到顶部
        if($(window).scrollTop()>5){
            $("#gototop").show();
        }else{
            $("#gototop").hide();
        }
        // 滚动是加载swiper图片
        if(first && $(window).scrollTop()>50){
            first = false;
            $(".swiperModule img").each(function(){
                if($(this).attr("data-original")){
                    $(this).attr("src",$(this).attr("data-original"));
                }
            })
        }
    });

    // 点击回到顶部
    $("#gototop").click(function(){
        $("html,body").animate({scrollTop: 0}, 100);
    });

    // 初始化滚动模块显示
    $(".swiperModule").each(function(){
		var row = parseInt($(this).attr('data-row'));
		var column = parseInt($(this).attr('data-column'));
		if(row == 0 || column == 0){
			//
		}else{
			if(row == 3 && column == 3){  //2行 3列
                $(this).addClass("swiperModule1");
            }else if(row == 2 && column == 3){  //3行 3列
                $(this).addClass("swiperModule2");
            }else if(row == 2 && column == 2){  //2行 2列
                $(this).addClass("swiperModule3");
            }else if(row == 1 && column == 2){  //1行 2列
              $(this).addClass("swiperModule4");
            }


			
			var paginationDom ="#"+ $(this).attr("id")+" .pagination";
			// console.log(paginationDom)
			var mySwiper2 = $(this).find(".swiper .swiper-container").swiper({
				mode: 'horizontal',
				loop:true,
				pagination :paginationDom
			});
		}
    });

    // 城市选择打开关闭
    $(".cityOpen").click(function(){
        $("#citySelect").show();
        $("body").addClass("noScroll");
    });
    $("#citySelect .cityClose, #citySelect .black_bg").click(function(){
        $("#citySelect").hide();
        $("body").removeClass("noScroll");
    });
    function BM(i){
        var lm = distribution(); 
        var hmID;
        if(i==1){
            hmID = comInfo+lm+'_Bmtn';
        }else{
            hmID = comInfo+lm+'_lqtn';
        }
        _hmt.push(['_trackEvent', zhan_name,city_name+'_页面报名按钮' , hmID]);
        budian(hmID,zhan_id,c_id,from);

        pyRegisterCvt();

        $("#baoming").removeClass("hide");
        $("body").addClass("noScroll");
        // console.log(hmID)
        $("#from_page").val(hmID);
    }    
    // 打开报名层
    $("#bmOpen").click(function(){
        BM(1)
        
    });
    // 打开报名层
    $(".bmOpen2").click(function(){
        BM(0)
        
    });
    
    // 关闭报名层
    $("#baoming .bmClose").click(function(){
		/*
        $("#baoming").addClass("hide");
        // 百度统计
        var hmID =  comInfo+'CloseBM';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_关闭报名弹层' , hmID]);
        */
		
		if($("#baoming .bmForm").hasClass("hide")){
            $("#baoming").addClass("hide");
            $("#stay").removeClass("hide");
            // 百度统计
            var hmID =  comInfo+'CloseBM';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_关闭报名弹层' , hmID]);
        }else{
            // alert("请完善您的收件地址，我们会免费为您寄送门票。");
            $("#baoming .bmForm .address").val("请完善您的收件地址").addClass("errTips");
            $("#baoming .bmForm .bmBtn").addClass("false");
        }
        
    });
    // 关闭挽留层
    $("#stay .stayClose").click(function(){
        $("#stay").addClass("hide");
        $("body").removeClass("noScroll");
        // 百度统计
        var hmID = comInfo+'CloseTips';
        _hmt.push(['_trackEvent',zhan_name,city_name+'_关闭挽留报名弹层' , hmID]);
        
    });
    // 挽留成功
    $("#stay .stayBtn2").click(function(){
        $("#baoming").removeClass("hide");
        $("#stay").addClass("hide");
        // 百度统计
        var hmID = comInfo+'ContinueBM';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_继续报名按钮' , hmID]);
        
    });
    // 挽留失败
    $("#stay .stayBtn1").click(function(){
        // 百度统计
        var hmID = comInfo+'GotoYPT';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_点击按钮跳转至优品团' , hmID]);
        location.href="/phone/group/index?from=bmts";
    });
    // 挽留失败 点击大图
    $("#stay .stayImg").click(function(){
        // 百度统计
        var hmID = comInfo+'GotoYPT2';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_点击图片跳转至优品团' , hmID]);
        location.href="/phone/group/index?from=bmts2";
    });


    // 检测是否填写姓名电话
    $("#baoming .lpForm .name, #baoming .lpForm .tel, #baoming .imgCode").keyup(function(){
        var name = $("#baoming .name").val();
        var tel = $("#baoming .tel").val();
        var imgCode = $("#baoming .imgCode").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;

        if(name =="" || tel =="" || !mob.test(tel) ){
            $("#baoming .lpBtn").addClass("false");
            return false;
        }else if(flag ==2 && imgCode==""){
            $("#baoming .lpBtn").addClass("false");
            return false;
        }else{
            // 填写了手机号码但还没点击提交的
 /*           var cId = $("#baoming").attr("data-id");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var btn_id = $("#baoming #btn_id").val();
            var fr = $("#baoming").attr("data-from");
            var from_page = $("#from_page").val();
            var userId = $("#baoming").attr("data-userId");

            if(cId && tel){
                $.ajax({
                    async:true,
                    url:"/phone/zhan/register",
                    data:"step=1&cId="+cId+"&type=2&name="+name+"&phone="+tel+"&from="+fr+"&btnId="+from_page,
                    type: 'post',
                    dataType:'json',
                    success:function(result){
                        // 点亮按钮
                        $("#baoming .lpBtn").removeClass("false");
                        $("#baoming").attr("data-userId","后台返回的id");
                    }
                });
            }
*/
			$("#baoming .lpBtn").removeClass("false");
			var hmID = comInfo+'SubmitPhone';
			_hmt.push(['_trackEvent', zhan_name,city_name+'_页面报名按钮变红' , hmID]);
        }
    });

    // 检测是否填写验证码
    $("#baoming .code").keyup(function(){
        var code = $("#baoming .code").val();
        var name = $("#baoming .name").val();
        var tel = $("#baoming .tel").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        if(code =="" || name =="" || tel =="" || !mob.test(tel)){
            $("#baoming .lpBtn2").addClass("false");
            return false;
        }else{
            $("#baoming .lpBtn2").removeClass("false");
            return true;
        }
    });

    // 检测是否填写地址
    function check2(){
        
        var address = $("#baoming .address").val();
        var area = $("#baoming .area").val();
        if(address == "" || address == "请完善您的收件地址" || area == "--请选择--"){
            $("#baoming .bmBtn").addClass("false");
            return false;
        }else{
            $("#baoming .bmBtn").removeClass("false");
        }
    }
    
    $("#baoming .bmForm input").keyup(function(){
        check2();
    });
    $("#baoming .bmForm select").change(function(){
        check2();
    });

    // 提交基本信息
    $("#baoming .lpBtn").click(function(){
        

        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        } else {
            // 百度统计
            var hmID = comInfo+'SubmitPhone';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_提交用户信息' , hmID]);
            //budian(hmID,zhan_id,c_id,from);

            $("#baoming .lpBtn").addClass("false2");
			
			var cId = $("#baoming").attr("data-id");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var imgCode = $("#baoming .imgCode").val();
			var fr = $("#baoming").attr("data-from");
            var from_page = $("#from_page").val();
            var userId = $("#baoming").attr("data-userId");       
	
            if(cId && tel){
				$.ajax({
					async:true,
					url:"/phone/zhan/register",
					data:"step=1&cId="+cId+"&type=1&name="+name+"&phone="+tel+"&from="+fr+"&btnId="+from_page+"&captcha="+imgCode+"&r="+Math.random(),
					type: 'post',
					dataType:'json',
					success:function(result){
						$("#baoming .lpBtn").removeClass("false2");
						if(result.code == 1 || result.code == 2 || result.code == 3){
							$("#baoming .codeP").removeClass("hide");
                            $("#baoming .lpBtn").hide();
                            $("#baoming .lpBtn2").show();
							getVerify(cId,tel);
						}else if(result.code == 4){  //已报过名且已验证
							$("#baoming").addClass("hide");
							$("#succeed").removeClass("hide");
                            $("body").addClass("noScroll");
						}else if(result.code == 5){  //快捷报名成功
							$("#baoming").addClass("hide");
							$("#succeed").removeClass("hide");
                            $("body").addClass("noScroll");
						}else if(result.code == 6){  //图片验证码不正确
                            alert("验证码不正确！");
                        }else if(result.code == 7){//不需要验证 填详细地址
                            $("#baoming .lpForm").addClass("hide");
                            $("#baoming .bmForm").removeClass("hide");
                        }else{
							//console.error(result.msg);
							//alert(result.msg);
							$("#baoming").addClass("hide");
							$("body").removeClass("noScroll");
						}
					},
                    complete:function(){
                        $("#baoming .lpBtn").removeClass("false2");
                    }
				});
			}
        }
    });
    // 提交验证码
    $("#baoming .lpBtn2").click(function(){
        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        } else {
            // 百度统计
            var hmID = comInfo+'SubmitCode';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_提交验证码' , hmID]);
            $("#baoming .lpBtn2").addClass("false2");
			
			var cId = $("#baoming").attr("data-id");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var code = $("#baoming .code").val();

            $.ajax({
                async:true,
                url:"/phone/zhan/register",
                data:"step=2&cId="+cId+"&type=1&&phone="+tel+"&code="+code,
                type: 'post',
                dataType:'json',
                success:function(result){
                    $("#baoming .lpBtn2").removeClass("false2");
                    if(result.code == 1){//验证成功
                        $("#baoming .lpForm").addClass("hide");
                        $("#baoming .bmForm").removeClass("hide");
                    }else{//验证失败
                        $("#baoming .code").val("").attr("placeholder","验证码错误").addClass("redPlaceholder");
                        $("#baoming .lpBtn2").addClass("false");         
                    }
                },
                complete:function(){   
                    $("#baoming .lpBtn2").removeClass("false2");
                }
            });
        }
    });
    
    // 提交验证码及详细地址
    $("#baoming .bmBtn").click(function(){

        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            // 百度统计
           var hmID = comInfo+'SubmitAddress';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_提交地址' , hmID]);
            //budian(hmID,zhan_id,c_id,from);

            //报名
            $("#baoming .bmBtn").html("正在报名...").addClass("false2");
			var cId = $("#baoming").attr("data-id");
            var tel = $("#baoming .tel").val();
            var address = $("#baoming .address").val();  //详细地址
            var area = $("#baoming .area").val();   //区
			var buy = $("#baoming #buy").val();
			if(cId && tel){
				$.ajax({
					async:true,
					url:"/phone/zhan/register",
					data:"step=3&cId="+cId+"&type=1&phone="+tel+"&area="+area+"&address="+address+"&buy="+buy,
					type: 'post',
					dataType:'json',
					success:function(result){
						$("#baoming .bmBtn").html("立即报名").removeClass("false2");
						if(result.code == 1){  //
							$("#baoming").addClass("hide");
                            $("#baoming .lpForm").removeClass("hide");
                            $("#baoming .bmForm").addClass("hide");
                            $("#baoming .codeP").addClass("hide");
                            $("#baoming .lpBtn").show();
                            $("#baoming .lpBtn2").hide();
							$("#succeed").removeClass("hide");

                            $("body").addClass("noScroll");
                            // 报名成功   转化代码 2015-12-11
                            !function(w,d,e){
                                var random = Math.round(Math.random()*1000);
                                while(random.length<3){
                                    random = "0"+random;
                                }
                                var _orderno = new Date().getTime()+random;  //时间戳+随机三位数;
                                var b=location.href,c=d.referrer,f,s,g=d.cookie,h=g.match(/(^|;)\s*ipycookie=([^;]*)/),i=g.match(/(^|;)\s*ipysession=([^;]*)/);if (w.parent!=w){f=b;b=c;c=f;};u='//stats.ipinyou.com/cvt?a='+e('NLs.6Ts.dy8B1Q5pBdtMbpmXoPFdaX')+'&c='+e(h?h[2]:'')+'&s='+e(i?i[2].match(/jump\%3D(\d+)/)[1]:'')+'&u='+e(b)+'&r='+e(c)+'&rd='+(new Date()).getTime()+'&OrderNo='+e(_orderno)+'&e=';
                                function _(){if(!d.body){setTimeout(_(),100);}else{s= d.createElement('script');s.src = u;d.body.insertBefore(s,d.body.firstChild);}}_();
                            }(window,document,encodeURIComponent);
						}else if(result.code == 2){
							//验证码错误
							$("#baoming .code").val("").attr("placeholder","验证码错误").addClass("redPlaceholder");
                            $("#baoming .bmBtn").addClass("false");
						}else{
							alert(result.msg);
						}
					}
				});
			}
        }
    });


    // 重新获取验证码
    $("#baoming .getCode").click(function(){
        

        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            // 百度统计
            var hmID = comInfo+'ReSCode';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_重新获取验证码' , hmID]);
            //budian(hmID,zhan_id,c_id,from);

            $("#baoming .getCode").addClass("false2");
            var tel = $("#baoming .tel").val();
			var cId = $("#baoming").attr("data-id");
            getVerify(cId,tel);
        }
    });
    
    $("#baoming .getImgCode").click(function(){
        getImgCode();
       
    });

    // 城市 区选项
	$.ajax({
		async:false,
		type:'get',
		url : '/phone/zhan/districtbycityid/'+$("#area").attr("data-id"),
		dataType : 'json',
		success  : function(result) {	
			if(result.code ==  1){
				var option = "<option value='0'>请选择区</option>";
				var list = result.msg;
				for(var i in list){
					option = option + '<option value="'+list[i]['region_id']+'">'+list[i]['region_name']+'</option>';
				}
				$("#area").html(option);
			}
		},
        error : function() {
            alert("服务器忙，请重试！")
        }
	});


    $("#baoming .code").focus(function(){
        $("#baoming .code").val("").attr("placeholder","请输入验证码").removeClass("redPlaceholder");
    });

    $("#baoming .bmForm .address").focus(function(){
        var address = $("#baoming .address").val();
        if(address == "请完善您的收件地址"){
            $("#baoming .address").val("").removeClass("errTips");
        }
    });

    // 关闭成功页
    $("#succeed .TcClose").click(function(){
        $("#succeed, #baoming").addClass("hide");
        $("body").removeClass("noScroll");
    });
    // 是否显示图片验证码
    if(flag == 1 || flag == 3){
        $("#baoming .imgcodeP").hide();
    }
});