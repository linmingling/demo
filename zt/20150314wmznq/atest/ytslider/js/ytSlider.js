/*
ytSlider heqing0712@126.com
Date:2015-03-02 15:16:29
*/
; (function (window, undefined) {
   
    /*
    $ DOM操作 模拟jquery
   */
    var $ = function (selector, context) {
        return new $.fn.init(selector, context);
    },
    isQsAll = !!document.querySelectorAll,
    isOpacity = 'opacity' in document.documentElement.style,
    ralpha = /alpha\([^)]*\)/i,
    ropacity = /opacity=([^)]*)/;

    $.fn=$.prototype = {
        constructor: $,
        length: 0,
        init: function (selector, context) {

            if (!selector) return;
            context = [context || document];
            var l = context.length;

            if (l == 1 && context[0].constructor === $)
                context[0] = context[0][0];

            if (selector.nodeType) {
                this[this.length++] = selector;
                return this;
            }

            if (selector.length && selector[0] && selector[0].nodeType) {
                $.each(selector,function (i,ele) {
                    this[this.length++] = ele;
                }, this);
                return this;
            }

            if ('#' === selector.charAt(0)) {
                this[this.length++] = context[0].getElementById(selector.substr(1));
                return this;
            }

            if (/\s/.test(selector)) {
                if (isQsAll)
                    return $(document.querySelectorAll(selector),context[0]);
                var selectorA = selector.split(/\s/);
                context = [].slice.call($(selectorA[0]));
                return $(selectorA[1], context);
            }

            var isClass = '.' === selector.charAt(0),
                 isQs = isQsAll && isClass,
                 isTest = !isQsAll && isClass,
                 pattern = isTest &&  new RegExp("(^|\\s)" + selector.substr(1) + "(\\s|$)"),
                 eles = [], j, n;

            for (var i = 0; i < l; i++) {
                eles =isQs ? 
                    context[i].querySelectorAll(selector) :
                    context[i].getElementsByTagName((isClass && "*") || selector);
                n = eles.length;
                for (j = 0; j < n; j++) {
                    if (isTest && !pattern.test(eles[j].className)) continue;
                    this[this.length++] = eles[j];
                }
            }

            return this;
        },
        /*
        遍历元素
        @param {Object||Array} 对象或数组  如果 方法只有一个参数 会默认为 实例的DOM的
        @param {Function}  迭代器 遍历回调函数
        @param {Object} 作用域环境 默认是 实例环境
        */
        each: function (obj, iterator, context) {
            if (typeof obj === 'function') {
                iterator = obj;
                obj = [].slice.call(this);
            }
            $.each(obj, iterator, context || this);
        },

        /*
        设置元素样式 
        @param {String||Object} name 属性名称 或属性和值的对象
        @param {String} value 属性值
        */
        css: function (name, value) {
            var opts = {};
            typeof name === 'object' ?  opts = name : opts[name] = value;
            this.each(function (n,ele) {
                for (var i in opts) {
                    i === 'opacity' ?
                    $.opacity.set(ele, opts[i]) :
                    ele.style[i] = opts[i] ;
                }
            });
            return this;
        },

        /*隐藏元素*/
        show: function () {
            return this.css("display", 'block');
        },

        /*显示元素*/
        hide: function () {
            return this.css("display", 'none');
        },

        /*
      动画函数
      @param {Object} cf 执行的动画属性集合
      @param {Number} speed 动画速度 默认400
      @easing {Function} easing 动画的缓动函数
      @easing {Function} callBack 动画执行完后的回调函数
      */
        animate: function (cf, speed, easing, callBack) {
            speed = speed || 400;
            easing = typeof easing === 'function' ? easing :
                $.easing[easing] ? $.easing[easing] :
                $.easing.swing;

            var me = this,
                nt = easing === $.easing['ease'],
                st = !nt ? 13 : 25,
                sf = function (ele) {
                    var _cf = {};
                    for (var i in cf) {
                        _cf[i] = { from: +$.css(ele, i), to: cf[i] }
                    }
                    return _cf;
                },
                sv = function (opt) {
                    var es,val,to,isOp
                    $.each(opt.scf, function (i,s) {
                        es = opt.es || easing(opt.ts, opt.times, 0, 1, speed),
                        val = s.from + ((s.to - s.from) * es),
                        isOp = i === 'opacity';
                        if (nt) {
                            s.from = val;
                            to = !isOp
                                 ? Math.round(val)
                                 : Math.round(val * 100) / 100;
                            if (to === s.to) {
                                opt.end = true;
                                val = s.to;
                            }
                        }
                        isOp ?
                        $.opacity.set(opt.ele, val) :
                        opt.ele.style[i] = val + 'px';
                    });
                },
                am = function (i,ele) {
                    var scf = sf(ele),
                        opt = { times: 0, stime: 0, ts: 0, scf: scf, ele: ele },
                        start = function () {
                            opt.times = +new Date() - opt.stime;
                            opt.ts = opt.times / speed;
                            if ((!nt && opt.times >= speed) || (nt && opt.end)) {
                                !nt && (opt.es = 1) && sv(opt);
                                clearInterval(ele.timer);
                                return callBack && callBack.call(me, ele);
                            }
                            sv(opt);
                        };
                    ele.timer = setInterval(start, st);
                    opt.stime = +new Date();
                    return me;
                };
        
            me.each(am);
            return me;
        },

        /*停止动画*/
        stop: function () {
            this.each(function (i,ele) {
                ele.timer && clearInterval(ele.timer) && (ele.timer = null);
            });
            return this;
        },

        /* 获取单个元素
         @param	 {Number}	index 索引
         @return {$}	新的$实例
        */
        eq: function (index) {
            return $(this[index]);
        },
        
        /*将 $ 元素集合转换为数组*/
        toArray: function () {
            return [].slice.call(this);
        },

        /*绑定事件
        @param {String} event 事件类型
        @param {Function} fn 绑定的方法
        @param {Object} context 作用域
        */
        on: function (even, fn,context) {
            this.each(function (i, ele) {
                var _fn = function () { fn.call(context || ele, i); };
                ele.addEventListener ?
                ele.addEventListener(even, _fn) :
                ele.attachEvent('on' + even, _fn);
            });
            return this;
        },

        /*获取子元素
        @param {Element} noEle 不包括
        */
        children: function (noEle) {
            var childs = [];
            this.each(function (i,ele) {
                $.each(ele.childNodes, function (i,s) {
                    (s.parentNode === ele && s.nodeType == 1 && s !== noEle) && childs.push(s);
                });
            });
            return $(childs);
        },

        /*兄弟节点元素
        @return $ 节点对象
        */
        siblings: function () {
            return $(this[0].parentNode).children(this[0]);
        },

        /*判断DOM元素的样式是否存在
        @param {Object} ele DOM节点元素对象
        @param {String} name 样式名称
        */
        hasClass: function (name) {
            return (' ' + this[0].className + ' ').indexOf(' ' + name + ' ') > -1;
        },

        //添加样式
        addClass: function (name) {
            this.each(function (i,ele) {
                if (!$(ele).hasClass(name))   ele.className += (ele.className && ' ' || '') + name;
            });
            return this;
        },

        /*移除样式*/
        removeClass: function (name) {
            this.each(function (i,ele) {
                ele.className = !name ? "" :
                    $(ele).hasClass(name) ?
                    ele.className.replace(name, ' ') :
                    ele.className;
            });
            return this;
        }
    };

    /*遍历元素
    @param {Object||Array} 对象或数组 
    @param {Function}  迭代器 遍历回调函数
    @param {Object} 作用域环境 默认是 实例环境
    */
    $.each = function (obj, iterator, context) {
        if (obj == null) return;
        if (obj.length === +obj.length) {
            for (var i = 0, l = obj.length; i < l; i++) {
                if (iterator.call(context || obj[i], i, obj[i], obj) === false)
                    return false;
            }
        } else {
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {
                    if (iterator.call(context || obj[key], key, obj[key], obj) === false)
                        return false;
                }
            }
        }
    };

    /*
    将source对象复制到 target对象上
    @param {Object} t 目标对象
    @param {Object} s 源对象
    @param {Boolean} b 是否 覆盖目标对象的属性 
    @return {Object} 目标对象
    */
    $.extend = function (t, s, b) {
        if (s) {
            for (var k in s) {
                (!b || !t.hasOwnProperty(k)) && (t[k] = s[k])
            }
        }
        return t;
    };

    /*缓动函数*/
    $.easing = {
        linear: function (p) {
            return p;
        },
        ease: function () {
            return 1 / 5;
        },
        swing: function (p) {
            return (-Math.cos(p * Math.PI) / 2) + 0.5;
        },
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t = t / d - 1) * t * t * t - 1) + b;
        },
    };
    
    /*获取元素样式*/
    $.css = function (a, c) {
        return c === "opacity" ?
            $.opacity.get(a) :
            parseInt(a.currentStyle ?
            a.currentStyle[c] :
            getComputedStyle(a, false)[c]);
    };

    /*跨浏览器处理opacity*/
    $.opacity = {
        get: function (elem) {
            return isOpacity ?
                document.defaultView.getComputedStyle(elem, false).opacity :
                ropacity.test((elem.currentStyle
                    ? elem.currentStyle.filter
                    : elem.style.filter) || '')
                    ? (parseFloat(RegExp.$1) / 100) + ''
                    : 1;
        },
        set: function (elem, value) {
            if (isOpacity) return elem.style.opacity = value;
            var style = elem.style;
            style.zoom = 1;
            var opacity = 'alpha(opacity=' + value * 100 + ')',
                filter = style.filter || '';
            style.filter = ralpha.test(filter) ?
                filter.replace(ralpha, opacity) :
                style.filter + ' ' + opacity;
        }
    };

    $.fn.init.prototype = $.prototype;

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
            !this.dom && this._setDOM();

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
           return   this.slideTo(this.activeIndex-1);
        },

        //下一模块
        slideNext: function () {
           return this.slideTo(this.activeIndex+1);
        },

        //执行滑动
        slideTo: function (index) {

            if (index === this.activeIndex) return;
            var me = this,
                cf = me.cf,
                active = me.activeIndex,
                scount = me.scount;
                index = index === undefined
                        ? active
                        : index < 0
                        ? scount - 1
                        : index > scount - 1
                        ? 0 : index;
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
                var me = this,style = me.scn.style;
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
                $.each(me.scns, function (i,ele) {
                        ele.style.height = me.sHeight + "px";
                        ele.style['float'] = "none"
                });
            },

            //淡入淡出
            fade: function () {
                $.each(this.scns, function (i,ele) {
                    var o = 0, z = 1;
                    i === this.cf.activeIndex && (o = 1) && (z = 2);
                    $(ele).css({ opacity: o, position: 'absolute', 'z-index': z, left: 0, top: 0 });
                },this);
            }
        },

        //设置DOM节点
        _setDOM: function () {

            if (this.dom) return;

            var me = this,
                cf = me.cf,
                box = $('#' + cf.idBox)[0],
                get = function (id, cls, pele, ena) {
                    return id && $('#' + id)[0] ||
                        cls && $('.' + cls, pele)[0] ||
                        ena && $(ena, pele)[0];
                },
                scn = get(cf.idScn, cf.clsScn, box, 'ul'),
                scns = scn && $(scn).children().toArray();

            if (!box || !scn|| !scns.length) return;

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
                     liHtml += "<" + li+ " title=\"" + (i + 1) + "\">" + (i + 1) + "</" + li + ">";
                 }
                 nav.innerHTML = liHtml;
                 box.appendChild(nav);
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
                cnHeight:cnHeight,
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
                nav = get(cf.idNav, cf.clsNav, box,'ol');
                !nav && createNav();
            }

            if (cf.isShowText) {        
                text = get(cf.idText, cf.clsText, box);
                !text && createText();
                for (var i = 0; i < imgs.length; i++) {
                    titles[i] = imgs[i].title || "";
                }
            }

            if (cf.isShowPn) {
                pn = get(cf.idPn, cf.clsPn, box);
                !pn && createPn();
                prev = $('.' + cf.clsPrev, pn)[0];
                next = $('.' + cf.clsNext, pn)[0];
            }
     
            //dom 属性
            me.dom = {
                box: box,
                scn: scn,
                scns: scns,
                nav: nav,
                pn: pn,
                prev:prev,
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
                $navs.on(cf.activeEvent, function (i) {
                    me.slideTo(i);
                    return false;
                })
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
                    $text.stop().animate({ height: 0 }, sp, cf.easing,function () {
                        $text.stop().animate({ height: me.hText }, sp,cf.easing);
                    });
                    me.dom.textp.innerHTML = me.titles[active];
           
                });
            }

        }
    };

    //滑动函数配置
    ytSlider.defaults = {
        idBox: null,                         // 滑动容器的id名称
        idScn: null,                         // 滑动容器内容的 id 名称
        idNav: null,                         // 导航按钮父节点的 id 名称
        idText: null,                        // 选项标题容器 id 名称
        idPn: null,                          // 左右切换按钮父节点的 id 名称
        clsScn: "slider-scn",                // 滑动内容块样 className 称
        clsText: "slider-txt",               // 选项标题容器 className 名称
        clsNav: "slider-nav",                // 导航容器 className 名称
        clsPn: "slider-pn",                  // 左右切换按钮父节点的 className 名称
        clsPrev: "slider-prev",              // 左右切换按钮左按钮的 className名称
        clsNext: "slider-next",              // 左右切换按钮右按钮的 className名称
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
        slideAuto:true ,                     // 默认自动滑动
        activeIndex: 0,                      // 默认开始索引
        speed: 300,                          // 滑动速度
        delay: 5000,                         // 切换等待时间间隔
        easing: null,                        // 滑动时的缓动函数
        initBefore: null,                    // 函数初始化前的回调函数
        initAfter: null,                     // 函数初始化后的回调函数
        slideBefore: null,                   // 一次切换执行前的回调函数
        slideAfter: null                     // 一次切换执行好后的回调函数
    };

    ytSlider.prototype._init.prototype = ytSlider.prototype;
    window.ytSlider = ytSlider;

})(window);


