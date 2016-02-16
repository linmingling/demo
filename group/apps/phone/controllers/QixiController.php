<?php
namespace Apps\Phone\Controllers;

class QixiController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	private $jssdk;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QxPoint();
		$this->jssdk = new \Library\Com\JSSDK();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        header("location: http://".$_SERVER['SERVER_NAME']."/phone/shex/index");exit;
        
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $city_code = empty($_GET['city']) ? '' : $_GET['city'];
        $content = $this->point_model->getCity($city_code);
//           echo '<pre>';print_r($content);exit;
      
        $sql = "SELECT COUNT(id) FROM qx_registration WHERE city_code='".$content['city_code']."'";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data[0] + 8000);
//         echo '<pre>';print_r($data[0]);exit;
        
        $this->session->set('url_source', $from);
        $this->session->set('qx_ip', $content['ip']);
        $this->session->set('ip_city', $content['ip_city']);
        $this->session->set('city', $content['city']);
        $this->session->set('city_code', $content['city_code']);
        
        $brand = $this->point_model->getNewBrand();
        $brand_list = $brand[$content['city_code']];
        for ($a=0;$a<(count($brand_list)/9);$a++){
            $brand_arr[$a] = array_slice($brand_list, $a*9, 9);
        }
//         echo '<pre>';print_r($brand_arr);exit;
        $this->view->setVar("brand_arr", $brand_arr);
//         echo '<pre>';print_r($brand[$content['city_code']]);exit;
        
        
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("content", $content);
        $this->view->setVar("is_city", $city_code);
        
        if($from == 'weixincd2'){
            $this->view->setVar("is_weixin", 1);
        } else {
            $this->view->setVar("is_weixin", 0);
        }
    }


    //提交信息
    public function submitAction(){

      	$name = trim($_POST['name']);//姓名
    	$phone = trim($_POST['phone']);//手机号
    	$url_source = $this->session->get('url_source');//url来源
    	$ip_city = $this->session->get('ip_city');//ip所属城市
    	$city = $this->session->get('city');//城市
    	$city_code = $this->session->get('city_code');//城市代号
    	$btn_id = $_POST['btn_id'];//报名按钮id
        $ip = $this->session->get('qx_ip');//ip地址
        
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
        
        $sql = "SELECT * FROM qx_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    } else {
		        $sql = "UPDATE qx_registration SET name='".$name."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
		        $result = $this->group->execute($sql);
		        if($result){
	                $ajax_result['errcode'] = 0;
	                $ajax_result['errmsg'] = "信息提交成功！";
	            } else {
	                $ajax_result['errcode'] = 1003;
	                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
	            }
		    }
		    die(json_encode($ajax_result));
        } else {
            $sql = "INSERT INTO qx_registration (name, phone, ip_city, city, city_code, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip_city."','".$city."','".$city_code."','".$url_source."','".$ip."','".$btn_id."','0','0','0','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "信息提交成功！";
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        }
    }

    //获取短信验证码
    public function getVerifyAction(){
    
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $city = $this->session->get('city');//城市
        $city_code = $this->session->get('city_code');//城市代号
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
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请先填写信息，再获取验证码！";
            die(json_encode($ajax_result));
        }
    }
    
    //提交验证码
    public function submit_codeAction(){
        
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
    	$city_code = $this->session->get('city_code');//城市代号
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        if(empty($verify)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请填写验证码";
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
                $sql = "UPDATE qx_registration SET state=1,verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
	            $result = $this->group->execute($sql);
                if($result){
                    $url_source = $this->session->get("url_source");
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "报名成功";
                    $ajax_result['url_source'] = empty($url_source) ? '' : '?from='.$url_source;
                    $this->session->set('qx_phone', $phone);//session用于领取红包
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
            $ajax_result['errmsg'] = "请先填写信息，再获取验证码！";
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
}

?>