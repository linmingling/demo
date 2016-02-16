<?php
namespace Apps\Phone\Controllers;

class QmjjgController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	private $jssdk;
	private $user;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QmjjgPoint($this->group);
		$this->jssdk = new \Library\Com\JSSDK();
		$this->user = new \Library\Model\User();
	}

    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $from = empty($_GET['from']) ? '' : $_GET['from'];
        $city_code = empty($_GET['city']) ? '' : $_GET['city'];
		header("Location:http://".$_SERVER['SERVER_NAME']."/phone/zhan/fyinvite/9?from=dyj");
        $content = $this->point_model->getCity($city_code);
//           echo '<pre>';print_r($content);exit;
      
        //城市列表
        $city_list = $this->point_model->getPoint();
        foreach ($city_list as $k => $key){
            $city_list[$k]['city'] = $key['city'];
        }
//         echo '<pre>';print_r($city_list);exit;
        
        $sql = "SELECT COUNT(id) FROM qmjjg_registration WHERE city_code='".$content['city_code']."'";
        $count = $this->group->fetchOne($sql);
        $this->view->setVar("count", $count[0] + 8000);
//         echo '<pre>';print_r($sql);exit;
        
        $this->session->set('url_source', $from);
        $this->session->set('qmjjg_ip', $content['ip']);
        $this->session->set('ip_city', $content['ip_city']);
        $this->session->set('city', $content['city']);
        $this->session->set('city_code', $content['city_code']);
        $this->session->set('action_time', $content['time']);
        $this->session->set('action_address', $content['address']);
        $this->session->set('action_id', $content['action_id']);
        
        
        //品牌logo
        $brand_list = explode(',', $content['brand_list']);
        for ($a=0;$a<(count($brand_list)/9);$a++){
            $brand_arr[$a] = array_slice($brand_list, $a*9, 9);
        }
//         echo '<pre>';print_r($brand_arr);exit;
        $this->view->setVar("brand_arr", $brand_arr);
//         echo '<pre>';print_r($brand[$content['$brand_list']]);exit;
        
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("content", $content);
        $this->view->setVar("is_city", $city_code);
        $this->view->setVar("city_list", $city_list);
        if(strstr($from, 'hsad')){
            $this->view->setVar("is_souhu", 1);
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
        $ip = $this->session->get('qmjjg_ip');//ip地址
        
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
        
        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if($data['state'] == 1){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已成功报名，请勿重复报名！";
		    } else {
		        $sql = "UPDATE qmjjg_registration SET name='".$name."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
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
            $sql = "INSERT INTO qmjjg_registration (name, phone, ip_city, city, city_code, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip_city."','".$city."','".$city_code."','".$url_source."','".$ip."','".$btn_id."','0','0','0','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $city_id = $this->getCity($city);
                $this->post_crm($city_id, $name, $phone, '');
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
        
        $name = trim($_POST['name']);//姓名
        $phone = trim($_POST['phone']);//手机号
        $url_source = $this->session->get('url_source');//url来源
        $ip_city = $this->session->get('ip_city');//ip所属城市
        $city = $this->session->get('city');//城市
        $btn_id = $_POST['btn_id'];//报名按钮id
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
            $sql = "INSERT INTO qmjjg_registration (name, phone, ip_city, city, city_code, url_source, ip, btn_id, verify, verify_time, update_verify_time, add_time) VALUES('".$name."','".$phone."','".$ip_city."','".$city."','".$city_code."','".$url_source."','".$ip."','".$btn_id."','".$verify."','0','".time()."','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $city_id = $this->getCity($city);
                $this->post_crm($city_id, $name, $phone, '');
                $ajax_result['errcode'] = 0;
                $ajax_result['verify'] = $verify;
                $ajax_result['errmsg'] = "验证码已发送！";
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        }
    }
    
    //提交验证码
    public function submit_codeAction(){
        
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
    	$city_code = $this->session->get('city_code');//城市代号
    	$action_id = $this->session->get('action_id');
    	
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
                    $sql = "SELECT * FROM yizhangou_baoming WHERE phone='".$phone."'";
                    $res = $this->group->fetchOne($sql);
                    if(!$res){
                        $user_id = $this->checkUser($phone);
                        $sql = "insert into yizhangou_baoming(`action_id`,`user_name`,`user_id`,`phone`,`time`,`fanye`,`auth`) values('".$action_id."','','".$user_id."','".$phone."','".date('Y-m-d H:i:s')."','1','1')";
                        $this->group->execute($sql);
                    }
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
    
    //提交地址
    public function submit_addressAction(){
    
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $area = trim($_POST['area']);
        $city_code = $this->session->get('city_code');//城市代号
    
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        $time = date('Y-m-d H:i:s', time());
        $strtotime = time();
    
        $sql = "SELECT * FROM qmjjg_registration WHERE phone='".$phone."' AND city_code='".$city_code."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            $sql = "UPDATE qmjjg_registration SET address='".$address."',area='".$area."' WHERE phone='".$phone."' AND city_code='".$city_code."'";
            $result = $this->group->execute($sql);
            if($result){
                $city_id = $this->getCity($this->session->get('city'));
                $this->post_crm($city_id, '', $phone, $address);
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "提交成功";
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        } else {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "请先填写信息";
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
            $city = $this->session->get("city");
            $city_code = $this->session->get("city_code");
            $url_source = $this->session->get("url_source");
            $sql = "INSERT INTO qmjjg_budian (btn_id, city, city_code, url_source, add_time) VALUES('".$id."','".$city."','".$city_code."','".$url_source."','".time()."')";
            $this->group->execute($sql);
        }
    }

    //发送短信
    public function sendAction(){
        $time = $this->session->get("action_time");
        $address = $this->session->get("action_address");
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['verify']);
        if(empty($verify)){
            $content = '【腾讯优居】您已成功领取全民家居购门票，24小时内会有工作人员与您取得联系，与您核实地址，并寄送门票，凭此门票可参与品牌抵扣，下订有奖等活动，活动时间：'.$time.'，活动地址：'.$address.'，与您不见不散。回T退订';
            $json = $this->sms_model->send_sms($phone, $content);//发送短信，返回0为发送成功否则发送失败
        } else {
            $content = '【腾讯优居】您的短信验证码是：'.$verify;
            $json = $this->sms_model->code_send($phone, $content);//发送短信，返回0为发送成功否则发送失败
        }
        echo $json;exit;
    }
    
    public function getCity($city){
        $data = array(
            '6'=>'南京',
            '7'=>'沧州',
            '8'=>'聊城',
            '9'=>'齐齐哈尔',
            '10'=>'邢台',
            '11'=>'德州',
            '12'=>'唐山',
            '13'=>'秦皇岛',
            '14'=>'济南',
            '15'=>'张家口',
            '16'=>'常州',
            '17'=>'廊坊',
            '18'=>'邯郸',
            '19'=>'成都',
            '20'=>'衡水',
            '21'=>'太原',
            '22'=>'石家庄',
            '23'=>'哈尔滨',
            '24'=>'潍坊',
            '25'=>'青岛',
            '26'=>'昆明',
            '27'=>'无锡',
            '28'=>'绥化',
            '29'=>'泰安',
            '30'=>'保定',
            '31'=>'滨州',
            '32'=>'承德',
            '33'=>'淄博',
            '34'=>'菏泽',
            '35'=>'上海',
            '36'=>'北京',
            '37'=>'天津',
            '38'=>'深圳',
            '51'=>'东营'
        );
        foreach ($data as $k => $key){
            if($key == $city){
                return $k;
            }
        }
    }
    
    public function checkUser($phone){
        $check = $this->user->info(array('phone'=>$phone));
        if(!$check){
            $data = $this->user->register(array('phone'=>$phone,'unionid'=>''));
            return $data['user_id'];
        } else {
            return $check['userId'];
        }
    }
}

?>