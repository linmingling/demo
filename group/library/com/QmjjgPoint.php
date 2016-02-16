<?php
/**
 * 华耐全民家居购
 */
namespace Library\Com;

class QmjjgPoint{
    private $funs_model;
    private $location_model;
    private $group;
    
    public function __construct($data) {
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
        $this->group = $data;
    }

    //获取所在位置信息,如果所在的位置不存在，就取最近的城市信息
    public function getCity($city_code = ''){
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
        $content = array();
        if($address['status'] != 0){
            $content['ip_city'] = $address['status'];
            $content['city'] = 'API请求错误';
            $content['city_code'] = 'kunming';
            $content['address'] = '昆明国际贸易中心';
            $content['ip'] = $ip;//ip
            $content['time'] = '2015-11-07';
            $content['address_x'] = 102.792678;
            $content['address_y'] = 24.952438;
            $content['code'] = 367;
            $content['brand_list'] = '1,2,3';
        } else {
            if(empty($city_code)){
                if(empty($address['status'])){
                    $info['ip_city'] = $address['content']['address'];
                    $info['city'] = $address['content']['address_detail']['city'];
                    $info['lng'] = $address['content']['point']['x'];
                    $info['lat'] = $address['content']['point']['y'];
                    $point = $this->getPoint();
                    foreach ($point as $k => $key){
                        if($key['city'].'市' == $info['city']){
                            $content['ip_city'] = $info['ip_city'];
                            $content['city'] = $key['city'];
                            $content['city_code'] = $key['city_code'];
                            $content['address'] = $key['address'];
                            $content['address_x'] = $key['address_x'];//经度
                            $content['address_y'] = $key['address_y'];//纬度
                            $content['ip'] = $ip;//ip
                            $content['time'] = $key['time'];
                            $content['brand_list'] = $key['brand'];
                            $content['code'] = $key['code'];
                            $content['action_id'] = $key['action_id'];
                        } else {
                            $arr[$k]['distance'] = $this->location_model->getDistance($info['lat'], $info['lng'], $key['address_y'], $key['address_x']);
                            $arr[$k]['ip_city'] = $info['ip_city'];
                            $arr[$k]['city'] = $key['city'];
                            $arr[$k]['city_code'] = $key['city_code'];
                            $arr[$k]['address'] = $key['address'];
                            $arr[$k]['address_x'] = $key['address_x'];
                            $arr[$k]['address_y'] = $key['address_y'];
                            $arr[$k]['ip'] = $ip;//ip
                            $arr[$k]['time'] = $key['time'];
                            $arr[$k]['brand_list'] = $key['brand'];
                            $arr[$k]['code'] = $key['code'];
                            $arr[$k]['action_id'] = $key['action_id'];
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
                        $content['city'] = $key['city'];
                        $content['city_code'] = $key['city_code'];
                        $content['address'] = $key['address'];
                        $content['address_x'] = $key['address_x'];
                        $content['address_y'] = $key['address_y'];
                        $content['ip'] = $ip;//ip
                        $content['time'] = $key['time'];
                        $content['brand_list'] = $key['brand'];
                        $content['code'] = $key['code'];
                        $content['action_id'] = $key['action_id'];
                    }
                }
            }
            if(empty($content['city'])){
                //默认城市
                $content['ip_city'] = '广东省广州市';
                $content['city'] = '昆明';
                $content['city_code'] = 'kunming';
                $content['address'] = '昆明国际贸易中心';
                $content['ip'] = $ip;//ip
                $content['time'] = '2015-11-07';
                $content['address_x'] = 102.792678;
                $content['address_y'] = 24.952438;
                $content['code'] = 367;
                $content['brand_list'] = '1,2,3';
            }
            if(!$address['content']['address_detail']['city']){
                $content['location_city'] = str_replace('市','',$address['content']['address']);
            } else {
                $content['location_city'] = str_replace('市','',$address['content']['address_detail']['city']);
            }
        }
        return $content;
    }


    //全民家居购落地城市经纬度
    public function getPoint(){
        //x经度坐标（0~180） ，y纬度坐标（0~90）
        $sql = "SELECT * FROM qmjjg_city_list WHERE is_show=1";
        $point = $this->group->fetchAll($sql);
        return $point;
    }
}

?>