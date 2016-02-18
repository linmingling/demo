

//省市区初始化
$(function(){ 
    var _prov=document.getElementById("prov"); 
    for(var e in list){ 
    var opt_1=new Option(list[e].province,list[e].province); 
    _prov.add(opt_1); 
    } 
    
    
} );



function toProvince(){ 
var _prov=document.getElementById("prov"); 
var _city=document.getElementById("city"); 
var _dist=document.getElementById("dist"); 
var v_prov=_prov.value; 

_city.options.length=1; 
_dist.options.length=1; 

    for(var e in list){ 

        if(list[e].province==v_prov){   
            for( var p in list[e].city){ 
            // console.log(list[e].province);   
            var opt_2=new Option(list[e].city[p].name,list[e].city[p].name); 
            _city.add(opt_2); 

            } 
            break; 
        } 
    } 
} 


function toCity(){ 
var _prov=document.getElementById("prov"); 
var _city=document.getElementById("city"); 
var _dist=document.getElementById("dist"); 

var v_prov=_prov.value; 
var v_city=_city.value; 

//_city.options.length=1; 
_dist.options.length=1; 


    for(var e in list){ 
        if(list[e].province==v_prov){ 
            for( var p in list[e].city){ 
                if(list[e].city[p].name==v_city){ 
                     
                     if(list[e].city[p].dist==null){
                        //console.log(list[e].city[p].dist); 全市不限区
                        _dist.add(new Option('全市','全市')); 
                     }
                     else{
                        for(var cc in list[e].city[p].dist){ 
                            var opt_3=new Option(list[e].city[p].dist[cc].name,list[e].city[p].dist[cc].name); 
                            _dist.add(opt_3); 
                        } 
                    }

                    return; 
                } 


            } 
            break; 
        } 
    } 
} 


//坑爹省市区数据
var list=[{"province":"广东", 
"city":[
{"name":"深圳市"}, 

{"name":"东莞市",
"dist":[{"name":"寮步镇"}, 
{"name":"石碣镇"}, 
{"name":"龙石镇"}]}, 

{"name":"珠海市", 
"dist":[{"name":"香洲区"}, 
{"name":"三乡区"}, 
{"name":"前山区"}]},

{"name":"中山市", 
"dist":[{"name":"石岐区"}, 
{"name":"小榄镇"}, 
{"name":"东升镇"}]},

{"name":"惠州市", 
"dist":[{"name":"惠阳区"}, 
{"name":"惠东县"}, 
{"name":"博罗县"},
{"name":"仲恺高新区"},
{"name":"龙门县"}]},

{"name":"揭阳市", 
"dist":[{"name":"惠来县"}, 
{"name":"普宁市"}]},

{"name":"汕头市", 
"dist":[{"name":"潮阳区"}]},

{"name":"梅州市", 
"dist":[{"name":"大埔县"}, 
{"name":"蕉岭县"}, 
{"name":"梅县"}]},

{"name":"汕尾市", 
"dist":[{"name":"陆丰市"}]},

{"name":"河源市", 
"dist":[{"name":"龙川县"}, 
{"name":"和平县"}, 
{"name":"连平县"},
{"name":"紫金县"}]},

{"name":"韶关市", 
"dist":[{"name":"武江区"}, 
{"name":"乐昌"}, 
{"name":"仁化"},
{"name":"翁源县"}]},

{"name":"清远市", 
"dist":[{"name":"佛冈县"}, 
{"name":"清城区"}]},

{"name":"肇庆市", 
"dist":[{"name":"端州区"}, 
{"name":"四会市"}]},

{"name":"湛江市"}, 

{"name":"江门市", 
"dist":[{"name":"新会区"}, 
{"name":"台山市"}, 
{"name":"鹤山市"}]},

{"name":"阳江市", 
"dist":[{"name":"江城区"}]},

{"name":"茂名市", 
"dist":[{"name":"电白县"}]},

{"name":"广州市", 
"dist":[{"name":"海珠区"}, 
{"name":"天河区"}, 
{"name":"黄埔区"},
{"name":"荔湾区"},
{"name":"从化市"},
{"name":"增城荔城镇"},
{"name":"增城新塘镇"},
{"name":"番禺区"}]},

{"name":"佛山市", 
"dist":[{"name":"三水区"}, 
{"name":"禅城区"}]}

]
}, 

{"province":"海南", 
"city":[
{"name":"海口市"},

{"name":"琼海市"},

{"name":"三亚市"}

] 
},

{"province":"江苏", 
"city":[
{"name":"宜兴市"},

{"name":"镇江市"},

{"name":"苏州市", 
"dist":[{"name":"苏州市市区"}, 
{"name":"昆山"}, 
{"name":"常熟"}]},

{"name":"无锡市", 
"dist":[{"name":"无锡市市区"}, 
{"name":"江阴市"}]},

{"name":"如皋市"},

{"name":"扬州市"},

{"name":"连云港市", 
"dist":[{"name":"新浦区"}, 
{"name":"东海县"}]},

{"name":"宿迁市", 
"dist":[{"name":"义乌市"}]},

{"name":"泰州市", 
"dist":[{"name":"海陵区"},
{"name":"高港区"},
{"name":"姜堰区"},
{"name":"靖江市"},
{"name":"泰兴市"},
{"name":"兴化市"}]},

{"name":"徐州市", 
"dist":[{"name":"徐州市市区"}, 
{"name":"新沂县"}, 
{"name":"睢宁县"}]},

{"name":"淮安市"},

{"name":"张家港市"},

{"name":"盐城市", 
"dist":[{"name":"大丰市"}, 
{"name":"亭湖区"}, 
{"name":"滨海县"},
{"name":"盐都区"},
{"name":"响水"},
{"name":"阜宁"},
{"name":"射阳"},
{"name":"建湖"},
{"name":"东台"}]},

{"name":"常州市"},

{"name":"南通市", 
"dist":[{"name":"南通市市区"}, 
{"name":"祁东县"}]},

{"name":"南京市", 
"dist":[{"name":"南京市市区"}, 
{"name":"溧水县"}]}

] 
},

{"province":"浙江", 
"city":[
{"name":"温州市"},

{"name":"衢州市"},

{"name":"金华市", 
"dist":[{"name":"东阳市"},
{"name":"金东区"}]},

{"name":"杭州市", 
"dist":[{"name":"拱墅区"},
{"name":"上城区"},
{"name":"下城区"},
{"name":"江干区"},
{"name":"西湖区"},
{"name":"滨江区"},
{"name":"萧山"},
{"name":"余杭"},
{"name":"富阳"},
{"name":"桐庐"},
{"name":"建德"},
{"name":"淳安"},
{"name":"临安"}]},

{"name":"嘉兴市"},

{"name":"湖州市", 
"dist":[{"name":"长兴县"}, {"name":"德清县"}, 
{"name":"南浔区"}]},

{"name":"宁波市", 
"dist":[{"name":"象山县"}]}

] 
},

{"province":"山东", 
"city":[
{"name":"青岛市"},

{"name":"威海市", 
"dist":[{"name":"环翠区"},
{"name":"荣成市"},
{"name":"文登市"}]},

{"name":"莱阳市"},

{"name":"烟台市", 
"dist":[{"name":"烟台市市区"}, 
{"name":"栖霞市"}]},

{"name":"临沂市", 
"dist":[{"name":"临沂市市区"},
{"name":"临沭县"}, 
{"name":"沂南县"}, 
{"name":"沂水县"}]},

{"name":"潍坊市", 
"dist":[{"name":"青州市"}, 
{"name":"寿光市"}]},

{"name":"济宁市"},

{"name":"泰安市", 
"dist":[{"name":"泰安市市区"}, 
{"name":"肥城市"}]},

{"name":"菏泽市", 
"dist":[{"name":"郓城县"}]},

{"name":"淄博市", 
"dist":[{"name":"淄川区"}]},

{"name":"滨州市", 
"dist":[{"name":"滨州市市区"}, 
{"name":"邹平市"}]},

{"name":"聊城市", 
"dist":[{"name":"冠县"}]},

{"name":"德州市"},

{"name":"东营市", 
"dist":[{"name":"东营市市区"}, 
{"name":"广饶县"}]},

{"name":"莱芜市"},

{"name":"济南市"},

{"name":"枣庄市", 
"dist":[{"name":"枣庄市市区"}]}

] 
},

{"province":"安徽", 
"city":[
{"name":"蚌埠市", 
"dist":[{"name":"蚌山区"}]},

{"name":"安庆市"},

{"name":"阜阳市"},

{"name":"亳州市", 
"dist":[{"name":"谯城区"}]},

{"name":"芜湖市", 
"dist":[{"name":"无为县"}]},

{"name":"六安市", 
"dist":[{"name":"舒城县"},
{"name":"六安市市区"}]},

{"name":"淮南市", 
"dist":[{"name":"凤台县"}]},

{"name":"滁州市"},

{"name":"合肥市"},

{"name":"宿州市"}

] 
},

{"province":"上海", 
"city":[
{"name":"上海市"}

] 
},

{"province":"黑龙江", 
"city":[
{"name":"大庆市"},

{"name":"哈尔滨市"}

] 
},

{"province":"吉林", 
"city":[
{"name":"长春市", 
"dist":[{"name":"全市"}]},

{"name":"吉林市"},

{"name":"松原市"},

{"name":"四平市"}

] 
},

{"province":"内蒙古（东）", 
"city":[
{"name":"兴安盟"},

{"name":"满洲里市"}

] 
},

{"province":"辽宁", 
"city":[
{"name":"沈阳市"},

{"name":"大连市"},

{"name":"盘锦市"},

{"name":"鞍山市"},

{"name":"葫芦岛市", 
"dist":[{"name":"龙港区"},
{"name":"绥中县"}]},

{"name":"阜新市"},

{"name":"锦州市", 
"dist":[{"name":"义县"}]},

{"name":"铁岭市"}

] 
},

{"province":"北京", 
"city":[
{"name":"北京市", 
"dist":[{"name":"东城区"},
{"name":"西城区"},
{"name":"海淀区"},
{"name":"朝阳区"},
{"name":"丰台区"},
{"name":"宣武区"},
{"name":"崇文区"},
{"name":"门头沟区"},
{"name":"石景山区"},
{"name":"房山区"},
{"name":"通州区"},
{"name":"顺义区"},
{"name":"昌平区"},
{"name":"大兴区"},
{"name":"怀柔区"},
{"name":"平谷区"},
{"name":"延庆县"},
{"name":"密云县"}]}

] 
},

{"province":"天津", 
"city":[
{"name":"天津市", 
"dist":[{"name":"河西区"},
{"name":"南开区"},
{"name":"东丽区"},
{"name":"红桥区"}]}

] 
},

{"province":"山西", 
"city":[
{"name":"运城市"},

{"name":"长治市"},

{"name":"临汾市", 
"dist":[{"name":"尧都区"},
{"name":"侯马市"}]},

{"name":"吕梁市", 
"dist":[{"name":"文水县"},
{"name":"孝义市"},{"name":"交城县"},
{"name":"汾阳县"}]},

{"name":"忻州市", 
"dist":[{"name":"代县"},
{"name":"忻府区"}]},

{"name":"太原市", 
"dist":[{"name":"太原市区"},
{"name":"清徐县"}]},





{"name":"阳泉市"},

{"name":"大同市"},


{"name":"晋中市", 
"dist":[{"name":"榆次区"},{"name":"平遥县"},{"name":"寿阳县"},{"name":"昔阳县"},{"name":"和顺县"},{"name":"东阳县"}]}

] 
},

{"province":"河北", 
"city":[
{"name":"石家庄市"},

{"name":"唐山市"},

{"name":"秦皇岛市"},

{"name":"保定市"},

{"name":"承德市"},

{"name":"沧州市", 
"dist":[{"name":"沧州市"},
{"name":"泊头市"}]},

{"name":"衡水市"},

{"name":"廊坊市", 
"dist":[{"name":"香河县"}]},

{"name":"邢台市"},

{"name":"张家口市"},

{"name":"邯郸市"},

{"name":"任丘市"},

{"name":"霸州市"}

] 
},

{"province":"湖南", 
"city":[
{"name":"常德市", 
"dist":[{"name":"武陵区"},
{"name":"澧县"},
{"name":"石门县"},
{"name":"汉寿县"}]},

{"name":"娄底市", 
"dist":[{"name":"娄底市"},
{"name":"双峰县"}]},

{"name":"郴州市", 
"dist":[{"name":"郴州市"},
{"name":"安仁县"},
{"name":"永兴县"},
{"name":"嘉禾县"},
{"name":"桂阳县"}]},

{"name":"邵阳市", 
"dist":[{"name":"隆回县"},
{"name":"邵东县"},
{"name":"邵阳市区"}]},

{"name":"衡阳市"},

{"name":"长沙市"},

{"name":"株洲市"},

{"name":"怀化市", 
"dist":[{"name":"全市"}]},

{"name":"永州市", 
"dist":[{"name":"冷水滩区"}]},

{"name":"湘西州", 
"dist":[{"name":"古丈县"},{"name":"吉首"},{"name":"龙山"}]},

{"name":"岳阳市"},

{"name":"益阳市"},

{"name":"湘潭市", 
"dist":[{"name":"岳塘区"}]},

{"name":"张家界市"}

] 
},

{"province":"江西", 
"city":[
{"name":"九江市", 
"dist":[{"name":"浔阳区"},
{"name":"修水县"},
{"name":"湖口县"},
{"name":"德安县"},
{"name":"都昌县"}]},

{"name":"吉安市", 
"dist":[{"name":"新干峡江"}]},

{"name":"抚州市"},

{"name":"萍乡市"},

{"name":"南昌市"},

{"name":"景德镇市", 
"dist":[{"name":"景德镇市市区"},
{"name":"乐平市"}]},

{"name":"新余市", 
"dist":[{"name":"新余市"},
{"name":"分宜县"}]},

{"name":"宜春市", 
"dist":[{"name":"袁州区"},
{"name":"上高县"},
{"name":"高安县"},
{"name":"宜丰县"}]},

{"name":"丰城市", 
"dist":[{"name":"丰城市市区"}]},

{"name":"赣州市", 
"dist":[{"name":"宁都县"},
{"name":"瑞金市"},
{"name":"章贡区"},
{"name":"兴国县"},
{"name":"于都县"}]},

{"name":"鄱阳县", 
"dist":[{"name":"鄱阳县"}]},

{"name":"上饶市", 
"dist":[{"name":"信州区"},
{"name":"横峰县"},
{"name":"婺源县"}]}

] 
},

{"province":"福建", 
"city":[
{"name":"龙岩市", 
"dist":[{"name":"上杭县"},{"name":"新罗区"},
{"name":"永定区"}]},

{"name":"莆田市", 
"dist":[{"name":"荔城区"},
{"name":"仙游县"},
{"name":"秀屿区"},
{"name":"涵江区"}]},

{"name":"宁德市", 
"dist":[{"name":"福鼎市"},
{"name":"柘荣县"},
{"name":"东侨经济开发区"},
{"name":"福安市"},
{"name":"霞浦县"}]},

{"name":"福州市", 
"dist":[{"name":"福州市"},
{"name":"闽侯县"},
{"name":"光泽县"}]},

{"name":"厦门市"},

{"name":"南平市", 
"dist":[{"name":"邵武市"}]},

{"name":"三明市", 
"dist":[{"name":"永安市"}]},

{"name":"泉州市"}

] 
},

{"province":"河南", 
"city":[
{"name":"信阳市", 
"dist":[{"name":"羊山新区"},
{"name":"固始县"}]},

{"name":"濮阳市", 
"dist":[{"name":"范县"}]},

{"name":"三门峡市"},

{"name":"平顶山"},

{"name":"郑州市"},

{"name":"周口市"},

{"name":"南阳市", 
"dist":[{"name":"南阳市区"},
{"name":"新野县"}]},

{"name":"邓州市"},

{"name":"开封市", 
"dist":[{"name":"开封市"}]},

{"name":"兰考县"},

{"name":"济源市"},

{"name":"许昌市"},

{"name":"驻马店", 
"dist":[{"name":"遂平县"}]},

{"name":"新乡市", 
"dist":[{"name":"卫辉市"}]},

{"name":"安阳市", 
"dist":[{"name":"林州市"}]}

] 
},

{"province":"湖北", 
"city":[
{"name":"襄阳市", 
"dist":[{"name":"襄阳市区"},{"name":"樊城区"},{"name":"南漳县"},
{"name":"枣阳市"}]},

{"name":"随州市", 
"dist":[{"name":"广水市"}]},

{"name":"十堰市"},

{"name":"荆门市", 
"dist":[{"name":"钟祥市"},
{"name":"荆门市区"}]},

{"name":"仙桃市"},

{"name":"孝感市",
"dist":[{"name":"孝南区"},]},

{"name":"天门市"},

{"name":"武汉市", 
"dist":[{"name":"江夏区"},
{"name":"硚口区"},{"name":"武昌"},{"name":"汉口"},
{"name":"洪山区"}]},

{"name":"黄石市", 
"dist":[{"name":"黄石市"},
{"name":"大冶市"}]},

{"name":"咸宁市", 
"dist":[{"name":"赤壁市"},
{"name":"嘉鱼县"},
{"name":"崇阳县"},
{"name":"通山县"}]},

{"name":"黄冈市", 
"dist":[{"name":"麻城市"},
{"name":"黄州"},
{"name":"英山县"}]},

{"name":"潜江市"},

{"name":"宜昌市"},

{"name":"荆州市", 
"dist":[{"name":"沙市区"},
{"name":"公安县"},
{"name":"洪湖市"}]},

{"name":"丹江口市", 
"dist":[{"name":"全市"}]},

{"name":"恩施市", 
"dist":[{"name":"咸丰县"},
{"name":"利川市"}]}

] 
},

{"province":"广西", 
"city":[
{"name":"玉林市", 
"dist":[{"name":"容县"},
{"name":"北流市"},{"name":"玉州区"},{"name":"福绵区"},{"name":"陆川县"},{"name":"博白县"},{"name":"兴业县"}]},

{"name":"钦州市"},

{"name":"百色市", 
"dist":[{"name":"平果县"},{"name":"右江区"},{"name":"田东县"}]},

{"name":"北海市", 
"dist":[{"name":"海城区"},
{"name":"合浦县"}]},

{"name":"柳州市"},

{"name":"南宁市"},

{"name":"梧州市", 
"dist":[{"name":"岑溪市"},{"name":"蝶山区"},{"name":"长洲区"},{"name":"龙圩区"},{"name":"藤县"},{"name":"苍梧县"}]},

{"name":"贵港市", 
"dist":[{"name":"贵港市"},
{"name":"桂平市"}]},

{"name":"来宾市", 
"dist":[{"name":"象州县"}]},

{"name":"桂林市", 
"dist":[{"name":"叠彩区"},
{"name":"平乐县"},{"name":"秀峰区"},{"name":"象山区"},{"name":"七星区"},{"name":"雁山区"},{"name":"临桂区"},{"name":"阳朔县"},{"name":"全州县"},{"name":"兴安县"},{"name":"灌阳县"},{"name":"龙胜县"},{"name":"荔浦县"},{"name":"恭城县"}]},

{"name":"贺州市", 
"dist":[{"name":"八步区"}]}

] 
},

{"province":"云南", 
"city":[
{"name":"昆明市", 
"dist":[{"name":"昆明市区"},{"name":"晋宁县"},{"name":"石林县"},{"name":"寻甸县"}]},

{"name":"蒙自市"},

{"name":"保山市", 
"dist":[{"name":"龙陵县"},{"name":"施甸县"},{"name":"腾冲县"}]},

{"name":"楚雄州", 
"dist":[{"name":"武定县"}]},
{"name":"大理州", 
"dist":[{"name":"大理市"},{"name":"宾川县"},{"name":"鹤庆县"},{"name":"南涧县"},{"name":"祥云县"}]},
{"name":"德宏州", 
"dist":[{"name":"陇川县"},{"name":"芒市"},{"name":"瑞丽市"},{"name":"盈江县"}]},
{"name":"红河州", 
"dist":[{"name":"开远市"},{"name":"泸西县"},{"name":"弥勒市"}]},
{"name":"景洪市", 
"dist":[{"name":"勐腊县"}]},
{"name":"德宏州", 
"dist":[{"name":"陇川县"},{"name":"芒市"},{"name":"瑞丽市"},{"name":"盈江县"}]},
{"name":"临沧市", 
"dist":[{"name":"临沧市区"},{"name":"耿马县"},{"name":"永德县"}]},
{"name":"普洱市", 
"dist":[{"name":"普洱市区"},{"name":"景东县"},{"name":"孟连县"}]},
{"name":"曲靖市", 
"dist":[{"name":"陆良县"},{"name":"罗平县"},{"name":"沾益县"},{"name":"宣威市"}]},
{"name":"玉溪市", 
"dist":[{"name":"峨山县"},{"name":"新平县"},{"name":"元江县"},{"name":"易门县"}]},
{"name":"昭通市", 
"dist":[{"name":"昭通市区"},{"name":"鲁甸县"}]},
{"name":"香格里拉市", 
"dist":[{"name":"全市"}]},
] 
},

{"province":"贵州", 
"city":[
{"name":"黔西南州", 
"dist":[{"name":"兴义市"},
{"name":"兴仁县"},
{"name":"安龙县"}
]},

{"name":"遵义市", 
"dist":[{"name":"仁怀市"},{"name":"汇川区"},{"name":"红花岗区"}]},

{"name":"贵阳市",
"dist":[{"name":"贵阳市区"},{"name":"开阳县"}]},

{"name":"黔东南州", 
"dist":[{"name":"凯里市"},{"name":"锦屏县"}]},

{"name":"安顺市",
"dist":[{"name":"安顺市区"},{"name":"平坝县"}]},

{"name":"黔南州市",
"dist":[{"name":"都匀市"},
        {"name":"福泉市"}
        ]},
] 
},

{"province":"四川", 
"city":[
{"name":"攀枝花市"},

{"name":"都江堰市"},

{"name":"成都市", 
"dist":[{"name":"彭州市"},
{"name":"成华区"},
{"name":"温江区"}]},

{"name":"南充市", 
"dist":[{"name":"南充市"},
{"name":"阆中市"},{"name":"营山县"},{"name":"南部县"}]},
{"name":"西昌市", 
"dist":[{"name":"会理县"}]},

{"name":"宜宾市"},

{"name":"遂宁市", 
"dist":[{"name":"射洪县"}]},

{"name":"眉山市", 
"dist":[{"name":"彭山县"},{"name":"洪雅县"}]},

{"name":"德阳市"},

{"name":"内江市", 
"dist":[{"name":"东兴区"},
{"name":"隆昌县"}]},

{"name":"广安市", 
"dist":[{"name":"广安区"}]},

{"name":"峨眉山市", 
"dist":[{"name":"峨眉山市市区"}]},

{"name":"泸州市", 
"dist":[{"name":"叙永县"},
{"name":"合江县"},{"name":"龙马潭区"},{"name":"纳溪区"},{"name":"古蔺县"}]},

{"name":"绵阳市"}

] 
},

{"province":"重庆", 
"city":[
{"name":"重庆市", 
"dist":[{"name":"酉阳县"},
{"name":"石柱县"},
{"name":"梁平县"},
{"name":"垫江县"},
{"name":"江津区"},
{"name":"永川区"},
{"name":"九龙坡区"},
{"name":"璧山区"},
{"name":"南川区"},
{"name":"巫山县"},
{"name":"丰都县"},
{"name":"大足区"}]}

] 
},

{"province":"陕西", 
"city":[
{"name":"榆林市", 
"dist":[{"name":"榆林市区"},
{"name":"神木县"},
{"name":"靖边县"}]},

{"name":"西安市", 
"dist":[{"name":"西安市区"},
{"name":"渭南"},
{"name":"临潼"},
{"name":"富平"},
{"name":"蒲城"},
{"name":"咸阳"},
{"name":"阎良"},
{"name":"大荔"},
{"name":"铜川"},
{"name":"泾阳"},
{"name":"眉县"},
{"name":"汉中"},
{"name":"仁德"}]}

] 
},

{"province":"甘肃", 
"city":[
{"name":"天水市", 
"dist":[{"name":"麦积区"},
{"name":"武山县"}]},

{"name":"定西市", 
"dist":[{"name":"陇西县"}]},

{"name":"兰州市", 
"dist":[{"name":"城关区"},
{"name":"红古区"}]},

{"name":"酒泉市", 
"dist":[{"name":"全市"}]},

{"name":"金昌市", 
"dist":[{"name":"全市"}]},

{"name":"平凉市", 
"dist":[{"name":"全市"}]},

{"name":"庆阳市", 
"dist":[{"name":"全市"}]},

{"name":"张掖市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"青海", 
"city":[
{"name":"西宁市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"西藏", 
"city":[
{"name":"拉萨市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"新疆", 
"city":[
{"name":"克拉玛依市", 
"dist":[{"name":"全市"}]},

{"name":"乌鲁木齐市", 
"dist":[{"name":"全市"}]},

{"name":"昌吉市", 
"dist":[{"name":"全市"}]},

{"name":"库尔勒市", 
"dist":[{"name":"全市"}]},

{"name":"吐鲁番市", 
"dist":[{"name":"鄯善县"}]},

{"name":"哈密市", 
"dist":[{"name":"全市"}]},

{"name":"喀什市", 
"dist":[{"name":"全市"}]},

{"name":"奎屯市", 
"dist":[{"name":"全市"}]},

{"name":"博乐市", 
"dist":[{"name":"全市"}]},

{"name":"伊宁市", 
"dist":[{"name":"边境经济合作区"}]}

] 
},

{"province":"内蒙古", 
"city":[
{"name":"包头市", 
"dist":[{"name":"全市"}]},

{"name":"鄂尔多斯市", 
"dist":[{"name":"东胜区"}]},

{"name":"锡林浩特市", 
"dist":[{"name":"全市"}]},

{"name":"乌兰察布市", 
"dist":[{"name":"集宁区"}]},

{"name":"呼和浩特市", 
"dist":[{"name":"新城区"}]},

{"name":"乌海市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"宁夏", 
"city":[
{"name":"银川市", 
"dist":[{"name":"兴庆区"}]},

{"name":"固原市", 
"dist":[{"name":"全市"}]}

] 
}

]; 



