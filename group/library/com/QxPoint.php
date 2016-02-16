<?php
/**
 * 七夕家装节20个落地城市的经纬度类
 */
namespace Library\Com;

class QxPoint{
    private $funs_model;
    private $location_model;

    public function __construct() {
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
    }

    //获取所在位置信息,如果所在的位置不在20个城市中，就取最近的城市信息
    public function getCity($city_code = ''){
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
		$content = array();
        if(empty($city_code)){
            if(empty($address['status'])){
                $info['ip_city'] = $address['content']['address'];
                $info['city'] = $address['content']['address_detail']['city'];
                $info['lng'] = $address['content']['point']['x'];
                $info['lat'] = $address['content']['point']['y'];
                $point = $this->getPoint();
                foreach ($point as $k => $key){
                    if($key['city'] == $info['city']){
                        $content['ip_city'] = $info['ip_city'];
                        $content['city'] = str_replace('市','',$key['city']);
                        $content['city_code'] = $key['city_code'];
                        $content['address'] = $key['address'];
                        $content['address_x'] = $key['address_x'];
                        $content['address_y'] = $key['address_y'];
                        $content['ip'] = $ip;//ip
                        $content['lng'] = $key['x'];//经度
                        $content['lat'] = $key['y'];//纬度
                        $content['time'] = $key['time'];
                    } else {
                        $arr[$k]['distance'] = $this->location_model->getDistance($info['lat'], $info['lng'], $key['y'], $key['x']);
                        $arr[$k]['ip_city'] = $info['ip_city'];
                        $arr[$k]['city'] = str_replace('市','',$key['city']);
                        $arr[$k]['city_code'] = $key['city_code'];
                        $arr[$k]['address'] = $key['address'];
                        $arr[$k]['address_x'] = $key['address_x'];
                        $arr[$k]['address_y'] = $key['address_y'];
                        $arr[$k]['ip'] = $ip;//ip
                        $arr[$k]['x'] = $key['x'];
                        $arr[$k]['y'] = $key['y'];
                        $arr[$k]['time'] = $key['time'];
                    }
                }
                if(empty($content)){
                    $array_sort = $this->funs_model->array_sort($arr, 'distance');
                    $content = array_values($array_sort)[0];
                }
            }
        } else {
            $point = $this->getPoint();
            foreach ($point as $k => $key){
                if($key['city_code'] == $city_code){
                    $content['ip_city'] = $address['content']['address'];
                    $content['city'] = str_replace('市','',$key['city']);
                    $content['city_code'] = $key['city_code'];
                    $content['address'] = $key['address'];
                    $content['address_x'] = $key['address_x'];
                    $content['address_y'] = $key['address_y'];
                    $content['ip'] = $ip;//ip
                    $content['lng'] = $key['x'];//经度
                    $content['lat'] = $key['y'];//纬度
                    $content['time'] = $key['time'];
                }
            }
        }
        if(empty($content['city'])){
            //默认城市
            $content['ip_city'] = '广东省广州市';
            $content['city'] = '厦门';
            $content['city_code'] = 'xiamen';
            $content['address'] = '国际会展中心';
            $content['ip'] = $ip;//ip
            $content['time'] = '2015.8.22';
            $content['address_x'] = 118.190325;
            $content['address_y'] = 24.473254;
        }
        if(!$address['content']['address_detail']['city']){
            $content['location_city'] = str_replace('市','',$address['content']['address']);
        } else {
            $content['location_city'] = str_replace('市','',$address['content']['address_detail']['city']);
        }
        return $content;
    }


    //七夕家装节落地城市经纬度
    public function getPoint(){
        //x经度坐标（0~180） ，y纬度坐标（0~90）
        $point = array(
            0 => array('city' => '杭州市', 'city_code' => 'hangzhou', 'x' => 120.21937542, 'y' => 30.25924446, 'address' => '浙江世贸国际展览中心', 'address_x' => 120.146937, 'address_y' => 30.272869, 'time'=>'2015.8.22'),
//             1 => array('city' => '宁波市', 'city_code' => 'ningbo', 'x' => 121.57900597, 'y' => 29.88525897, 'address' => ''),
//             2 => array('city' => '深圳市', 'city_code' => 'shenzhen', 'x' => 114.02597366, 'y' => 22.54605355, 'address' => ''),
//             3 => array('city' => '广州市', 'city_code' => 'guangzhou', 'x' => 113.30764968, 'y' => 23.12004910, 'address' => '琶洲·保利世贸博览馆'),
            4 => array('city' => '济南市', 'city_code' => 'jinan', 'x' => 117.02496707, 'y' => 36.68278473, 'address' => '南郊宾馆蓝色大厅', 'address_x' => 117.023617, 'address_y' => 36.647593, 'time'=>'2015.8.30'),
            5 => array('city' => '青岛市', 'city_code' => 'qingdao', 'x' => 120.38442818, 'y' => 36.10521490, 'address' => '苗岭路 青岛国际会展中心一号馆', 'address_x' => 120.480682, 'address_y' => 36.110438, 'time'=>'2015.8.22'),
//             6 => array('city' => '无锡市', 'city_code' => 'wuxi', 'x' => 120.30545590, 'y' => 31.57003745, 'address' => ''),
            7 => array('city' => '南京市', 'city_code' => 'nanjing', 'x' => 118.77807441, 'y' => 32.05723550, 'address' => '金陵会议中心', 'address_x' => 118.724217, 'address_y' => 31.999093, 'time'=>'2015.8.22'),
            8 => array('city' => '武汉市', 'city_code' => 'wuhan', 'x' => 114.31620010, 'y' => 30.58108413, 'address' => '鹦鹉大道·武汉国际博览中心B2馆', 'address_x' => 114.25009, 'address_y' => 30.516637, 'time'=>'2015.8.29-30'),
            9 => array('city' => '南昌市', 'city_code' => 'nanchang', 'x' => 115.89352755, 'y' => 28.68957800, 'address' => '红谷滩 国际体育中心', 'address_x' => 115.826484, 'address_y' => 28.626974, 'time'=>'2015.8.22'),
            10 => array('city' => '昆明市', 'city_code' => 'kunming', 'x' => 102.71460114, 'y' => 25.04915310, 'address' => '新亚洲体育馆', 'address_x' => 102.771618, 'address_y' => 24.948146, 'time'=>'2015.8.29'),
            11 => array('city' => '西安市', 'city_code' => 'xian', 'x' => 108.95309828, 'y' => 34.27779990, 'address' => '绿地笔克国际会展中心', 'address_x' => 108.894575, 'address_y' => 34.19816, 'time'=>'2015.8.29'),
//             12 => array('city' => '上海市', 'city_code' => 'shanghai', 'x' => 121.48789949, 'y' => 31.24916171, 'address' => ''),
            13 => array('city' => '天津市', 'city_code' => 'tianjin', 'x' => 117.21081309, 'y' => 39.14392990, 'address' => '天津体育馆', 'address_x' => 117.179857, 'address_y' => 39.080381, 'time'=>'2015.8.22'),
            14 => array('city' => '厦门市', 'city_code' => 'xiamen', 'x' => 118.10388605, 'y' => 24.48923061, 'address' => '会展路.国际会展中心M馆', 'address_x' => 118.190325, 'address_y' => 24.473254, 'time'=>'2015.8.22'),
            15 => array('city' => '太原市', 'city_code' => 'taiyuan', 'x' => 112.55086359, 'y' => 37.89027705, 'address' => '居然之家河西店建材馆', 'address_x' => 112.488058, 'address_y' => 37.86368, 'time'=>'2015.8.22 13:30'),
//             16 => array('city' => '石家庄市', 'city_code' => 'shijiazhuang', 'x' => 114.52208184, 'y' => 38.04895831, 'address' => '世纪华宴大酒店 ', 'address_x' => 114.540582, 'address_y' => 38.025042, 'time'=>'2015.8.23'),
            17 => array('city' => '长沙市', 'city_code' => 'changsha', 'x' => 112.97935279, 'y' => 28.21347823, 'address' => '中南林业科技大学体育馆', 'address_x' => 112.997372, 'address_y' => 28.13385, 'time'=>'2015.8.22'),
            18 => array('city' => '哈尔滨市', 'city_code' => 'haerbin', 'x' => 126.65771686, 'y' => 45.77322463, 'address' => '松浦大道·华美太古广场', 'address_x' => 126.641763, 'address_y' => 45.851713, 'time'=>'2015.8.22-23'),
            19 => array('city' => '贵阳市', 'city_code' => 'guiyang', 'x' => 106.70917710, 'y' => 26.62990674, 'address' => '国际会展中心5号馆', 'address_x' => 106.652317, 'address_y' => 26.648556, 'time'=>'2015.8.22'),
            20 => array('city' => '郑州市', 'city_code' => 'zhengzhou', 'x' => 113.64964385, 'y' => 34.75661006, 'address' => '中原国际博览中心', 'address_x' => 113.712761, 'address_y' => 34.753797, 'time'=>'2015.8.29'),
            21 => array('city' => '北京市', 'city_code' => 'beijing', 'x' => 116.40387397, 'y' => 39.91488908, 'address' => '国门1号全球家居总部基地', 'address_x' => 116.568309, 'address_y' => 40.125399, 'time'=>'8.22-23 8.29-30'),
            22 => array('city' => '东莞市', 'city_code' => 'dongguan', 'x' => 113.76343399, 'y' => 23.04302382, 'address' => '东莞名家居世博园', 'address_x' => 113.6628, 'address_y' => 22.908836, 'time'=>'2015.8.22')
        );
        return $point;
    }

    public function getBrand(){
        $list = array(
            'hangzhou' => array(
                '/qixi/images/hangzhou/logo1.png',
                '/qixi/images/hangzhou/logo2.png',
                '/qixi/images/hangzhou/logo3.png',
            ),
            'jinan' => array(
                '/qixi/images/jinan/logo1.png',
                '/qixi/images/jinan/logo2.png',
            ),
            'qingdao' => array(
                '/qixi/images/qingdao/logo1.png',
            ),
            'nanjing' => array(
                '/qixi/images/nanjing/logo1.png',
                '/qixi/images/nanjing/logo2.png',
                '/qixi/images/nanjing/logo3.png',
            ),
            'wuhan' => array(
                '/qixi/images/wuhan/logo1.png',
            ),
            'nanchang' => array(
                '/qixi/images/nanchang/logo1.png',
            ),
            'kunming' => array(
                '/qixi/images/kunming/logo1.png',
                '/qixi/images/kunming/logo2.png',
            ),
            'xian' => array(
                '/qixi/images/xian/logo1.png',
            ),
            'tianjin' => array(
                '/qixi/images/tianjin/logo1.png',
            ),
            'xiamen' => array(
                '/qixi/images/xiamen/logo1.png',
                '/qixi/images/xiamen/logo2.png',
                '/qixi/images/xiamen/logo3.png',
            ),
            'taiyuan' => array(
                '/qixi/images/taiyuan/logo1.png',
                '/qixi/images/taiyuan/logo2.png',
            ),
            'shijiazhuang' => array(
                '/qixi/images/shijiazhuang/logo1.png',
            ),
            'changsha' => array(
                '/qixi/images/changsha/logo1.png',
                '/qixi/images/changsha/logo2.png',
            ),
            'haerbin' => array(
                '/qixi/images/haerbin/logo1.png',
                '/qixi/images/haerbin/logo2.png',
                '/qixi/images/haerbin/logo3.png',
            ),
            'guiyang' => array(
                '/qixi/images/guiyang/logo1.png',
                '/qixi/images/guiyang/logo2.png',
            ),
            'zhengzhou' => array(
                '/qixi/images/zhengzhou/logo1.png',
            ),
            'beijing' => array(
                '/qixi/images/beijing/logo1.png',
                '/qixi/images/beijing/logo2.png',
                '/qixi/images/beijing/logo3.png',
            ),
            'dongguan' => array(
                '/qixi/images/dongguan/logo1.png',
                '/qixi/images/dongguan/logo2.png',
                '/qixi/images/dongguan/logo3.png',
            ),
        );
        return $list;
    }

    public function getNewBrand(){
        $list = array(
            'hangzhou' => array(13,114,30,42,83,6,113,23,16,11),
            'jinan' => array(53,41,4,25,58,3,37,57,69,64,21,34,50,115,94,61,93,42),
            'qingdao' => array(13,41,42,30,76,44,72,75,23,55,116,11,117),
            'nanjing' => array(1,4,6,12,16,17,18,23,25,30,32,34,36,38,39,41,42,44,48,49,58,59,61,63,65,72,75,),
            'wuhan' => array(41,84,58,145,53,30,127,20,146,28,138,44,06,129,03,75,100,151,67,147,115,25,130,128,148,133,51,149,131,152,11,135,150),
            'nanchang' => array(13,2,42,6,83),
            'kunming' => array(84,6,42,2,38,28,72,99,100,101,16,14,109,102,103,46,112,104,105,60,107,108,43),
            'xian' => array(13,55,60,130,41,30,6,143,144),
            'tianjin' => array(41,30,84,121,54,122,6,45,77,124,123,139),
            'xiamen' => array(84,85,86,87,88,89,90,38,11,41,42,6,27,56,72,36,66,52,91,9,8,51,92,7,55,26),
            'taiyuan' => array(78,53,41,4,79,21,3,37,58,34,50,57,5,64,80,24),
            'shijiazhuang' => array(1,2,12,3,7),
            'changsha' => array(84,41,6,29,35,125,11,55,42,81,51,82),
            'haerbin' => array(84,46,30,44,42,118,119,50,126,140,25,142,141),
            'guiyang' => array(13,41,5,42,40,31,28,48,54,10,16,51,7,62,73,47),
            'zhengzhou' => array(13,21,30,41,42,55,60,11),
            'beijing' => array(1,4,6,12,16,17,18,23,25,30,32,34,36,38,39,41,42,44,48,49,58,59,61,63,65,72,75,),
            'dongguan' => array(95,84,41,38,120,44,55,111,11,72,98,110,97),
        );
        return $list;
    }
}

?>