$(function(){
	var _h= $(window).height();
	$('.main').css('height',_h);
	// 适应不同的浏览器
	if(_h<=760 && _h >700){
		$('.box1 .img4').css('bottom','3%');
		$('.box1 .img3').css('bottom','3%');
		$('.box1 .num').css('bottom','20.5%');
	} else if(_h<700 && _h>550){
		$('.box1').css('height','532px');
		$('.box1 .img1').css('top','-11%');
		$('.main .box ').css('top','9.8%');
		$('.box1 .num').css('bottom','22.5%');
	}

	
	// 导航
	$('.navMain .nav span').each(function(index){
		$(this).click(function(){
			$('.cn').eq(index).show().siblings('.cn').hide();
		});
	});
	$('.topMain .nav span').each(function(index){
		$(this).click(function(){
			$('.cn').eq(index+5).show().siblings('.cn').hide();
		});
	});
	//关闭功能
	$('.cn .close').each(function(index){
		$(this).click(function(){
			if(!$('.img4').hasClass('hide')){
				$('.img4').hide();
			}
			$('.cn').eq(index).hide();
			$('.cn').eq(0).show();
		});
	});
	//page2的上下页功能
	$('#next').click(function(){
		$('#box2-1').hide();
		$('#box2-2').show();
	});
	$('#prev').click(function(){
		$('#box2-2').hide();
		$('#box2-1').show();
	})
	// 弹出二维码
	$('.img3').click(function(){
		if($('.img4').hasClass('hide')){
			$('.img4').show();
			$('.img4').removeClass('hide');
		} else {
			$('.img4').hide();
			$('.img4').addClass('hide');
		}
	});

	//获取参与碳指数的总人数
	$.ajax({
		url: 'server.php',
		data:{act:'ajax_list'},
		type: "post",
		dataType:'json',
		success:function(res){
			$('#num').html(res[0].num);
			
			var info_list = res;
			var count = info_list.length;
			var num;
			// 判断当前参与人是否为偶数，非偶数时，将多余人数放在左边
			if (count%2 == 0){
				num = count/2;
			} else {
				num  = parseInt(count/2) + count%2;
			}
			// 循环显示数组
	 		if(info_list){
	 			//达人榜  左边
				for(var j=0;j<num;j++){
					$("#rank1").append(
						'<tr class="nub'+info_list[j]['rank']+'"> '+ 
							'<td class="t1">'+ info_list[j]['rank'] +'</td>' +
							'<td class="t2">'+ info_list[j]['wechaname'] +'</td>' +
							'<td class="t3">'+ info_list[j]['share_num'] +'</td>' +
							'<td class="t4">'+ info_list[j]['tzs'] +'克</td>' +
						'</tr>'
			         );
				}
				//达人榜  右边
				for(var j=num;j<count;j++){
					$("#rank2").append(
						'<tr> '+ 
							'<td class="t1">'+ info_list[j]['rank'] +'</td>' +
							'<td class="t2">'+ info_list[j]['wechaname'] +'</td>' +
							'<td class="t3">'+ info_list[j]['share_num'] +'</td>' +
							'<td class="t4">'+ info_list[j]['tzs'] +'克</td>' +
						'</tr>'
			         );
				}
			}
		}
	});
})
