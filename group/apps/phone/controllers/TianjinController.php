<?php
namespace Apps\Phone\Controllers;

class TianjinController extends ControllerBase {

    private $funs_model;
	private $sms_model;
	private $point_model;
	private $jssdk;
	private $location_model;

    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QxPoint();
		$this->location_model = new \Library\Com\Location();
		$this->jssdk = new \Library\Com\JSSDK();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	

        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $ip = $this->location_model->getClientIp();//获取ip地址
        $address = $this->location_model->getLocation($ip);
//         echo '<pre>';print_r($address['content']['address']);exit;

        $sql = "SELECT COUNT(*) FROM tianjin";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data[0] + 1000);


        $this->session->set('url_source', $from);
        $this->session->set('tianjin_ip', $ip);
        $this->session->set('ip_address', $address['content']['address']);

        $this->view->setVar("signPackage", $this->jssdk->getSignPackage());
    }

    //提交信息
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

        $sql = "SELECT * FROM tianjin WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE tianjin SET state=1,verify_time='".time()."',area='".$area."',address='".$address."' WHERE phone='".$phone."'";
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

    //获取短信验证码
    public function getVerifyAction(){

        $name = trim($_POST['name']);//姓名
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $ip = $this->session->get('tianjin_ip');//ip地址
        $address = $this->session->get('ip_address');//ip所属城市
        $btn_id = $_POST['btn_id'];//报名按钮id
        $verify = rand(1000, 9999);//获取随机验证码

        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }

        $sql = "SELECT * FROM tianjin WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if(time() - $data['update_verify_time'] < 60){
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
            } else {
                $sql = "UPDATE tianjin SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."'";
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
            $sql = "INSERT INTO tianjin (name, phone, ip, ip_address, url_source, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip."','".$address."','".$url_source."','".$btn_id."','".$verify."','0','".time()."','".time()."')";
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

    //页面布点
    public function clickAction(){
        if($this->request->isAjax()){
            $id = trim($_POST['btn_id']);
            $sql = "INSERT INTO tianjin_budian (btn_id, add_time) VALUES('".$id."','".time()."')";
            $this->group->execute($sql);
        }
    }


    //发送短信
    public function sendAction(){
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '恭喜您成功获得天津优居家博会门票一张！我们将于24小时内电话联系您，核对地址并寄送门票，请注意接听！活动期间（10.1-10.7）凭票至滨海新区华北陶瓷城 蒙娜丽莎三楼，即可领取签到礼品！【腾讯家居.优居网】';
        } else {
            $content = '【腾讯家居·优居网】您的短信验证码为：'.$verify;
        }
        $this->sms_model->sendSms($phone, $content);//发送短信，返回0为发送成功否则发送失败
    }

	public function productAction(){
		$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
	}
	//页面布点
	public function product_clickAction(){
	    if($this->request->isAjax()){
	        $id = trim($_POST['btn_id']);
	        $sql = "SELECT id FROM tianjin_product_budian WHERE btn_id=".$id;
	        $data = $this->group->fetchOne($sql);
	        if(empty($data)){
	            $sql = "INSERT INTO tianjin_product_budian (btn_id, click_num) VALUES('".$id."','1')";
	            $this->group->execute($sql);
	        } else {
	            $sql = "UPDATE tianjin_product_budian SET click_num=click_num+1 WHERE btn_id=".$id;
	            $this->group->execute($sql);
	        }
	        echo 0;exit;
	    }
	}
}

?>