<?php
namespace Apps\Pc\Controllers;

use Library\Com\Funs;

class Exposition3Controller extends ControllerBase {
	
	private $funs_model;
	private $sms_model;
	private $location_model;
	private $point_model;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\LibSms();
		$this->location_model = new \Library\Com\Location();
	}

    public function indexAction(){
    	$this->view->setVar("pcHome", $this->config->pcHome);
    	$this->view->setVar("zxHome", $this->config->zxHome);
    	$this->view->setVar("payDomain", $this->config->payDomain);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $type = empty($_GET['type']) ? '' : $_GET['type'];
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
//         echo '<pre>';print_r($address['content']['address']);exit;
        
        $sql = "SELECT COUNT(*) AS num FROM exposition";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data['num'] + 6000);
        
        $sql = "SELECT name,phone FROM exposition LIMIT 100";
        $list = $this->group->fetchAll($sql);
        foreach ($list as $k => $key){
            $list[$k]['name'] = $this->substr_cut($key['name'], 1).'**';
            $list[$k]['phone'] = substr($key['phone'], 0, 4).'****'.substr($key['phone'], -3);
        }
        $this->view->setVar("list", $list);
        
        $goods_sql = "SELECT * FROM exposition_goods_list WHERE is_show=1";
        $goods_list = $this->group->fetchAll($goods_sql);
        foreach ($goods_list as $k => $key){
            if($key['goods_type'] == 1){
                $goods_list1[$k] = $key;
            } else {
                $goods_list2[$k] = $key;
            }
        }
        $goods_list1 = array_values($goods_list1);
        $goods_list2 = array_values($goods_list2);
        for($fy1=0; $fy1<(count($goods_list1)); $fy1++){
            $goods_arr1[intval($fy1/8)][] = $goods_list1[$fy1];
        }
        for($fy2=0; $fy2<(count($goods_list2)); $fy2++){
            $goods_arr2[intval($fy2/8)][] = $goods_list2[$fy2];
        }
        $this->view->setVar("goods_arr1", $goods_arr1);
        $this->view->setVar("goods_arr2", $goods_arr2);
        $this->view->setVar("type", $type);
        
//         echo '<pre>';print_r($goods_arr1);exit;
        $this->session->set('url_source', $from);
        $this->session->set('ip', $ip);
        $this->session->set('ip_address', $address['content']['address']);
        if($type){
            $this->view->pick("exposition3/index2");
        }
    }
	

    //获取短信验证码
    public function getVerifyAction(){
    
        $name = trim($_POST['name']);//姓名
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $ip = $this->session->get('ip');//ip所属城市
        $address = $this->session->get('ip_address');//城市
        $verify = rand(1000, 9999);//获取随机验证码
    
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
    
        $sql = "SELECT * FROM exposition WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if(time() - $data['update_time'] < 60){
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
            } else {
                $sql = "UPDATE exposition SET verify='".$verify."',update_time='".time()."' WHERE phone='".$phone."'";
                $result = $this->group->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "验证码已发送！";
                    $ajax_result['verify'] = $verify;
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
            }
            die(json_encode($ajax_result));
        } else {
            $sql = "INSERT INTO exposition (name, phone, ip, ip_address, url_source, verify, verify_time, update_time, add_time) VALUES('".$name."','".$phone."','".$ip."','".$address."','".$url_source."','".$verify."','0','".time()."','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "验证码已发送！";
                $ajax_result['verify'] = $verify;
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        }
    }
    
    //手机号验证
    public function submitAction(){
        
        $phone = trim($_POST['phone']);
        $area = trim($_POST['area']);
        $address = trim($_POST['address']);
        $verify = trim($_POST['code']);
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "信息丢失，请刷新重试";
            die(json_encode($ajax_result));
        }
        if(empty($verify)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请输入验证码";
            die(json_encode($ajax_result));
        }
        if(empty($area)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请选择区";
            die(json_encode($ajax_result));
        }
        if(empty($address)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请输入详细地址";
            die(json_encode($ajax_result));
        }
    
        $sql = "SELECT * FROM exposition WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE exposition SET state=1,verify_time='".time()."',area='".$area."',address='".$address."' WHERE phone='".$phone."'";
                $result = $this->group->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "报名成功";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
            } else {
                $ajax_result['errcode'] = 1004;
                $ajax_result['errmsg'] = "验证码错误！";
            }
            die(json_encode($ajax_result));
        } else {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "请先获取验证码！";
            die(json_encode($ajax_result));
        }
    }
    
    //预约
    public function subscribeAction(){
         
        $phone = trim($_POST['phone']);
        $name = trim($_POST['name']);
        $goods_name = trim($_POST['goods_name']);
        $goods_id = trim($_POST['goods_id']);
        
        $sql = "SELECT id FROM exposition_subscribe WHERE phone='".$phone."' AND goods_id='".$goods_id."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "你已经预约过该商品了！";
            die(json_encode($ajax_result));
        } else {
            $sql = "INSERT INTO exposition_subscribe (name, phone, goods_name, goods_id, add_time) VALUES('".$name."','".$phone."','".$goods_name."','".$goods_id."','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "预约成功！";
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        }
    }
    
    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        
        $apiUrl = 'http://sms.yoju360.net/api/send.do';
        $appName = 'act';
        $apiKey = '316c9c3ed45a83ee318b1f859d9b8b79';
        $projectName = '第三届优居家博会';
        if(empty($verify)){
            $content = '【腾讯优居】您已成功领取《优居家博会》抵扣券，建材家居5折让利，下单即享95折，2000元品牌抵扣券免费送，4999免单大奖等您抽，漕宝路88号光大会展中心（2月26至28日），稍后会有优居工作人员和您取得联系安排快递票券。请您留意接听电话，感谢您的参与！回T退订';
            $this->sms_model->sendSms($apiUrl, $appName, $apiKey, $projectName, $phone, $content, 0, 1);
        } else {
            $content = '【腾讯优居】您的短信验证码是：'.$verify;
            $this->sms_model->sendSms($apiUrl, $appName, $apiKey, $projectName, $phone, $content);
        }
    }
    
    //匿名处理
    function substr_cut($str_cut, $length){
        if (strlen($str_cut) > $length){
            for($i=0; $i < $length; $i++){
                if (ord($str_cut[$i]) > 128){
                    $i;
                }
            }
            $str_cut = mb_substr($str_cut, 0, $i, 'utf-8');
        }
        return $str_cut;
    }
    
    public function get_numAction(){
        $sql = "SELECT COUNT(*) AS num FROM exposition";
        $data = $this->group->fetchOne($sql);
        echo $data['num'] + 6000;exit;
    }
}

?>