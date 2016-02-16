<?php
/**
 * 优品团：城市定位类
 */
namespace Library\Com;

class VcardPoint{
    
    private $funs_model;
    private $location_model;
    private $group;
    public function __construct($data) {
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
        $this->group = $data;
    }
    
    //获取最近城市信息
    public function getCity(){
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
        $content = array();
       
            if(empty($address['status'])){
                $info['ip_city'] = $address['content']['address'];
                $info['city_name'] = $address['content']['address_detail']['city'];
                $info['lng'] = $address['content']['point']['x'];
                $info['lat'] = $address['content']['point']['y'];
                $point = $this->getPoint();
                foreach ($point as $k => $key){
                    if($key['city_name'].'市' == $info['city_name']){
                        $content['ip_city']     = $info['ip_city'];
                        $content['city_name']   = $key['city_name'];
                        $content['city_code']   = $key['region_id'];
                        $content['ip']          = $ip;
                        $content['lng']         = $key['lng'];//经度
                        $content['lat']         = $key['lat'];//纬度
                        $content['action_id']         = $key['action_id']; //地区对应活动id
                    } else {
                        $arr[$k]['distance']    = $this->location_model->getDistance($info['lat'], $info['lng'], $key['lat'], $key['lng']);
                        $arr[$k]['ip_city']     = $info['ip_city'];
                        $arr[$k]['city_name']   = $key['city_name'];
                        $arr[$k]['city_code']   = $key['region_id'];
                        $arr[$k]['ip']          = $ip;
                        $arr[$k]['lng']         = $key['lng'];
                        $arr[$k]['lat']         = $key['lat'];
                        $arr[$k]['action_id']         = $key['action_id']; //地区对应活动id
                    }
                }
                if(empty($content)){
                    $array_sort = $this->funs_model->array_sort($arr, 'distance');
//                     var_dump($array_sort);die;
                    $content = array_values($array_sort)[0];
                }
            }
        
        
        //ip定位城市
        if(!$address['content']['address_detail']['city']){
            $content['location_city'] = str_replace('市','',$address['content']['address']);
        } else {
            $content['location_city'] = str_replace('市','',$address['content']['address_detail']['city']);
        }
        return $content;
    }
    public function getPoint(){
        
        $sql = "select a.id as action_id,b.region as region_id,a.address from yizhangou_list a left join yizhangou_regions b on a.group_id=b.id where a.name='全民家居购' and a.endtime>'" . date('Y-m-d H:i:s') . "'";
        $data = $this->group->fetchAll($sql);
        $E = new \Library\Model\Ext();
        $citys = $E->regions();
        foreach ($data as $k=>$v)
        {
        	$tmp = json_decode($v['address']);
        	$str = explode(',', $tmp[0]->latitude);
        	$data[$k]['lng'] = $str[0];
        	$data[$k]['lat'] = $str[1];
        	$data[$k]['city_name'] = $citys['list'][$v['region_id']];
        }
        
        return $data;
    }
}

?>