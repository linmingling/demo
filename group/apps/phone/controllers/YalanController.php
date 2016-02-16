<?php
namespace Apps\Phone\Controllers;

class YalanController extends ControllerBase {

	private $funs_model;
	private $sms_model;
	private $location_model;
	private $jssdk;

    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->location_model = new \Library\Com\Location();
		$this->jssdk = new \Library\Com\JSSDK();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $ip = $this->location_model->getClientIp();
        $address = $this->location_model->getLocation($ip);

        $this->session->set('yalan_ip', $ip);
        $this->session->set('ip_city', $address['content']['address']);

//         echo '<pre>';print_r($address);exit;


        $sql = "SELECT COUNT(id) FROM yalan_registration";
        $count = $this->group->fetchOne($sql);
        $this->view->setVar("count", $count[0] + 8000);
//         echo '<pre>';print_r($sql);exit;

        $this->session->set('url_source', $from);
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
    }

    //提交信息
    public function submitAction(){

      	$name = trim($_POST['name']);//姓名
    	$phone = trim($_POST['phone']);//手机号
    	$btn_id = trim($_POST['btn_id']);//报名按钮id
    	$url_source = $this->session->get('url_source');//url来源
    	$ip_city = $this->session->get('ip_city');//ip所属城市
        $ip = $this->session->get('yalan_ip');//ip地址

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

        $sql = "SELECT * FROM yalan_registration WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $sql = "UPDATE yalan_registration SET num=num+1 WHERE phone='".$phone."'";
                $result = $this->group->execute($sql);
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    } else {
		        $sql = "UPDATE yalan_registration SET name='".$name."' WHERE phone='".$phone."'";
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
            $sql = "INSERT INTO yalan_registration (name, phone, ip_city, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time, num) VALUES('".$name."','".$phone."','".$ip_city."','".$url_source."','".$ip."','".$btn_id."','0','0','0','".time()."','1')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $this->post_crm(52, $name, $phone, '');
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
        $ip_city = $this->session->get('ip_city');//ip所属城市
        $verify = rand(1000, 9999);//获取随机验证码
        $ip = $this->session->get('yalan_ip');//ip地址

        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }

        $sql = "SELECT * FROM yalan_registration WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $sql = "UPDATE yalan_registration SET num=num+1 WHERE phone='".$phone."'";
                $result = $this->group->execute($sql);
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if(time() - $data['update_verify_time'] < 60){
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
            } else {
                $sql = "UPDATE yalan_registration SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."'";
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
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "请先填写第一的信息！";
            die(json_encode($ajax_result));
        }
    }

    //提交验证码
    public function submit_codeAction(){

        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
        $address = trim($_POST['address']);
        $area = trim($_POST['area']);

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

        $sql = "SELECT * FROM yalan_registration WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $sql = "UPDATE yalan_registration SET num=num+1 WHERE phone='".$phone."'";
                $result = $this->group->execute($sql);
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE yalan_registration SET address='".$address."',area='".$area."',state=1,verify_time='".time()."' WHERE phone='".$phone."'";
	            $result = $this->group->execute($sql);
                if($result){
                    $this->post_crm(52, '', $phone, $address);
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

    public function post_crm($city_id, $name, $phone, $address){
        $sign = md5('yoju360_crm');
        $key = md5($sign.'add'.$city_id.date('Y-m-d'));
        $url = $this->config->crm_host.'/pc/api/user/'.$key.'/add/'.$city_id;
        $data = '{"name": "'.$name.'", "phone": "'.$phone.'", "address": "'.$address.'"}';
        return $this->funs_model->curlPOST($url, $data);
    }

    //页面布点
    public function clickAction(){
        if($this->request->isAjax()){
            $id = trim($_POST['btn_id']);
            $url_source = $this->session->get("url_source");
            $sql = "INSERT INTO yalan_budian (btn_id, url_source, add_time) VALUES('".$id."','".$url_source."','".time()."')";
            $this->group->execute($sql);
        }
    }

    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '【腾讯优居】恭喜您成功领取雅兰工厂店团购会门票，工作人员会于24小时内与您电话联系，确认名额并邮寄门票，请保持电话畅通，如无法接收门票，您也可以此短信作为签到入场的凭证。时间：11月21日，地址：深圳湾体育中心春茧体育馆。';
            $json = $this->sms_model->send_sms($phone, $content);//发送短信，返回0为发送成功否则发送失败
        } else {
            $content = '【腾讯优居】您的短信验证码是：'.$verify;
            $json = $this->sms_model->code_send($phone, $content);//发送短信，返回0为发送成功否则发送失败
        }
        echo $json;exit;
    }
}

?>