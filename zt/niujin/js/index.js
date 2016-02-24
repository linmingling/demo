$(function(){
     $('.close').click(function(event) {
         $('.code').hide(1000)
     });



     // 点击左侧执行的函数
     $('.left').one("click",function(){
         var a=$('#leftsh').text();
         var b=Number(a)+1;
         alert('投票成功');
         $('.left_s').html(b);
		 
		 $.ajax({
			async:false,
			url: 'server.php',
			data:{act:'left'},
			type: "post",
			dataType:'json',
			success:function(){
						
			}
		});
     });

     // 点击右侧执行的函数
     $('.right').one("click",function(){
         var X=$('.right_s').html();
        var Y=Number(X)+1;
        alert('投票成功');
        $('.right_s').html(Y);
		
		$.ajax({
			async:false,
			url: 'server.php',
			data:{act:'right'},
			type: "post",
			dataType:'json',
			success:function(){
						
			}
		});
     }); 




    // 一分钟执行一次的函数
	function func () {
	  //alert("出来");
	  $.ajax({
			async:false,
			url: 'server.php',
			data:{act:'search'},
			type: "post",
			dataType:'json',
			success:function(result){
				if(result.errcode == 0){
					$('.left_s').html(result.num[1]); //左侧
					$('.right_s').html(result.num[2]); //右侧
				}
			},
			error:function(){
				console.info("网络状况不佳");
			}
		});
	}

	var timer=setInterval(func,300000);

     
})