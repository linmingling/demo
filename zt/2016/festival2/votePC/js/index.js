    var test=0
    // 给的第一个值 oneh
    var oneh=0
    // 给的第二个值 
    var twoh=0
    // 给的第三个值 
    var threeh=0
	
	var one_res=0
	var tow_res=0
	var three_res=0
    // 设置投票时间
    var timer_s=30

    $('.btn').click(function(event) {

        // 计时器启动
        /* $(".clock").show()
        var timer=setInterval(function(){
            $(".clock").text(timer_s-1)
            timer_s=timer_s-1
            if (timer_s<0) {
                $(".clock").text(0)
            };
        },1000) */
        // 按钮文字改变
        $('.btn').hide()
        var test=1
		
		// 触发后台
		$.ajax({
			async:false,
			url: '../draw.php',
			data:{act:'start',sign_num:'1'},
			type: "post",
			dataType:'json',
			success:function(result){
			},
			error: function(XMLHttpRequest) {
				if(XMLHttpRequest.readyState != '4'){
					alert("网络异常,请稍后重试");
				}
			}
		});
		
        // test单击后为1开始计时
        if (test==1) {
            var c = setTimeout(function(){
                test=0;
				//时间结束触发后台
				$.ajax({
					async:false,
					url: '../draw.php',
					data:{act:'start',sign_num:'0'},
					type: "post",
					dataType:'json',
					success:function(result){

					},
					error: function(XMLHttpRequest) {
						if(XMLHttpRequest.readyState != '4'){
							alert("网络异常,请稍后重试");
						}
					}
				});
                $('.btn').hide();
                $('.btn').after('<img src="images/results_03.png" class="btn2" style="" onclick="showj()"/>')
                
            },timer_s*1000);
        };
        // 页面刷新数据
        var timer2=setInterval(function(){
			// 实时查出每人次数
			$.ajax({
				async:false,
				url: '../draw.php',
				data:{act:'search'},
				type: "post",
				dataType:'json',
				success:function(result){
					if(result.errcode ==0)
					{
						oneh=result.res['1'];
						twoh=result.res['2'];
						threeh=result.res['3'];
						if(result.res['1'] == null){
							oneh = 0;
						}
						if(result.res['2'] == null){
							twoh = 0;
						}
						if(result.res['3'] == null){
							threeh = 0;
						}					
					}
				},
				error: function(XMLHttpRequest) {
					if(XMLHttpRequest.readyState != '4'){
						//alert("网络异常,请稍后重试");
					}
				}
			});
			
			var onexs=parseInt(Number(oneh)/33)
			var twoxs=parseInt(Number(twoh)/33)
			var threexs=parseInt(Number(threeh)/33)
			
			one_res = parseInt(Number(onexs)/5)
			tow_res = parseInt(Number(twoxs)/5)
			three_res = parseInt(Number(threexs)/5)
			
            $(".onemath").text(oneh+"票");
            $(".twomath").text(twoh+"票");
            $(".threemath").text(threeh+"票");
            $(".one").css("height",onexs);
            $(".two").css("height",twoxs);
            $(".three").css("height",threexs);
            if (oneh>10000) {
                $(".onemath").text("1万+票");
                $(".one").css("height",300);
            };
            if (twoh>10000) {
                $(".twomath").text("1万+票");
                $(".two").css("height",300);
            };
            if (threeh>10000) {
                $(".threemath").text("1万+票");
                $(".three").css("height",300);
            };
			$(".clock").show()
			$(".clock").text(timer_s-1)
            timer_s=timer_s-1
            if (timer_s<1) {
                $(".clock").text("")
            };
        },1000);
    });


    // 切换到显示结果页面
    function showj(){
        $(".contant").hide();
        $(".ticket").hide();
        $(".ticket").hide();
        $(".company").hide();
        $(".btn").hide();
        $(".contant2").show()
        $(".onemath2").text(oneh+"票");
        $(".twomath2").text(twoh+"票");
        $(".threemath2").text(threeh+"票");
        var numz=[oneh,twoh,threeh]
        var nums=[oneh,twoh,threeh]
        var nums=nums.sort(function (a,b){return(b-a)})
        for(i=0;i<3;i++){
            if(nums[0]==numz[i]){
               $(".math").eq(i).css({height:300})
            }
        }  
        for(i=0;i<3;i++){
            if(nums[1]==numz[i]){
               $(".math").eq(i).css({height: numz[i]*(300/nums[0])})
            }
        } 
        for(i=0;i<3;i++){
            if(nums[2]==numz[i]){
               $(".math").eq(i).css({height: numz[i]*(300/nums[0])})
            }
        }   
        // $(".one2").css("height",one_res);
        // $(".two2").css("height",tow_res);
        // $(".three2").css("height",three_res);
		
		// 结果插入数据库
		$.ajax({
			async:true,
			url: '../draw.php',
			data:{act:'changePri'},
			type: "post",
			dataType:'json',
			success:function(result){
			},
			error: function(XMLHttpRequest) {
				if(XMLHttpRequest.readyState != '4'){
					alert("网络异常,请稍后重试");
				}
			}
		});
    }
	
	// 获取候选人
	$(".btn3").click(function(event) {
		$.ajax({
			async:false,
			url: '../draw.php',
			data:{act:'charge'},
			type: "post",
			dataType:'json',
			success:function(result){
				if(result.errcode==0){
					console.log(result.renArr);
					$(".one_name").text(result.renArr[0])
					$(".two_name").text(result.renArr[1])
					$(".three_name").text(result.renArr[2])
					$(".btn3").hide()
                    $(".btn").show()
				}
			},
			error: function(XMLHttpRequest) {
				if(XMLHttpRequest.readyState != '4'){
					alert("网络异常,请稍后重试");
				}
			}
		});
        
        
    });

    




