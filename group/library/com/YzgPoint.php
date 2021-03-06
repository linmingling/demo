<?php
/**
 * 华耐全民家居购
 */
namespace Library\Com;

class YzgPoint{
    private $funs_model;
    private $location_model;
	private $group;
	private $regions;
    
    public function __construct($group,$regions) {
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
		$this->group = $group;
		$this->regions = $regions;
    }

    //获取所在位置信息,如果所在的位置不存在，就取最近的城市信息
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
                    if($key['city_name'].'市' == $info['city']){
                        $content['ip_city'] = $info['ip_city'];
                        $content['city'] = $key['city_name'];
                        $content['city_code'] = $key['city_code'];
                        $content['address_x'] = $key['lng'];//经度
                        $content['address_y'] = $key['lat'];//纬度
                        $content['ip'] = $ip;//ip
                        $content['time'] = $key['add_time'];
                        $content['code'] = $key['city_id'];
                    } else {
                        $arr[$k]['distance'] = $this->location_model->getDistance($info['lat'], $info['lng'], $key['address_y'], $key['address_x']);
                        $arr[$k]['ip_city'] = $info['ip_city'];
                        $arr[$k]['city'] = $key['city_name'];
                        $arr[$k]['city_code'] = $key['city_code'];
                        $arr[$k]['address_x'] = $key['lng'];
                        $arr[$k]['address_y'] = $key['lat'];
                        $arr[$k]['ip'] = $ip;//ip
                        $arr[$k]['time'] = $key['add_time'];
                        $arr[$k]['code'] = $key['city_id'];
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
                    $content['city'] = $key['city_name'];
                    $content['city_code'] = $key['city_code'];
                    $content['address_x'] = $key['lng'];
                    $content['address_y'] = $key['lat'];
                    $content['ip'] = $ip;//ip
                    $content['time'] = $key['add_time'];
                    $content['code'] = $key['city_id'];
                }
            }
        }
        if(empty($content['city'])){
            //默认城市
            $content['ip_city'] = '广东省广州市';
            $content['city'] = '全国';
            $content['city_code'] = 'shanghai';
            $content['ip'] = $ip;//ip
            $content['add_time'] = '2015-11-07';
            $content['address_x'] = 121.48789949;
            $content['address_y'] = 31.24916171;
            $content['code'] = 321;
        }
        if(!$address['content']['address_detail']['city']){
            $content['location_city'] = str_replace('市','',$address['content']['address']);
        } else {
            $content['location_city'] = str_replace('市','',$address['content']['address_detail']['city']);
        }
        return $content;
    }


    //全民家居购落地城市经纬度
    public function getPoint(){
        //x经度坐标（0~180） ，y纬度坐标（0~90）
        $sql = "SELECT * FROM yizhangou_list where hide = '1' and `name` like '全民家居购'";
        $tmp = $this->group->fetchAll($sql);
		foreach($tmp as $k){
			$regionId = $this->group->fetchColumn("select region from yizhangou_regions where id = ".$k['group_id']);
			$addr = json_decode($k['address'],true);
			list($lng,$lat) = explode(',',$addr[0]['latitude']);
			$point[] = array('lng'=>$lng,'lat'=>$lat,'city_name'=>$this->regions['list'][$regionId]);
		}
        return $point;
    }
}

?>