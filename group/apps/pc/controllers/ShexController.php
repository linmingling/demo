<?php
namespace Apps\Pc\Controllers;

use Library\Com\Funs;

class ShexController extends ControllerBase {
	
	private $funs_model;
	private $sms_model;
	private $location_model;
	private $point_model;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->location_model = new \Library\Com\Location();
		$this->point_model = new \Library\Com\QxPoint();
	}

    public function indexAction(){
    	$this->view->setVar("pcHome", $this->config->pcHome);
    	$this->view->setVar("zxHome", $this->config->zxHome);
    	
//         for($n=50708;$n<=52408;$n++){
//             $id[] = "'".'QQ0'.$n."'";
//         }
//         echo '<pre>';print_r(implode(',', $id));exit;
        
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
//         echo '<pre>';print_r($address['content']['address']);exit;
        
        $sql = "SELECT COUNT(*) FROM shex";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data[0] + 6000);
        
        
        $this->session->set('url_source', $from);
        $this->session->set('sh_ip', $ip);
        $this->session->set('ip_address', $address['content']['address']);
        
        //帮砍商品
        $goods_sql = "SELECT * FROM markdown_goods WHERE action_id=11";
        $goods_list = $this->group->fetchAll($goods_sql);
        foreach ($goods_list as $k){
            $goods_id[$k['goods_id']] = $k;
        }
        $M = new \Library\Model\Goods();
        $data = $M->idList(array('idList'=>array_keys($goods_id)));
        foreach($data['list'] as $k) $box[$k['id']] = $k;
//         echo '<pre>';print_r($goods_list);exit;
        foreach($goods_list as $k){
            $goods[] = array(
                'goods_id' => $k['goods_id'],
                'name' => $box[$k['goods_id']]['name'],
				'goods_number' => $k['goods_number'],
                'img' => $this->config->pcHome."/".$box[$k['goods_id']]['image']['original'],
                'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
                'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
                'desc' => htmlspecialchars($k['desc']),
            );
        }
        for($bk=0; $bk<(count($goods)); $bk++){
            $goods_arr[intval($bk/8)][] = $goods[$bk];
        }
//         echo '<pre>';print_r($goods_arr);exit;
        $this->view->setVar("goods", $goods_arr);
        
        
        //秒杀商品
        $seckill_sql = "SELECT * FROM seckill_goods as a left join seckill_time as b on a.time = b.id WHERE a.action_id=4 order by b.day asc,b.starttime asc";
        $seckill_list = $this->group->fetchAll($seckill_sql);
        if(!empty($seckill_list)){
            foreach ($seckill_list as $k){
                $seckill_id[$k['goods_id']] = $k;
            }
            $M = new \Library\Model\Goods();
            $data = $M->idList(array('idList'=>array_keys($seckill_id)));
            foreach($data['list'] as $k) $box[$k['id']] = $k;
            foreach($seckill_list as $k){
                $seckill[] = array(
                    'goods_id' => $k['goods_id'],
                    'name' => $box[$k['goods_id']]['name'],
					'goods_number' => $k['goods_number'],
                    'img' => $this->config->pcHome."/".$box[$k['goods_id']]['image']['original'],
                    'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
                    'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
                    'desc' => htmlspecialchars($k['desc']),
                );
            }
        } else {
            $seckill = '';
        }
        for($ms=0; $ms<(count($seckill)); $ms++){
            $seckill_arr[intval($ms/8)][] = $seckill[$ms];
        }
//         echo '<pre>';print_r($seckill);exit;
        $this->view->setVar("seckill", $seckill_arr);
        
        //特价商品展示
        $tejia_sql = "SELECT * FROM seckill_goods WHERE action_id=5";
        $tejia_list = $this->group->fetchAll($tejia_sql);
        if(!empty($tejia_list)){
            foreach ($tejia_list as $k){
                $tejia_id[$k['goods_id']] = $k;
            }
            $M = new \Library\Model\Goods();
            $data = $M->idList(array('idList'=>array_keys($tejia_id)));
            foreach($data['list'] as $k) $box[$k['id']] = $k;
            foreach($tejia_list as $k){
                $tejia[] = array(
                    'goods_id' => $k['goods_id'],
                    'name' => $box[$k['goods_id']]['name'],
					'goods_number' => $k['goods_number'],
                    'img' => $this->config->pcHome."/".$box[$k['goods_id']]['image']['original'],
                    'market_price' => round((float)$box[$k['goods_id']]['price']['market'],2),
                    'promote_price' => round((float)$box[$k['goods_id']]['price']['promote'],2),
                    'desc' => htmlspecialchars($k['desc']),
                );
            }
        } else {
            $tejia = '';
        }
        for($tj=0; $tj<(count($tejia)); $tj++){
            $tejia_arr[intval($tj/8)][] = $tejia[$tj];
        }
        //         echo '<pre>';print_r($tejia);exit;
        $this->view->setVar("tejia", $tejia_arr);
    }
	

    //获取短信验证码
    public function getVerifyAction(){
    
        $name = trim($_POST['name']);//姓名
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $ip = $this->session->get('sh_ip');//ip所属城市
        $address = $this->session->get('ip_address');//城市
        $verify = rand(1000, 9999);//获取随机验证码
    
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
    
        $sql = "SELECT * FROM shex WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if(time() - $data['update_verify_time'] < 60){
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
            } else {
                $sql = "UPDATE shex SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."'";
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
            $sql = "INSERT INTO shex (name, phone, ip, ip_address, url_source, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip."','".$address."','".$url_source."','".$verify."','0','".time()."','".time()."')";
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
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();
    
        $sql = "SELECT * FROM shex WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE shex SET state=1,verify_time='".time()."',area='".$area."',address='".$address."' WHERE phone='".$phone."'";
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
            $ajax_result['errmsg'] = "请先完成报名！";
            die(json_encode($ajax_result));
        }
    }
    
    //预约
    public function subscribeAction(){
         
        $phone = trim($_POST['phone']);
        $type = trim($_POST['type']);
        $goods_name = trim($_POST['goods_name']);
        $goods_id = trim($_POST['goods_id']);
        
        $sql = "SELECT id FROM shex_subscribe WHERE phone='".$phone."' AND type='".$type."' AND goods_id='".$goods_id."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "你已经预约过该商品了！";
            die(json_encode($ajax_result));
        } else {
            $sql = "INSERT INTO shex_subscribe (phone, type, goods_name, goods_id, add_time) VALUES('".$phone."','".$type."','".$goods_name."','".$goods_id."','".time()."')";
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
        if(empty($verify)){
            $content = '恭喜您成功报名优居家博会，活动当天请凭收到的免费门票入场，搜索微信公众号：优居生活（微信号：youju2099），点击关注，了解活动最新动态【腾讯家居·优居网】';
        } else {
            $content = '【腾讯家居·优居网】您的短信验证码为：'.$verify;
        }
        $this->sms_model->sendSms($phone, $content);//发送短信，返回0为发送成功否则发送失败
    }
    
    public function get_numAction(){
        $sql = "SELECT COUNT(*) FROM shex";
        $data = $this->group->fetchOne($sql);
        echo $data[0] + 6000;exit;
    }
}

?>