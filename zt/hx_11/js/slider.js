//http://www.beijingleather.com.cn/  xiaohe
(function (window) {

    var ytSlider = function (_cf) {

        if (!_cf) { return; }

        var cf = function () {
            var o = {};
            for (var i in ytSlider.defaultx) {
                o[i] = ytSlider.defaultx[i];
            }
            return o;
        }();

        if (typeof _cf === 'string') {
            cf.id = _cf;
        }
        else {
            for (var i in cf) {
                (_cf[i] !== undefined) && (cf[i] = _cf[i]);
            }
        }
        if (!cf.id) {
            return;
        }

        return new ytSlider.prototype.init(cf);
    };
    ytSlider.prototype = {

        bind: function (even, obj, fn) {
            if (!obj) { return; }
            var _fn = function () {
                fn.call(obj);
            };
            if (obj.attachEvent) {
                obj.attachEvent('on' + even, _fn);
            }
            else {
                obj.addEventListener(even, _fn);
            }
        },
        getType: function (obj) {
            return Object.prototype.toString.call(obj).replace(/\[|object|\]|\s/g, '').toLowerCase();
        },
        startMove: function (a, b, c) {
            var me = this;
            a.timer && clearInterval(a.timer);

            a.timer = setInterval(function () {
                var g, d = true;
                for (g in b) {
                    var f = me.getStyle(a, g),
                    e = (b[g] - f) / 5;
                    e = e > 0 ? Math.ceil(e) : Math.floor(e);
                    (f != b[g]) && (d = false);

                    if (g == "opacity") {
                        a.style.filter = "alpha(opacity:" + (f + e) + ")";
                        a.style.opacity = (f + e) / 100
                    } else {
                        a.style[g] = f + e + "px"
                    }
                }
                if (d) {
                    clearInterval(a.timer);
                    c && c();
                }
            },
            50)

        },
        getStyle: function (a, c) {
            var b = "";
            if (a.currentStyle) {
                b = a.currentStyle[c]
            } else {
                b = getComputedStyle(a, false)[c]
            }
            if (c == "opacity") {
                return Math.round(parseFloat(b) * 100)
            } else {
                return parseInt(b)
            }
        },
        children: function (s, p) {
            var _s = [], len = s.length, i = 0;
            for (; i < len; i++) {
                if (s[i].parentNode === p && s[i].nodeType == 1) {
                    _s.push(s[i]);
                }
            }
            return _s;
        },
        G: function (selector, context) {
            context = context || document;
            var _sons = [],
                len = arguments.length,
                _reg = /[#|.]/g,
                _selector = selector.replace(_reg, '');
            if (selector.indexOf('#') > -1 && len == 1) {
                return document.getElementById(_selector);
            }

            if (selector.indexOf('.') > -1) {
                var sons = context.getElementsByTagName("*"),
                   reg = new RegExp("(^|\\s)" + _selector + "(\\s|$)"),
                   l = sons.length,
                   i = 0;
                for (; i < l; i++) {
                    if (sons[i].className && reg.test(sons[i].className)) {
                        _sons.push(sons[i])
                    }
                }
            }
            else if (!_reg.test(selector)) {
                _sons = context.getElementsByTagName(selector);
            }
            return _sons;
        },
        init: function (cf) {
            var me = this,
                sCn = me.G("#" + cf.id);


            if (!sCn) return
            me.cf = cf;
            var sUl = cf.scnId ? me.G("#" + cf.scnId) : me.G("ul", sCn)[0],
            f = me.children(sUl.childNodes, sUl);

            if (!f || f.length < 2) { return; }

            (cf.initBefore) && cf.initBefore.call(me);

            var len = f.length,
            navOl = cf.isShowNav ?
            (cf.navId ?
            me.G("#" + cf.navId) :
            me.G('ol', sCn)[0]) :
            false,
            z = navOl && me.G('li', navOl) || false,
            s = 0,
            timer = null,
            fade = null,
            sType = cf.slideType,
            pn = function () {
                if (cf.pnId) {
                    return me.G("#" + cf.pnId);
                }
                return me.G('.' + cf.pnPCls, sCn);
            }(),
            prev = me.G('.' + cf.prevCls, sCn)[0],
            next = me.G('.' + cf.nextCls, sCn)[0];

            cf.width = +f[0].offsetWidth;
            cf.height = +f[0].offsetHeight;
     
            me.scns = f;
            me.snavs = z;
            me.count = len;
            me.index = s;

            if (z && z.length < 1) {
                z = false;
            }
            if (sType === 'left') {
                sUl.style.width = cf.width * len + "px";
            }
            else if (sType === 'top') {
                sUl.style.height = cf.height * len + "px";
            }
            else if (sType === 'fade') {

                fade = function (n) {
                    for (var i = 0; i < len; i++) {
                        if (i !== n) {
                            f[i].style.display = 'none';
                            f[i].style.filter = "alpha(opacity:0)";
                            f[i].style.opacity = "0";
                        }
                    }
                    f[n].style.display = "block";
                    me.startMove(f[n], {
                        opacity: "100"
                    })
                };
            }


            if (z) {
                z[0].className = cf.activeCls;
                for (h = 0; h < z.length; h++) {
                    z[h].index = h;
                    (function (k) {
                        me.bind(cf.activeEvent, z[k], function () {
                            s = this.index;
                            me.index = s;
                            u();
                            return false;
                        })
                    }(h));
                }
            }
            var ts = function () {
                var st = cf.slideType;
                if (st === 'left') {
                    me.startMove(sUl, {
                        left: -cf.width * s
                    })

                }
                else if (st === 'top') {

                    me.startMove(sUl, {
                        top: -cf.height * s
                    })
                }
                else if (st === 'fade') {
                    fade(s);
                }
            };
            if (cf.wait > -1) {
                timer = setInterval(b, cf.wait);
                me.bind('mouseover', sCn, function () {
                    clearInterval(timer)
                })
                me.bind('mouseout', sCn, function () {
                    timer = setInterval(b, cf.wait)
                })
            }
           

            if (cf.isShowPN) {

                me.bind("click", prev, function () {

                    s = s == 0 ? len - 1 : s - 1;
                    me.index = s;
                    u();

                })
                me.bind("click", next, function () {
                    s = s == len - 1 ? 0 : s + 1;
                    me.index = s;
                    u();

                })
            }
            else {
                (pn&&pn.length>0)&&pn.parentNode.removeChild(pn);
            }

            function u() {

                cf.slideBefore && cf.slideBefore.call(me, s);

                if (z) {
                    var h = z.length;
                    while (h--) {
                        z[h].className = ""
                    }
                    z[s] && (z[s].className = cf.activeCls);
                }
                ts();
                cf.slideAfter && cf.slideAfter.call(me, s);
            }

            function b() {
                u();
                (s++ == len - 1) && (s = 0);
                me.index = s;
            }

            if (cf.startIndex > 0 && cf.startIndex < len) {
                s = cf.startIndex;
                me.index = s;
                u();
            }
            cf.initAfter && cf.initAfter.call(me,s);

          

            return {
                count:len,
                slideTo: function (n) {
                    if (n < 0 || n > len - 1) {
                        return false;
                    }
                    s = n;
                    me.index = n;
                    u();
                },
                slidePrev: function () {
                    if (me.index == 0) { return false; }
                    me.index -= 1;
                    s = me.index;
                    u();
                },
                slideNext: function () {
                    if (me.index == len-1) { return false; }
                    me.index += 1;
                    s = me.index;
                    u();
                },
                index: function () {
                    return me.index;
                }

            }
        }

    };
    ytSlider.defaultx = {

        id: null,                            //String 滑动容器的 id名称
        scnId: null,                         //String 滑动容器内容的 id 名称
        navId: null,                         //String 导航按钮父节点的 id名称
        pnId: null,                          //String 左右切换按钮父节点的 id名称
        pnPCls: "pn",                        //String 左右切换按钮父节点的样式 class名称
        prevCls: "pn-prev",                  //String 左右切换按钮左按钮的样式 class名称
        nextCls: "pn-next",                  //String 左右切换按钮右按钮的样式 class名称
        activeCls: "active",                 //String 导航按钮当前选中的样式
        activeEvent: "mouseover",            //String 导航按钮的激发事件 click mouseover
        isShowPN: true,                      //Boolean 是否显示左右切换按钮
        isShowNav: true,                     //Boolean 是否显示导航按钮
        slideType: "left",                   //String left top 
        startIndex: 0,                       //Number 默认开始索引
        wait: 5000,                          //Number 切换等待时间间隔
        initBefore: null,                    //fn 函数初始化前的回调函数
        initAfter: null,                     //fn 函数初始化后的回调函数
        slideBefore: null,                   //fn 一次切换执行前的回调函数
        slideAfter: null,                    //fn 一次切换执行好后的回调函数
        goIndex:null                         //gn 跳转到指定模块


    };


    ytSlider.prototype.init.prototype = ytSlider.prototype;
    window.ytSlider = ytSlider;



})(window);
