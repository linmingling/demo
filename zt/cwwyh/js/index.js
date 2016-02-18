var guestimg = function(element){
	this.element = element;
	this.i = 1;
	this.timer = '';
	this.itemnum = this.element.boxitem.length;
	if(this.itemnum<=1) this.element.btn.hide();
	this.movestep = this.element.boxitem.width();
	for (k=1;k<=this.itemnum;k++){
		this.element.boxitem.eq(k-1).attr('listnum',k);
	};
	this.init();
}

guestimg.prototype.init = function(){
	var boxwidth = this.movestep*this.itemnum;
	this.element.box.width(boxwidth);
	this.clickFunc();
};

guestimg.prototype.clickFunc = function(){
	var _this = this;
	_this.element.btn.each(function(){
		$(this).bind('click',function(){
			if($(this).hasClass('prev')){
			    _this.moveright();
			} else {
			    
			    _this.moveleft();
			}
		})
	})
};

guestimg.prototype.moveleft = function(){
	var _this = this;
	if(_this.i<_this.itemnum){
		_this.element.box.stop(false,true).animate({'left':-_this.movestep+'px'},300,
		function(){
			_this.element.box.append($('[listnum='+_this.i+']')).css('left','0');
			_this.i++;
		});
	} else {
		_this.element.box.stop(false,true).animate({'left':-_this.movestep+'px'},300,
		function(){
			_this.element.box.append($('[listnum='+_this.itemnum+']')).css('left','0');							
			_this.i = 1;
		});
	}
}

guestimg.prototype.moveright = function(){
	var _this = this;
	if(_this.i>1) {
		_this.element.box.stop(false,true).css('left',-_this.movestep+'px').prepend($('[listnum='+(_this.i-1)+']')).animate({'left':'0'},300,function(){
			_this.i--;
		});	
	} else {
		_this.element.box.stop(false,true).css('left',-_this.movestep+'px').prepend($('[listnum='+_this.itemnum+']')).animate({'left':'0'},300,function(){
			_this.i = _this.itemnum;
		});
	}
}


function showmaster(i) {
    $(".masterlistnav ul li").addClass('current').siblings().removeClass('current');
    $('#li' + i).addClass('current');
    $('.master').eq(i - 1).show().siblings().hide();


}

$(function () {
    var guest = {
        boxwrap: $('.guest'),
        box: $('.guestlist ul'),
        boxitem: $('.guestlist ul li'),
        btn: $('.guest a.btn')
    }
    new guestimg(guest);

//    $('.pagenav ul li').each(function (i) {
//        var t = $('.title').eq(i).offset().top;
//        $(this).click(function () {
//            $(this).addClass('current').siblings().removeClass('current');
//            $('html,body').animate({ scrollTop: t }, 500); ;
//        });
//    });



    $('.masternav ul li').each(function () {
        if ($(this).find('.bg').length > 0) $(this).find('p').show();
    });




    $('.masterlistnav ul li').each(function (i) {
        $(this).click(function () {
            $(this).addClass('current').siblings().removeClass('current');
            $('.master').eq(i).show().siblings().hide();
        })
    });

    $('.requestlistnav ul li').each(function (i) {
        $(this).click(function () {
            $(this).addClass('current').siblings().removeClass('current');
            $('.request').eq(i).show().siblings().hide();
        })
    });

    $('.feednav ul li').each(function (i) {
        $(this).click(function () {
            $(this).addClass('current').siblings().removeClass('current');
            $('.feed').eq(i).show().siblings().hide();
        })
    });

    $('.feednav2 ul li').each(function (i) {
        $(this).click(function () {
            $(this).addClass('current2').siblings().removeClass('current2');
            $('.feed2').eq(i).show().siblings().hide();
        })
    });

});
