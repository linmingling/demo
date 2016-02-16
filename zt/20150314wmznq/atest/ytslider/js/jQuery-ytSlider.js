/*
ytSlider heqing0712@126.com
Date:2015-03-02 15:16:29
*/
; (function (window, $,undefined) {
    //滑动函数
    var ytSlider = function (cf) {
        if (!cf) { return; }
        if (typeof cf === 'string' || cf.nodeType) {
            cf = { idBox: cf };
        }
        var df = ytSlider.defaults;
        for (var i in df) {
            (cf[i] === undefined) && (cf[i] = df[i]);
        }
        return new ytSlider.prototype._init(cf);
    };

    ytSlider.prototype = {

        constructor:ytSlider,

        //初始化执行
        _init: function (cf) {
            this.cf = cf;
            

            //执行设置节点元素
            this._setDOM();

            if (!this.dom) return false;

            //初始化前执行
            cf.initBefore && cf.initBefore.call(this);

            //绑定事件
            this._bindEvent();

            //开始执行滑动
            this.slide();

            //初始化完成后 执行事件
            cf.initAfter && cf.initAfter.call(this, cf.activeIndex);

            return this;
        },

        //增加滑动队列函数
        addSlideFns: function (fn) {
            this.slideFns.push(fn);
        },

        //执行滑动
        slide: function () {
            if (!this.cf.slideAuto)
                return this.slideTo();

            var me = this,
            slideAuto = function () {
                me.timer && clearInterval(me.timer);
                me.timer = setInterval(function () {
                    me.slideTo(me.activeIndex + 1);
                }, me.cf.delay);
            };
            slideAuto();
            $(me.dom.box).on('mouseover', function () {
                clearInterval(me.timer);
            }).on('mouseout', function () {
                slideAuto();
            })
        },

        //上一模块
        slidePrev: function () {
            return this.slideTo(this.activeIndex - 1);
        },

        //下一模块
        slideNext: function () {
            return this.slideTo(this.activeIndex + 1);
        },

        //执行滑动
        slideTo: function (index) {

            if (index === this.activeIndex) return;
            var me = this,
                cf = me.cf,
                active = me.activeIndex,
                scount = me.scount;

            index = index === undefined ? active :
                    index < 0 ? scount - 1 :
                    index > scount - 1 ? 0 : index;

            me.oldIndex = active;
            me.activeIndex = index;

            cf.slideBefore && cf.slideBefore.call(me, index);
            me._sliding();
            cf.slideAfter && cf.slideAfter.call(me, index);

            return this;
        },

        //每次滑动要执行的方法
        _sliding: function () {
            var sType = this.cf.slideType,
                objs = this._slideObjs,
                fns = this.slideFns;

            objs[sType] && objs[sType].call(this);
            for (var i in fns) {
                fns[i].call(this, this.activeIndex);
            }
        },

        //滑动效果方法集合
        _slideObjs: {

            //左右滑动
            left: function () {
                var me = this, cf = me.cf;
                me.$scn.stop().animate({
                    left: -me.cnWidth * me.activeIndex
                }, cf.speed, cf.easing)
            },

            //上下滑动
            top: function () {
                var me = this, cf = me.cf;
                me.$scn.stop().animate({
                    top: -me.cnHeight * me.activeIndex
                }, cf.speed, cf.easing)
            },

            //淡入淡出
            fade: function () {
                var me = this,
                    cf = me.cf,
                    $scns = me.$scns;
                $scns.eq(me.activeIndex).stop().show().css('z-index', 4).animate({ opacity: 1 }, cf.speed, cf.easing);
                $scns.eq(me.oldIndex).stop().css('z-index', 3).animate({ opacity: 0 }, cf.speed, cf.easing, function () {
                    $(this).hide().css('z-index', 1);
                });
            }
        },

        //根据滑动效果进行布局设置
        _slideLayouts: {

            //左右滑动
            left: function () {
                var me = this, style = me.scn.style;
                style.width = (me.sWidth * me.scount) + "px";
                style.left = "0px";
                if (me.sWidth < me.cnWidth) {
                    var _scount = Math.ceil(me.sWidth * me.scount / me.cnWidth);
                    me.scount = me.sWidth * me.scount % me.cnWidth < me.sWidth ? _scount - 1 : _scount;
                    me.cnWidth = me.sWidth * (Math.round(me.cnWidth / me.sWidth));
                }
            },

            //上下滑动
            top: function () {
                var me = this, style = me.scn.style;
                style.height = me.sHeight * me.scount + "px";
                style.top = "0px";
                if (me.sHeight < me.cnHeight) {
                    var _scount = Math.ceil(me.sHeight * me.scount / me.cnHeight);
                    me.scount = me.sHeight * me.scount % me.cnHeight < me.sHeight ? _scount - 1 : _scount;
                    me.cnHeight = me.sHeight * (Math.round(me.cnHeight / me.sHeight));
                }
                $.each(me.scns, function (i, ele) {
                    ele.style.height = me.sHeight + "px";
                    ele.style['float'] = "none"
                });
            },

            //淡入淡出
            fade: function () {
                var me = this;
                $.each(me.scns, function (i, ele) {
                    var o = 0, z = 1;
                    i === me.cf.activeIndex && (o = 1) && (z = 2);
                    $(ele).css({ opacity: o, position: 'absolute', 'z-index': z, left: 0, top: 0 });
                });
            }
        },

        //设置DOM节点
        _setDOM: function () {

            if (this.dom) return;

            var me = this,
                cf = me.cf,
                box = cf.idBox.nodeType ? cf.idBox : $('#' + cf.idBox)[0],
                get = function (id, cls, pele, ena) {
                    return id && $('#' + id)[0] ||
                        cls && $('.' + cls, pele)[0] ||
                        ena && $(ena, pele)[0];
                },
                scn = get(cf.idScn, cf.clsScn, box, 'ul'),
                scns = scn && $(scn).children().toArray();
          
            if (!box || !scn || !scns.length) return;

            var nav, navs, pn, prev, next, text,
                titles = [],
                sType = cf.slideType,
                imgs = $('img', scn),
                cnWidth = box.offsetWidth,
                cnHeight = box.offsetHeight,
                count = scount = scns.length,

            createEle = function (s) {
                return document.createElement(s || 'div');
            },

            //创建选项标题
            createText = function () {
                text = createEle();
                text.style.overflow = "hidden";
                text.innerHTML = "<p>" + titles[0] + "</p>";
                cf.idText && (text.id = cf.idText);
                cf.clsText && (text.className = cf.clsText);
                box.appendChild(text);
            },

            //创建导航菜单
            createNav = function () {
                var liHtml = "", li = cf.eleNavChild;
                nav = createEle(cf.eleNav);
                cf.clsNav && (nav.className = cf.clsNav);
                cf.idNav && (nav.id = cf.idNav);
                for (var i = 0; i < scount; i++) {
                    liHtml += "<" + li + " title=\"" + (i + 1) + "\">" + (i + 1) + "</" + li + ">";
                }
                nav.innerHTML = liHtml;
                box.appendChild(nav)
            },

            //创建导航切换按钮
            createPn = function () {
                pn = createEle();
                pn.className = cf.clsPn;
                pn.innerHTML =
                '<a href="javascript:;" class="' + cf.clsPrev + '">' + cf.prevText + '</a>' +
                '<a href="javascript:;" class="' + cf.clsNext + '" >' + cf.nextText + '</a>';
                box.appendChild(pn);
            };

            //存储this属性
            $.extend(me, {
                scn: scn,
                scns: scns,
                $scn: $(scn),
                $scns: $(scns),
                count: count,     // 子元素数量
                scount: scount,   // 实际一次滚动的子元素数量
                slideFns: [],     // 每次滑动要执行的函数队列
                titles: titles,
                cnWidth: cnWidth,
                cnHeight: cnHeight,
                sWidth: scns[0].offsetWidth || cnWidth,
                sHeight: scns[0].offsetHeight || cnHeight,
                activeIndex: cf.activeIndex

            });

            //设置布局
            me._slideLayouts[sType] && me._slideLayouts[sType].call(this);
            $.each(scns, function () {
                this.style.width = me.sWidth + "px";
            });
            scn.style.position = "relative";


            //是否创建某些组件
            if (cf.isShowNav) {
                nav = get(cf.idNav, cf.clsNav, box, 'ol');
                !nav && createNav();
            }

            if (cf.isShowText) {
                for (var i = 0; i < imgs.length; i++) {
                    titles[i] = imgs[i].title || "";
                }
                text = get(cf.idText, cf.clsText, box);
                !text && createText();
            }

            if (cf.isShowPn) {
                pn = get(cf.idPn, cf.clsPn, box) ;
                !pn && createPn();
                prev = $('.' + cf.clsPrev, pn);
                next = $('.' + cf.clsNext, pn);
            }

            //dom 属性
            me.dom = {
                box: box,
                scn: scn,
                scns: scns,
                nav: nav,
                pn: pn,
                prev: prev,
                next: next,
                imgs: imgs,
                text: text
            };

            return this;
        },
        //绑定事件
        _bindEvent: function () {
            var me = this,
                cf = me.cf,
                dom = me.dom,
                cls = cf.clsActive;

          
            //绑定导航列菜单按钮事件
            if (cf.isShowNav) {
                
                var $navs = $(dom.nav).children();
                $navs.eq(cf.activeIndex).addClass(cls);
                $navs.on(cf.activeEvent, function () {
                    me.slideTo($navs.index(this));
                    return false;
                })

                //绑定选中导航事件
                me.slideFns.push(function (i) {
                    $navs.eq(i).addClass(cls).siblings().removeClass(cls);
                });
            }

            //绑定左右导航按钮事件
            if (cf.isShowPn) {
                $(dom.prev).on("click", function () {
                    me.slidePrev();
                });
                $(dom.next).on("click", function () {
                    me.slidePrev();
                });
            }

            //是否执行标题滑动动画
            if (cf.isShowText && cf.isRunText) {
                me.hText = dom.text.offsetHeight;
                me.dom.textp = $('p', dom.text)[0];
                me.slideFns.push(function (active) {
                    var $text = $(dom.text),
                        sp = cf.speed / 2;
                    $text.stop().animate({ height: 0 }, sp, cf.easing, function () {
                        $text.stop().animate({ height: me.hText }, sp, cf.easing);
                    });
                    me.dom.textp.innerHTML = me.titles[active];

                });
            }
        }

    };

    //滑动函数配置
    ytSlider.defaults = {
        idBox: null,                         // 滑动容器的 id名称
        idScn: null,                         // 滑动容器内容的 id 名称
        idNav: null,                         // 导航按钮父节点的 id 名称
        idText: null,                        // 选项标题容器 id 名称
        idPn: null,                          // 左右切换按钮父节点的 id 名称
        clsScn: "slider-scn",                 // 滑动内容块样 className 称
        clsText: "slider-txt",               // 选项标题容器 className 名称
        clsNav: "slider-nav",                // 导航容器 className 名称
        clsPn: "slider-pn",                  // 左右切换按钮父节点的 className 名称
        clsPrev: "slider-prev",                  // 左右切换按钮左按钮的 className名称
        clsNext: "slider-next",                  // 左右切换按钮右按钮的 className名称
        clsActive: "active",                 // 导航按钮当前选中的 className 样式
        eleNav: "ol",                        // 自动创建的导航节点元素
        eleNavChild: "li",                   // 自动创建的导航节点子元素
        activeEvent: "mouseover",            // 导航按钮的激发事件 click mouseover
        prevText: "",                        // 上一项文本
        nextText: "",                        // 下一项文本
        isShowText: false,                   // 是否显示模块标题
        isRunText: true,                     // 标题是否动画
        isShowPn: true,                      // 是否显示左右切换按钮
        isShowNav: true,                     // 是否显示导航按钮
        slideType: "left",                   // 滑动类型 枚举值 left top fade
        slideAuto: true,                     // 默认自动滑动
        activeIndex: 0,                      // 默认开始索引
        speed: 300,                          // 滑动速度
        delay: 5000,                         // 切换等待时间间隔
        easing: null,                        // 滑动时的缓动函数
        initBefore: null,                    // 函数初始化前的回调函数
        initAfter: null,                     // 函数初始化后的回调函数
        slideBefore: null,                   // 一次切换执行前的回调函数
        slideAfter: null                      // 一次切换执行好后的回调函数
    };

    ytSlider.prototype._init.prototype = ytSlider.prototype;
    window.ytSlider = ytSlider;

})(window,jQuery);


