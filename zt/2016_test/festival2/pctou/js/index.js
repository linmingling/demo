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

    $('.btn').click(function(event) {
        $('.btn').val("投票中")
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
                $('.btn').after('<input type="button" value="结果" class="btn2" style="" onclick="showj()"/>')
                
            },15000);
        };
        // 页面刷新数据
        var timer2=setInterval(function(){
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
					}
				},
				error: function(XMLHttpRequest) {
					if(XMLHttpRequest.readyState != '4'){
						//alert("网络异常,请稍后重试");
					}
				}
			});
			
			var onexs=parseInt(Number(oneh)/10)
			var twoxs=parseInt(Number(twoh)/10)
			var threexs=parseInt(Number(threeh)/10)
			
			one_res = onexs
			tow_res = twoxs
			three_res = threexs
			
            $(".onemath").text(oneh+"票");
            $(".twomath").text(twoh+"票");
            $(".threemath").text(threeh+"票");
            $(".one").css("height",onexs);
            $(".two").css("height",twoxs);
            $(".three").css("height",threexs);
            if (oneh>1500) {
                $(".onemath").text("X票");
                $(".one").css("height",150);
            };
            if (twoh>1500) {
                $(".twomath").text("Y票");
                $(".two").css("height",150);
            };
            if (threeh>1500) {
                $(".threemath").text("Z票");
                $(".three").css("height",150);
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
        $(".one2").css("height",one_res);
        $(".two2").css("height",tow_res);
        $(".three2").css("height",three_res);
    }

    




