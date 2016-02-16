<?php
namespace Apps\Pc\Controllers;

class QmjjgController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QmjjgPoint($this->group);
	}

    public function indexAction(){
    	$this->view->setVar("pcHome", $this->config->pcHome);
    	$this->view->setVar("zxHome", $this->config->zxHome);
    	$this->view->setVar("payDomain", $this->config->payDomain);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $city_code = empty($_GET['city']) ? '' : $_GET['city'];
        $content = $this->point_model->getCity($city_code);
//         echo '<pre>';print_r($content);exit;
      
        //城市列表
//         $city_list = $this->point_model->getPoint();
//         foreach ($city_list as $k => $key){
//             $city_list[$k]['city'] = $key['city'];
//         }
//         echo '<pre>';print_r($city_list);exit;
        
        $sql = "SELECT COUNT(*) FROM qmjjg_registration WHERE city_code='changzhou'";
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("count", $data[0] + 8000);
        
        $sql = "SELECT * FROM qmjjg_registration WHERE city_code='changzhou'";
        $list = $this->group->fetchAll($sql);
        foreach ($list as $k => $key){
            $list[$k]['name'] = $this->substr_cut($key['name'], 1).'**';
            $list[$k]['phone']= substr($key['phone'], 0, 4).'****'.substr($key['phone'], -3);
        }
//         echo '<pre>';print_r($list);exit;
        //品牌logo
//         $brand_list = explode(',', $content['brand_list']);
//         $this->view->setVar("brand_arr", $brand_list);
//         echo '<pre>';print_r($brand_list);exit;
        
        $this->session->set('url_source', $from);
        $this->session->set('qmjjg_ip', $content['ip']);
        $this->session->set('ip_city', $content['ip_city']);
        $this->session->set('city', '常州');
        $this->session->set('city_code', 'changzhou');
        
        $this->view->setVar("list", $list);
        $this->view->setVar("content", $content);
    }


    //获取短信验证码
    public function getVerifyAction(){

      	$name = trim($_POST['name']);//姓名
    	$phone = trim($_POST['phone']);//手机号
    	$url_source = $this->session->get('url_source');//url来源
    	$ip_city = $this->session->get('ip_city');//ip所属城市
    	$city = $this->session->get('city');//城市
    	$city_code = $this->session->get('city_code');//城市代号
        $verify = rand(1000, 9999);//获取随机验证码
        $ip = $this->session->get('qmjjg_ip');//ip地址
        
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    } else if(time() - $data['update_verify_time'] < 60){
		        $ajax_result['errcode'] = 1001;
		        $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
		    } else {
		        $sql = "UPDATE qmjjg_registration SET verify='".$verify."',update_verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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
            $sql = "INSERT INTO qmjjg_registration (name, phone, ip_city, city, city_code, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip_city."','".$city."','".$city_code."','".$url_source."','".$ip."','0','".$verify."','0','".time()."','".time()."')";
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
            $ajax_result['errmsg'] = "请输入验证码";
            die(json_encode($ajax_result));
        }
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();

        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE qmjjg_registration SET state=1,verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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

    //提交信息
    public function submitAction(){
    
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $area = trim($_POST['area']);
        $address = trim($_POST['address']);
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
        if(empty($address)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请输入您的详细地址";
            die(json_encode($ajax_result));
        }
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();
    
        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            $sql = "UPDATE qmjjg_registration SET name='".$name."',area='".$area."',address='".$address."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
            $result = $this->group->execute($sql);
            if($result){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "报名成功";
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        } else {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "请先获取验证码！";
            die(json_encode($ajax_result));
        }
    }
    
    //手机号验证+信息提交
    public function submit_dbbmAction(){
    
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
        $name = trim($_POST['name']);
        $area = trim($_POST['area']);
        $address = trim($_POST['address']);
        $city_code = $this->session->get('city_code');//城市代号
    
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
        if(empty($name)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写姓名";
            die(json_encode($ajax_result));
        }
        if(empty($address)){
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "请输入您的详细地址";
            die(json_encode($ajax_result));
        }
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();
    
        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
            } else if($data['verify'] == $verify){
                $sql = "UPDATE qmjjg_registration SET state=1,name='".$name."',area='".$area."',address='".$address."',verify_time='".time()."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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
    
    //发送短信
    public function sendAction(){
        $time = '2015年11月07日';
        $address = '常州市天宁区飞龙路68号飞龙红星美凯龙';
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '【腾讯优居】您已成功领取全民家居购门票，24小时内会有工作人员与您取得联系，与您核实地址，并寄送门票，凭此门票可参与品牌抵扣，下订有奖等活动，活动时间：'.$time.'，活动地址：'.$address.'，与您不见不散。';
            $this->sms_model->send_sms($phone, $content);//发送短信，返回0为发送成功否则发送失败
        } else {
            $content = '【腾讯优居】您的短信验证码是：'.$verify;
            $this->sms_model->code_send($phone, $content);//发送短信，返回0为发送成功否则发送失败
        }
    }
    
    
    public function get_numAction(){
        $sql = "SELECT COUNT(*) FROM qmjjg_registration WHERE city_code='changzhou'";
        $data = $this->group->fetchOne($sql);
        echo $data[0] + 8000;exit;
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
}

?>