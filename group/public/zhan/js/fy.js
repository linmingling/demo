var yt = yt || {};

//加载图片
yt.loadImg = function ($imgs, time) {
    var _time = 0;
    time = time || 200;

    $imgs.each(function () {
        var $that = $(this);
        if ($that.data('hasload')) {
            return false;
        }
        setTimeout(function () {
            $that.fadeOut(0);
            $that.attr('src', $that.data('src'));
            $that.attr('data-hasload', 'true');
            $that.fadeIn(500);
        }, _time);
        _time += time;
    });
};



//wap端环境
yt.isWap = function () {
    var s = navigator.userAgent.toLowerCase();
    var ipad = s.match(/ipad/i) == "ipad"
        , iphone = s.match(/iphone os/i) == "iphone os"
        , midp = s.match(/midp/i) == "midp"
        , uc7 = s.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"
        , uc = s.match(/ucweb/i) == "ucweb"
        , android = s.match(/android/i) == "android"
        , ce = s.match(/windows ce/i) == "windows ce"
        , wm = s.match(/windows mobile/i) == "windows mobile";
    if (iphone || midp || uc7 || uc || android || ce || wm || ipad) { return true; }
    return false;
};

//滑动绑定
yt.app = function () {
   
    var $swiperContainer = $("#swiper-container1"),
        $pages = $("#wrapper").children(),
        $as = $("#nav li a"),
        $lis = $("#nav li"),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper;

 

    //设置布局
    var setLayout = function () {
        var $wrapers = $("#swiper-container1 .wraper"),
            $wraper1 = $("#wraper1"),
       
            isWap=yt.isWap(),
            w = 720,
            h = 1135;
        var sl = function () {
            var _w = $wraper1.width(),
                h = $win.height(),
                _h = isWap && _w<h?$win.height():_w * 1135 / 720;
            $wrapers.height(_h);
            if($win.height()<300){
                $(".cn-slidetips").hide();
            }else{
                $(".cn-slidetips").show();
            }
        };
        sl();
        $win.resize(sl);
    };



    //触摸结束绑定
    
    var onTouchEnd = function () {
        var index = mySwiper.index;
        if (nowIndex == slideCount-1 && +mySwiper.touches['diff'] <-50) {
            return mySwiper.swipeTo(0);
        }
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
        // 加载图片
        $("#swiper-container1 .swiper-slide img").each(function(){
            if($(this).attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        });

        // 百度统计
        var lm = $(".lm").eq(mySwiper.activeIndex).attr("lanmu");
        var hmID = comInfo+lm+'_PV';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_滑屏PV' , hmID]);
        //budian(hmID,zhan_id,c_id,from);

    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            mode: 'vertical',
            // loop:true,
            pagination :"#pagination1"
            
        });
    };
    //滑动2 绑定内页滑动函数
    var bindSwiper2 = function () {
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
      
    };

    //滚到下一个屏  
    var bindNext = function () {
        $(".next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
       
            mySwiper.swipeTo(index);
        });
    };

    function budian(btnId,zhanId,cId,fr){
        if(btnId,zhanId,cId){
            $.ajax({
                async:true,
                url:'/phone/zhan/budian',
                data:"btnId="+btnId+"&type=2&zhanId="+zhanId+"&cId="+cId+"&from="+fr,
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

    // 打开报名层 转化代码 2015-12-11
    function pyRegisterCvt(){
        var w=window,d=document,e=encodeURIComponent;
        var b=location.href,c=d.referrer,f,g=d.cookie,h=g.match(/(^|;)\s*ipycookie=([^;]*)/),i=g.match(/(^|;)\s*ipysession=([^;]*)/);
        if (w.parent!=w){f=b;b=c;c=f;};u='//stats.ipinyou.com/cvt?a='+e('NLs.pTs.wqGTkRV5RFnI-xLaKoCSlX')+'&c='+e(h?h[2]:'')+'&s='+e(i?i[2].match(/jump\%3D(\d+)/)[1]:'')+'&u='+e(b)+'&r='+e(c)+'&rd='+(new Date()).getTime()+'&e=';
        (new Image()).src=u;
    }

    //初始化
    bindSwiper();
    bindSwiper2();
    bindNext();
    setLayout();

    

    // 倒计时
    function djs(i){
        // console.log(i)
        if(i<1){
            getImgCode();
            $("#baoming .getCode").html("获取验证码").removeClass("false2");
        }else{
            $("#baoming .getCode").html(i+"s重新获取").addClass("false2");
            setTimeout(function(){djs(i-1)},1000);
        }
    }

    // 发短信
    function send(tel, j){
        $.ajax({
            async:true,
            url:'/phone/zhan/send',
            data:{phone:tel, verify:j},
            type: 'post',
            dataType:'json',
            success:function(result){
            }
        });
    }

    // 打开关闭通用提示
    function comTips(text){
        $("#comTips .tipsBody").html(text);
        $("#comTips").show();
    }
    
    $("#comTips .tipsClose").click(function(){
        $("#comTips .tipsBody").html("");
        $("#comTips").hide();
    });

    //获取验证码
    function getVerify(cId,tel){
        $.ajax({
            async:true,
            url:'/phone/zhan/verify',
            data:"cId="+cId+"&phone="+tel+"&captcha="+$("#baoming .imgCode").val(),
            type: 'post',
            dataType:'json',
            success:function(result){
                console.log(result.code)
                $("#baoming .getCode").removeClass("false2");
                if(result.code ==1){                    
                    // comTips(result.errmsg);
                    djs(60);
                }else if(result.code ==2){
                    alert("图片验证码错误，请重新输入！");
                }
            }
        });
    }

    var BM = function(i){
        // 百度统计
        var lm = $(".lm").eq(mySwiper.activeIndex).attr("lanmu");
        var hmID;

        if(i==1){
            hmID = comInfo+lm+'_Bmtn';
        }else{
            hmID = comInfo+lm+'_lqtn';
        }
        _hmt.push(['_trackEvent', zhan_name,city_name+'_页面报名按钮' , hmID]);
        budian(hmID,zhan_id,c_id,from);

        pyRegisterCvt();

        // 加载报名成功页图片
        $("#succeed img").each(function(){
            if($(this).attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        });
        // console.log(hmID)
        $("#baoming").removeClass("hide");
        $("body").addClass("noScroll");
        $("#from_page").val(hmID);
    }
    // 打开报名层
    $(".click_btn").click(function(){
        BM(1);
        
    });
    // 打开报名层
    $(".bmOpen2").click(function(){
        BM(0);
        
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
        // 百度统计
        var hmID =  comInfo+'CloseTips';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_关闭挽留报名弹层' , hmID]);
        
    });
    // 挽留成功
    $("#stay .stayBtn2").click(function(){
        $("#baoming").removeClass("hide");
        $("#stay").addClass("hide");
        // 百度统计
        var hmID =  comInfo+'ContinueBM';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_继续报名按钮' , hmID]);
        
    });
    // 挽留失败
    $("#stay .stayBtn1").click(function(){
        // 百度统计
        var hmID = comInfo+'GotoYPT';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_跳转至优品团' , hmID]);
        location.href="/phone/group/index?from=bmts";
    });
    // 挽留失败 点击大图
    $("#stay .stayImg").click(function(){
        // 百度统计
        var hmID = comInfo+'GotoYPT2';
        _hmt.push(['_trackEvent', zhan_name,city_name+'_点击图片跳转至优品团' , hmID]);
        location.href="/phone/group/index?from=bmts2";
    });

    $("#baoming .bmForm .address").focus(function(){
        var address = $("#baoming .address").val();
        if(address == "请完善您的收件地址"){
            $("#baoming .address").val("").removeClass("errTips");
        }
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
/*            var cId = $("#baoming").attr("data-id");
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

    // 领票弹出
    $("#baoming .lpBtn").click(function(){
        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        } else {
            // 百度统计
            var hmID = comInfo+'SubmitPhone';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_提交用户信息' , hmID]);
    
        
            $("#baoming .lpBtn").addClass("false2");
            var cId = $("#baoming").attr("data-id");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var imgCode = $("#baoming .imgCode").val();
            var btn_id = $("#baoming #btn_id").val();
            var fr = $("#baoming").attr("data-from");
            var from_page = $("#from_page").val();
            var userId = $("#baoming").attr("data-userId");
            
            if(cId && tel){
                $.ajax({
                    async:true,
                    url:"/phone/zhan/register",
                    data:"step=1&cId="+cId+"&type=2&name="+name+"&phone="+tel+"&from="+fr+"&btnId="+from_page+"&captcha="+imgCode+"&r="+Math.random(),
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
                    }
                });
            }
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
            var tel = $("#baoming .tel").val();
            var name = $("#baoming .name").val();
            var code = $("#baoming .code").val();

            $.ajax({
                async:true,
                url:"/phone/zhan/register",
                data:"step=2&cId="+cId+"&type=2&phone="+tel+"&code="+code,
                type: 'post',
                dataType:'json',
                success:function(result){
                    $("#baoming .lpBtn").removeClass("false2");
                    if(result.code == 1){//验证成功
                        $("#baoming .lpForm").addClass("hide");
                        $("#baoming .bmForm").removeClass("hide");
                    }else{//验证失败
                        $("#baoming .code").val("").attr("placeholder","验证码错误").addClass("redPlaceholder");
                        $("#baoming .lpBtn2").addClass("false");         
                    }
                }
            });
        }
    });
    // 重新获取验证码
    $("#baoming .getCode").click(function(){
        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            // 百度统计
            var hmID = comInfo+'ReSCode';
            _hmt.push(['_trackEvent',zhan_name,city_name+'_重新获取验证码' , hmID]);
          
            $("#baoming .getCode").addClass("false2");
            var tel = $("#baoming .tel").val();
            var cId = $("#baoming").attr("data-id");
            getVerify(cId,tel);
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
    
    // 提交验证码及详细地址
    $("#baoming .bmBtn").click(function(){
        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            // 百度统计
            var hmID = comInfo+'SubmitAddress';
            _hmt.push(['_trackEvent', zhan_name,city_name+'_提交地址' , hmID]);

            //报名
            $("#baoming .bmBtn").addClass("false2");
            var cId = $("#baoming").attr("data-id");
            var tel = $("#baoming .tel").val();
            var address = $("#baoming .address").val();  //详细地址
            var area = $("#baoming .area").val();   //区
            var buy = $("#baoming .buy").val();   //购买需求
            if(cId && tel){
                $.ajax({
                    async:true,
                    url:"/phone/zhan/register",
                    data:"step=3&cId="+cId+"&type=2&&phone="+tel+"&area="+area+"&address="+address+"&buy="+buy,
                    type: 'post',
                    dataType:'json',
                    success:function(result){
                        $("#baoming .bmBtn").removeClass("false2");
                        if(result.code == 1){
                            $("#baoming").addClass("hide");
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
                        }else{
                            alert(result.msg);
                        }
                    }
                });
            }
        }
    });
    
    $("#baoming .code").focus(function(){
        $("#baoming .code").val("").attr("placeholder","请输入验证码").removeClass("redPlaceholder");
    });

    // 重新获取图片验证码
    function getImgCode(){
        $("#baoming .getImgCode").attr("src","/phone/zhan/captcha?"+new Date().getTime());
        $("#baoming .imgCode").val("");
    }
    $("#baoming .getImgCode").click(function(){
        getImgCode();
       
    });


    // 个城市 区选项
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

    // 打开关闭城市选择
    $(".cityOpen").click(function(){
        $("#citySelect").show();
        $("body").addClass("noScroll");
    });
    $("#citySelect .cityClose, #citySelect .black_bg").click(function(){
        $("#citySelect").hide();
        $("body").removeClass("noScroll");
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



    // 百度统计
    var lm = $(".lm").eq(0).attr("lanmu");
    var hmID = comInfo+lm+'_PV';
    _hmt.push(['_trackEvent', zhan_name,city_name+'_滑屏PV' , hmID]);
   //budian(hmID,zhan_id,c_id,from);
    
    
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
        
        var w = $(window).width();
        var h = $(window).height();
        // console.log(w+" , "+h+" , "+h/w)
        if(h/w<1.41){
            $("#swiper-container1").addClass("fat");
        }
    };

 
};
yt.init();