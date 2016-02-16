<?php
namespace Apps\Pc\Controllers;

use Library\Com\Funs;

class HebController extends ControllerBase {
	
	private $sms_model;
	
    public function initialize(){
        $this->sms_model = new \Library\Com\Sms();
	}
	public function indexAction(){
		$this->view->setVar("pcHome", $this->config->pcHome);
		$this->view->setVar("zxHome", $this->config->zxHome);
	}
    //提交信息
    public function submitAction(){

      	$name = trim($_POST['name']);//姓名
    	$phone = trim($_POST['phone']);//手机号
        
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
        
        $sql = "SELECT * FROM heb WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
	        $ajax_result['errcode'] = 1002;
	        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    die(json_encode($ajax_result));
        } else {
            $sql = "INSERT INTO heb (name, phone, add_time) VALUES('".$name."','".$phone."','".time()."')";
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
    
    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '恭喜您成功报名10.1-10.7华美太古广场开业活动，活动当天请凭收到报名短信入场，搜索微信公众号：优居生活（微信号：youju2099），点击关注，了解活动最新动态！咨询电话：0451-51975523【腾讯家居·优居网】';
        } else {
            $content = '【腾讯家居·优居网】您的短信验证码为：'.$verify;
        }
        $this->sms_model->sendSms($phone, $content);//发送短信，返回0为发送成功否则发送失败
    }
}
        
?>