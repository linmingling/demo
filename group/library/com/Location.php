<?php
/**
 * Ip定位接口类
 * 提供商：百度地图（http://developer.baidu.com/map/wiki/index.php?title=webapi/ip-api）
 */
namespace Library\Com;

class Location{
    private $ak;
    
    public function __construct() {
        $this->ak = 'E75ee0eb6a3efa9b9e9d5810f1890833';//ak密钥（100万次/天）
        $this->funs_model = new \Library\Com\Funs();
    }
    
    /**
     * 获取ip地址
     * @return string
     */
//     public static function getClientIp(){
//         $ip = "unknown";
//         if (isset($_SERVER)) {
//             if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
//                 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
//             } elseif (isset($_SERVER["HTTP_CLIENT_ip"])) {
//                 $ip = $_SERVER["HTTP_CLIENT_ip"];
//             } else {
//                 $ip = $_SERVER["REMOTE_ADDR"];
//             }
//         } else {
//             if (getenv('HTTP_X_FORWARDED_FOR')) {
//                 $ip = getenv('HTTP_X_FORWARDED_FOR');
//             } elseif (getenv('HTTP_CLIENT_ip')) {
//                 $ip = getenv('HTTP_CLIENT_ip');
//             } else {
//                 $ip = getenv('REMOTE_ADDR');
//             }
//         }
//         if(trim($ip) == "::1"){
//             $ip="127.0.0.1";
//         }
//         return $ip;
//     }
    
    /**
     * 获得用户的真实IP地址
     *
     * @access  public
     * @return  string
     */
    public static function getClientIp()
    {
        static $realip = NULL;
    
        if ($realip !== NULL)
        {
            return $realip;
        }
    
        if (isset($_SERVER))
        {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip)
                {
                    $ip = trim($ip);
    
                    if ($ip != 'unknown')
                    {
                        $realip = $ip;
    
                        break;
                    }
                }
            }
            elseif (isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }
            else
            {
                if (isset($_SERVER['REMOTE_ADDR']))
                {
                    $realip = $_SERVER['REMOTE_ADDR'];
                }
                else
                {
                    $realip = '0.0.0.0';
                }
            }
        }
        else
        {
            if (getenv('HTTP_X_FORWARDED_FOR'))
            {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            }
            elseif (getenv('HTTP_CLIENT_IP'))
            {
                $realip = getenv('HTTP_CLIENT_IP');
            }
            else
            {
                $realip = getenv('REMOTE_ADDR');
            }
        }
    
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    
        return $realip;
    }
    
    
    /**
     * [taobaoIpLocation 根据ip地址获取位置信息   淘宝API]
     * @param  [string]  $ip     	[ip]
     * @param  boolean $is_isp 		[是否返回isp信息]
     * @return [string]          	[地址信息]
     */
    public static function taobaoIpLocation( $ip , $is_isp = false ){
        $taobaoApi = 'http://ip.taobao.com/service/getIpInfo.php?ip=';
        $ipInfo_json = file_get_contents( $taobaoApi . $ip );
        $ipInfo_arr = json_decode( $ipInfo_json, TRUE );
        if( 0 != $ipInfo_arr['code'] ){
            return '';
        }
        //var_dump($ipInfo_arr);
        $ipInfo_arr = $ipInfo_arr['data'];
        if( 'cn' != strtolower( $ipInfo_arr['country_id'] ) ){
            return $ipInfo_arr['country'];//国外仅显示国家
        }
    
        $municipality = array('北京市', '上海市', '天津市', '重庆市');//直辖市
    
        $isp = $is_isp ? $ipInfo_arr['isp'] : '' ;
        if(in_array($ipInfo_arr['region'], $municipality)){
            return $ipInfo_arr['city'] . $ipInfo_arr['county'] . $isp;
        }else{
            return $ipInfo_arr['region'] . $ipInfo_arr['city'] . $ipInfo_arr['county'] . $isp;
        }
    }
    
    /**
     * IP定位，根据IP返回对应位置信息[百度API]
     * @param string $ip    ip
     * @return mixed        位置信息（包含经纬度）
     */
    public function getLocation($ip = ''){
        if(!$ip || empty($ip) || $ip == '127.0.0.1'){
            $ip = '';//ip为空时，返回当前服务器所在地的ip信息
        }
        $api_url = 'http://api.map.baidu.com/location/ip?ak='.$this->ak.'&ip='.$ip.'&coor=bd09ll';
        return json_decode($this->funs_model->curlGet($api_url), true);
        
    }
    
    
    /**
     *  @desc 根据两点间的经纬度计算距离[x经度坐标（0~180） ，y纬度坐标（0~90）]
     *  @param float $lat 纬度值
     *  @param float $lng 经度值
     */
    public function getDistance($lat1, $lng1, $lat2, $lng2){
        
        $earthRadius = 6367000; //近似半径
        //转换为弧度
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;
    
        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;
    
        //http://en.wikipedia.org/wiki/haversine_formula
        //使用公式计算距离
    
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        
        return round($calculatedDistance);
    }
}

?>