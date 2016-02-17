$(function(){
    /*************图片加载与滚动***************/
    $("img.lazy").lazyload({
        effect: "fadeIn",
        threshold :180
    });
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
    /*************part2 交互***************/
    $('.sex .chk').click(function(){
        $('#sex').val($(this).attr('value'));
    })
    $('.isanimal .chk').click(function(){
        $('#isanimal').val($(this).attr('value'));
    })
    $('.isclean .chk').click(function(){
        $('#isclean').val($(this).attr('value'));
    })
    $('.isdec .chk').click(function(){
        $('#isdec').val($(this).attr('value'));
    })
    $('.issmoking .chk').click(function(){
        $('#issmoking').val($(this).attr('value'));
    })
    $('.ishealth .chk').click(function(){
        $('#ishealth').val($(this).attr('value'));
    })
    
    //提交活动报名信息
    $('.sub-1').click(function(){
        //复选框
        var type =[];
        $('input[type=checkbox]:checked').each(function(){
            type.push($(this).val());
        })
        //报名信息2
        var name1= returnVal('name1');
        var sex=returnVal('sex');
        var phone1= returnVal('phone1');
        var city1= returnVal('city1');
        var address= returnVal('address');
        var type= type;
        var isanimal = returnVal('isanimal');//新增
        var isclean= returnVal('isclean');
        var isdec= returnVal('isdec');
        var issmoking= returnVal('issmoking');
        var ishealth= returnVal('ishealth');
        var xy = returnVal('x1');//宣言内容
        
       
        if(checkForm_2(name1,sex,phone1,city1,address,ishealth,issmoking,isdec,isanimal,isclean,xy)){
            $.ajax({
                async:false,
                url: 'server.php',
                data:{act:'apply', name:name1, phone:phone1, sex:sex, city:city1, address:address, type:type, ishealth:ishealth, issmoking:issmoking, isdec:isdec, isanimal:isanimal, isclean:isclean, xy:xy},
                type: "post",
                dataType:'json',
                success:function(data){
                    if(parseInt(data.code) == 1){
                        alert(data.msg);
                    } else if(parseInt(data.code) == 2001){
                        //成功提示层
                        alert('感谢您的参与,5名监察员名单将会在6月2日公布,敬请期待');
                        location.href="./sign.html#rule";
                    } else {
                        alert(data.msg);
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
    // 验证表单
    function checkForm_2(name,sex,tel,city,address,ishealth,issmoking,isdec,isanimal,isclean,xy){
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        var telp = /^0\d{2,3}-?\d{7,8}$/;
        //判断收货人是否为空
        if(name == ""){
           alert("请输入姓名！");
           return false;
        }
        if(sex == ""){
           alert("请选择性别！");
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
            alert("请填写城市！");
            return false;
        }
        if(address == ""){
            alert("请填写详细地址！");
            return false;
        }
        /*if(type == ""){
            alert("请选择家庭成员！");
            return false;
        }*/
        if(isdec == ""){
            alert("请判断是否新装修！");
            return false;
        }

        if(issmoking == ""){
            alert("请判断家里是否有人吸烟！");
            return false;
        }
        if(ishealth == ""){
            alert("请判断家里是否有呼吸疾病人员！");
            return false;
        }
        if(isanimal == ""){
            alert("请判断家里是否有宠物！");
            return false;
        }
        if(isclean == ""){
            alert("请判断是否使用过空气净化器！");
            return false;
        }
        if(xy == ""){
            alert("请填写宣言！");
            return false;
        }
        return true;
    }   
})