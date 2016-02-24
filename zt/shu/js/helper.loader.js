
(function(){
    var EventUtil = {
        addHandler: function(element, type, handler) {
            if (element.addEventListener) {
                element.addEventListener(type, handler, false);
            } else if (element.attachEvent) {
                element.attachEvent("on" + type, handler);
            } else {
                element["on" + type] = handler;
            }
        }
    }

    var helper_publish = {
        loader : function(url,callback){
            var the = this;
            var script = document.createElement("script");
            script.type = "text/javascript";
            if (script.readyState) {
                script.onreadystatechange = function() {
                    if (script.readyState == "loaded" || script.readyState == "complete") {
                        script.onreadystatechange = null;
                        script.parentNode.removeChild(script);
                    }
                }
            } else {
                script.onload = function() {
                    script.parentNode.removeChild(script);
                }
            }
            var cb = this.callback(callback);
            script.src = url + "callback=helper_publish." + cb + "&_=" + (new Date).getTime();
            document.getElementsByTagName("head")[0].appendChild(script);
        },

        callback: function(callback) {
            var cb;
            if (typeof callback == 'string' && callback !== '') {
                cb = callback;
            } else if (typeof callback == 'function') {
                cb = 'callback' + (new Date).getTime() + '_' + Math.round(Math.random() * 100000);
                helper_publish[cb] = callback;
            }
            return cb;
        },
    };
    window.helper_publish = helper_publish;

    EventUtil.addHandler(window, 'load', function() {
        function e() {
            if (!window.helper) {
                var e = document.createElement("script");
                e.type = "text/javascript", e.src = "http://cdn0.ljimg.com/helper/js/helper.main.js", document.getElementsByTagName("head")[0].appendChild(e)
            }
        }
        window.cookie || (window.cookie = function(e, t, n) {
            if (arguments.length > 1 && String(t) !== "[object Object]") {
                if (t === null || t === undefined) n.expires = -1;
                if (typeof n.expires == "number") {
                    var r = n.expires,
                        i = n.expires = new Date;
                    i.setDate(i.getDate() + r)
                }
                return t = String(t), document.cookie = [encodeURIComponent(e), "=", n.raw ? t : encodeURIComponent(t), n.expires ? "; expires=" + n.expires.toUTCString() : "", n.path ? "; path=" + n.path : "", n.domain ? "; domain=" + n.domain : "", n.secure ? "; secure" : ""].join("")
            }
            n = t || {};
            var s, o = n.raw ? function(e) {
                return e
            } : decodeURIComponent;
            return (s = (new RegExp("(?:^|; )" + encodeURIComponent(e) + "=([^;]*)")).exec(document.cookie)) ? o(s[1]) : null
        });
        if (cookie("admin_permit")) {
            e();
        }else if(/(jiaju)/.test(location.host)){
            helper_publish.loader('http://s.pub.leju.com/api/dochelper/getuseradminpermit?', function(data) {
                if(data.status){
                    var str = '';
                    for(var attr in data.params.admin_permit){
                        str += data.params.admin_permit[attr];
                    }
                    cookie("admin_permit",str,1);
                    e();
                }
            })
        }else {
            var t = helperCount = 0;
            document.onkeypress = function(n) {
                var r, n = n || window.event;
                n.which == null ? r = String.fromCharCode(n.keyCode) : n.which != 0 && n.charCode != 0 && (r = String.fromCharCode(n.which)), r === "h" ? (helperCount += 1, t || (t = window.setTimeout(function() {
                    window.console && window.console.log(helperCount), helperCount > 30 && e()
                }, 2e3))) : (document.onkeypress = null, t && window.clearTimeout(t))
            }
        }
    });
})();