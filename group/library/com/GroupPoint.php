<?php
/**
 * 优品团：城市定位类
 */
namespace Library\Com;

class GroupPoint{
    
    private $funs_model;
    private $location_model;
    private $group;
    public function __construct($data) {
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
        $this->group = $data;
    }
    
    //获取最近城市信息
    public function getCity($city_code, $city_list){
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
        $content = array();
        if(empty($city_code)){
            if(empty($address['status'])){
                $info['ip_city'] = $address['content']['address'];
                $info['city_name'] = $address['content']['address_detail']['city'];
                $info['lng'] = $address['content']['point']['x'];
                $info['lat'] = $address['content']['point']['y'];
                $point = $this->getPoint($city_list);
                foreach ($point as $k => $key){
                    if($key['city_name'].'市' == $info['city_name']){
                        $content['ip_city']     = $info['ip_city'];
                        $content['city_name']   = $key['city_name'];
                        $content['city_code']   = $key['city_code'];
                        $content['ip']          = $ip;
                        $content['lng']         = $key['lng'];//经度
                        $content['lat']         = $key['lat'];//纬度
                    } else {
                        $arr[$k]['distance']    = $this->location_model->getDistance($info['lat'], $info['lng'], $key['lat'], $key['lng']);
                        $arr[$k]['ip_city']     = $info['ip_city'];
                        $arr[$k]['city_name']   = $key['city_name'];
                        $arr[$k]['city_code']   = $key['city_code'];
                        $arr[$k]['ip']          = $ip;
                        $arr[$k]['lng']         = $key['lng'];
                        $arr[$k]['lat']         = $key['lat'];
                    }
                }
                if(empty($content)){
                    $array_sort = $this->funs_model->array_sort($arr, 'distance');
                    $content = array_values($array_sort)[0];
                }
            }
        } else {
            $point = $this->getPoint($city_list);
            foreach ($point as $k => $key){
                if($key['city_code'] == $city_code){
                    $content['ip_city']     = $address['content']['address'];
                    $content['city_name']   = $key['city_name'];
                    $content['city_code']   = $key['city_code'];
                    $content['ip']          = $ip;
                    $content['lng']         = $key['lng'];//经度
                    $content['lat']         = $key['lat'];//纬度
                }
            }
        }
        if(empty($content['city_name'])){
            //默认城市
            $content['ip_city']     = '广东省广州市';
            $content['city_name']   = '广州';
            $content['city_code']   = 'guangzhou';
            $content['ip']          = $ip;//ip
            $content['lng']         = 113.30764968;
            $content['lat']         = 23.12004910;
        }
        //ip定位城市
        if(!$address['content']['address_detail']['city']){
            $content['location_city'] = str_replace('市','',$address['content']['address']);
        } else {
            $content['location_city'] = str_replace('市','',$address['content']['address_detail']['city']);
        }
        return $content;
    }
    public function getPoint($city_list){
        if($city_list){
            foreach ($city_list as $k => $key){
                $city_arr[] = "'".$key['city_code']."'";
            }
            $city_code = implode(',', $city_arr);
            $sql = "SELECT * FROM group_city_list WHERE city_code IN (".$city_code.")";
            $data = $this->group->fetchAll($sql);
        }
        return $data;
    }
}

?>