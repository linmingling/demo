<?php
namespace Apps\Pc\Controllers;

class QixiController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QxPoint();
	}

    public function indexAction(){
    	$this->view->setVar("pcHome", $this->config->pcHome);
    	$this->view->setVar("zxHome", $this->config->zxHome);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $city_code = empty($_GET['city']) ? '' : $_GET['city'];
        $content = $this->point_model->getCity($city_code);
//         echo '<pre>';print_r($content);exit;
      
        if(strstr($content['ip_city'], '上海')){
            header("location: http://sh.yoju360.com");exit;
        }
        
        $sql = "SELECT COUNT(*) FROM qx_registration WHERE city_code='".$content['city_code']."'";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data[0] + 8000);
        
        $brand = $this->point_model->getNewBrand();
        $this->view->setVar("brand_list", $brand[$content['city_code']]);
        
        $this->session->set('url_source', $from);
        $this->session->set('qx_ip', $content['ip']);
        $this->session->set('ip_city', $content['ip_city']);
        $this->session->set('city', $content['city']);
        $this->session->set('city_code', $content['city_code']);
        $this->view->setVar("content", $content);
        if($content['city_code'] == 'dongguan'){
            $this->view->pick("qixi/dongguan");
        }
    }


    //获取短信验证码
    public function getVerifyAction(){

      	$name = trim($_POST['name']);//姓名
    	$phone = trim($_POST['phone']);//手机号
    	$url_source = $this->session->get('url_source');//url来源
    	$ip_city = $this->session->get('ip_city');//ip所属城市
    	$city = $this->session->get('city');//城市
    	$city_code = $this->session->get('city_code');//城市代号
    	$btn_id = 0;
        $verify = rand(1000, 9999);//获取随机验证码
        $ip = $this->session->get('qx_ip');//ip地址
        
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM qx_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    } else if(time() - $data['update_verify_time'] < 60){
		        $ajax_result['errcode'] = 1001;
		        $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
		    } else {
		        $sql = "UPDATE qx_registration SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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
            $sql = "INSERT INTO qx_registration (name, phone, ip_city, city, city_code, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip_city."','".$city."','".$city_code."','".$url_source."','".$ip."','".$btn_id."','".$verify."','0','".time()."','".time()."')";
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
        
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
    	$city_code = $this->session->get('city_code');//城市代号
        
    	if(empty($name)){
    	    $ajax_result['errcode'] = 1000;
    	    $ajax_result['errmsg'] = "请填写姓名";
    	    die(json_encode($ajax_result));
    	}
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        if(empty($verify)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请输入验证码";
            die(json_encode($ajax_result));
        }
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();

        $sql = "SELECT * FROM qx_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE qx_registration SET state=1,verify_time='".time()."',name='".$name."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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


    //页面布点
    public function clickAction(){
        if($this->request->isAjax()){
            $id = trim($_POST['btn_id']);
            $city = $this->session->get("city");
            $city_code = $this->session->get("city_code");
            $url_source = $this->session->get("url_source");
            $sql = "INSERT INTO qx_budian (btn_id, city, city_code, url_source, add_time) VALUES('".$id."','".$city."','".$city_code."','".$url_source."','".time()."')";
            $this->group->execute($sql);
        }
    }

    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '恭喜您成功报名七夕家装节，活动当天请凭报名姓名和手机号入场，搜索微信公众号：优居生活（微信号：youju2099)，点击关注，了解活动最新动态【腾讯家居·优居网】';
        } else {
            $content = '【腾讯家居·优居网】您的短信验证码为：'.$verify;
        }
        $this->sms_model->sendSms($phone, $content);//发送短信，返回0为发送成功否则发送失败
    }
    
    
    public function get_numAction(){
        $sql = "SELECT COUNT(*) FROM qx_registration";
        $data = $this->group->fetchOne($sql);
        echo $data[0] + 144000;exit;
    }
    
}

?>