function swiper(dom){
    var mySwiper = new Swiper(dom+' .swiper-container',{
        pagination: dom+' .pagination',
        loop:true,
        // grabCursor: true,
        paginationClickable: true
    });

    $(dom+' .arrow-left').on('click', function(e){
        e.preventDefault();
        mySwiper.swipePrev();
    });
    $(dom+' .arrow-right').on('click', function(e){
        e.preventDefault();
        mySwiper.swipeNext();
    });
} 
// 进度条显示
function progress(dom){
    
    $(dom+" .progress").each(function(){
        var dom = $(this);
        var reservation = dom.attr("reservation");
        var all = dom.attr("all");
        var pro = (reservation/all)*100;
        $(this).find("span").width(pro+"%");

    });
}
// 插入优品团商品
function insertList(data,dom){
    for (var i = 0; i < data.length ; i++) {
        var html,fan,hui,sold;
        sold = data[i].sold_num + data[i].real_num;
        // if(data[i][3])fan = "返";
        // if(data[i][4])hui = "惠";
        html = '<a href="/phone/group/detail/'+data[i].id+'" class="productBox cf">'+
                    '<img src="'+data[i].goods_img+'" class="pImg" />'+
                    '<div class="pInfo">'+
                        '<p class="pTitle f30 c3">'+
                            data[i].title+
                            '<span class="iconWarp f22">'+
                                // '<i class="icon icon1">'+fan+'</i>'+
                                // '<i class="icon icon2">'+hui+'</i>'+
                            '</span>'+
                        '</p>'+
                        '<p class="pAdress c9">'+
                            data[i].sale_address+
                            // '<span class="distance">'+data[i][6]+'</span>'+
                        '</p>'+
                        '<p class="orange priceBox1">'+
                           ' $<span class="price f36">'+data[i].exclusive_price+'</span>'+
                            '<span class="discount f22 ">'+data[i].discount+'折</span>'+
                        '</p>'+
                        '<p class="c9 priceBox2">'+
                            '<span class="original ">$'+data[i].market_price+'</span>'+
                            '<span class="sold ">已售'+sold+'件</span>'+
                        '</p>'+
                    '</div>'+
                '</a>';
        dom.append(html);
    };
}
// 插入一元抢商品
function insertList2(data,dom){
    for (var i = 0; i < data.length ; i++) {
        var html,sold;
        sold = data[i].sold_num + data[i].real_num;
        html = '<a href="#" class="productBox cf">'+
                        '<img src="'+data[i].goods_img+'" class="pImg" />'+
                        '<div class="pInfo">'+
                            '<p class="pTitle f30 c3">'+
                                data[i].title+
                            '</p>'+
                            '<p class="orange priceBox1">'+
                                '$<span class="price f36">1</span>'+
                                '<span class="original c9">$'+data[i].market_price+'</span>'+
                                '<span class="time c9">剩5天23小时</span>'+
                            '</p>'+
                            '<div class="c9 soldBox">'+
                                '<p class="sold f22">已有'+sold+'人抢购，仅剩333件</p>'+
                                '<p class="progress" reservation="500" all="520"><span></span></p>'+
                            '</div>'+
                            '<div class="btn f30">马上抢</div>'+
                        '</div>'+
                    '</a>';
        dom.append(html);
        progress("#list");
    };
    
}

// 列表页展开收缩
function accordion(dom){
    $(dom+" .typeTitle").click(function(){
        var box = $(this).closest(".typeBox");
        $(dom+" .typeBox").removeClass("hover");
        box.addClass("hover");
    })

}
function cityShow(){
    // 城市选择出现
    $("#citySelect").click(function(){
        var cityBox = $("#cityBox");
        var i= cityBox.attr("show");
        if(i == 0){
            cityBox.show();
            cityBox.attr("show",1);
            $("#menu").hide();
            $("#menu").attr("show",0);
        }else{
            cityBox.hide();
            cityBox.attr("show",0);
        }
    });
    // 城市选择消失
    $("#cityBox .blackBg").click(function(){
        $("#cityBox").hide();
    });
}
function search(){
    // 打开搜索
    $("#header .search").click(function(){
        $("#searchBox").addClass("searchHover");
    });
    // 关闭搜索
    $("#searchBox .searchHead .return").click(function(){
        $("#searchBox").removeClass("searchHover");
    });
    // 选择分类选项
    $("#searchBox .searchMain .typeBtn").click(function(){
        var i = $(this).index();
        $("#list .typeTitle").eq(i).click();
        $("#searchBox").removeClass("searchHover");
    });
}
