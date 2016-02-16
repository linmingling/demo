<?php
namespace Apps\Phone\Controllers;

class AupuController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	private $jssdk;
	private $location_model;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\AupuPoint($this->group);
		$this->location_model = new \Library\Com\Location();
		$this->jssdk = new \Library\Com\JSSDK();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $city_code = empty($_GET['city']) ? '' : $_GET['city'];
        $content = $this->point_model->getCity($city_code);
//           echo '<pre>';print_r($content);exit;
      
        //城市列表
        $city_list = $this->point_model->getPoint();
        foreach ($city_list as $k => $key){
            $city_list[$k]['city'] = $key['city'];
        }
//         echo '<pre>';print_r($city_list);exit;
        
        $sql = "SELECT COUNT(id) FROM aupu_registration WHERE city_code='".$content['city_code']."'";
        $count = $this->group->fetchOne($sql);
        $this->view->setVar("count", abs(133 - $count[0]));
        
        $this->session->set('url_source', $from);
        $this->session->set('aupu_ip', $content['ip']);
        $this->session->set('ip_city', $content['ip_city']);
        $this->session->set('city', $content['city']);
        $this->session->set('city_code', $content['city_code']);
        
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("content", $content);
        $this->view->setVar("is_city", $city_code);
        $this->view->setVar("city_list", $city_list);
    }


    //提交信息
    public function submitAction(){
    
        $phone = trim($_POST['phone']);
        $area = trim($_POST['area']);
        $address = trim($_POST['address']);
        $verify = trim($_POST['code']);
        $city_code = $this->session->get('city_code');//城市代号
        
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
    
        $sql = "SELECT * FROM aupu_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE aupu_registration SET state=1,verify_time='".time()."',area='".$area."',address='".$address."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
                $result = $this->group->execute($sql);
                if($result){
                    $city_id = $this->getCity($this->session->get('city'));
                    $this->post_crm($city_id, '', $phone, $address);
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

    //获取短信验证码
    public function getVerifyAction(){
        
        $name = trim($_POST['name']);//姓名
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $ip = $this->session->get('aupu_ip');//ip地址
        $ip_city = $this->session->get('ip_city');//ip所属城市
        $city_code = $this->session->get('city_code');//城市代号
        $city = $this->session->get('city');//城市代号
        $btn_id = $_POST['btn_id'];//报名按钮id
        $verify = rand(1000, 9999);//获取随机验证码
        
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM aupu_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if(time() - $data['update_verify_time'] < 60){
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
            } else {
                $sql = "UPDATE aupu_registration SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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
            $sql = "INSERT INTO aupu_registration (name, phone, city, city_code, url_source, ip, ip_city, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$city."','".$city_code."','".$url_source."','".$ip."','".$ip_city."','".$btn_id."','".$verify."','0','".time()."','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $city_id = $this->getCity($this->session->get('city'));
                $this->post_crm($city_id, $name, $phone, '');
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
    
    public function getCity($city){
        $data = array(
            '39'=>'宁波',
        	'40'=>'太原',
        	'41'=>'成都',
        	'42'=>'武汉',
        	'43'=>'长沙',
        	'44'=>'北京',
        	'45'=>'杭州',
        	'46'=>'镇江',
        	'47'=>'合肥',
        	'48'=>'兰州',
        );
        foreach ($data as $k => $key){
            if($key == $city){
                return $k;
            }
        }
    }
    
    public function post_crm($city_id, $name, $phone, $address){
        $sign = md5('yoju360_crm');
        $key = md5($sign.'add'.$city_id.date('Y-m-d'));
        $url = $this->config->crm_host .'/pc/api/user/'.$key.'/add/'.$city_id;
        $data = '{"name": "'.$name.'", "phone": "'.$phone.'", "address": "'.$address.'"}';
        return $this->funs_model->curlPOST($url, $data);
    }
    
    //页面布点
    public function clickAction(){
        if($this->request->isAjax()){
            $id = trim($_POST['btn_id']);
            $city = $this->session->get("city");
            $city_code = $this->session->get("city_code");
            $url_source = $this->session->get("url_source");
            $sql = "INSERT INTO aupu_budian (btn_id, city, city_code, url_source, add_time) VALUES('".$id."','".$city."','".$city_code."','".$url_source."','".time()."')";
            $this->group->execute($sql);
        }
    }
    
    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '【腾讯优居】恭喜您成功领取奥普店庆现金券，稍后会有工作人员与你取得联系，并核实名额并寄送“约惠卡”，可凭此卡或领取短信使用现金券（首单消费直返200元，最高2999元有奖免定金）以及全额免单等其他所有优惠特权,此券仅限11月7日奥普指定门店使用，门店地址：http://t.cn/RUx2woJ';
            $this->sms_model->send_sms($phone, $content);//发送短信，返回0为发送成功否则发送失败
        } else {
            $content = '【腾讯优居】您的短信验证码是：'.$verify;
            $this->sms_model->code_send($phone, $content);//发送短信，返回0为发送成功否则发送失败
        }
    }
}

?>