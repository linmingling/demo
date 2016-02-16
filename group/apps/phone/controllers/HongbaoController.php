<?php
namespace Apps\Phone\Controllers;

use Library\Com\WeiXin;
class HongbaoController extends ControllerBase {
    
	private $funs_model;
	private $sms_model;
	private $point_model;
	private $jssdk;
	private $weixinapi;
	private $domain_url;
	private $key;
	private $token;
	private $appId;
	private $appSecret;
	
    public function initialize(){
		$this->funs_model = new \Library\Com\Funs();
		$this->sms_model = new \Library\Com\Sms();
		$this->point_model = new \Library\Com\QxPoint();
		$this->jssdk = new \Library\Com\JSSDK();
		//微信服务由优居生活提供
		$this->token = "ubtaeo1422330200";
		$this->appId = "wxd43f7b5d8539e718";
		$this->appSecret = "a42b85c54c3e79b709023df894f42778";
		$this->weixinapi = new \Library\Com\WeiXinApi($this->session,$this->token,$this->appId,$this->appSecret);
	    $this->domain_url = 'http://'. $_SERVER['SERVER_NAME'];
	    $this->key = '20150716';
    }
	
    /**
     * 
     * 获取红包、发放红包
     * 
     */
    public function indexAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
        header("Location:http://'.$_SERVER['SERVER_NAME'].'/phone/qixi/index");
    }
    
    public function index2Action(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(!strpos($agent,"MicroMessenger")){
            $this->view->setVar("is_weixin", 0);
        } else {
            $this->view->setVar("is_weixin", 1);
        }
        
        $url_source = $this->session->get("url_source");
        //屏蔽广点通的分享提示
        for ($i=1;$i<=10;$i++){
            $gdt_str[] = 'guanggao'.$i;
        }
        if(in_array($url_source, $gdt_str)){
            $is_gdt = 1;
        }
        
//         echo $this->encrypt('20150806000','E', $this->key).'<br/>';
//         echo $this->encrypt('9rwLsBksBZ9pGXOhSUMSuvWdaQ','D', $this->key);exit;

        $mb = trim(empty($_GET['mb']) ? '' : $_GET['mb']);
        $from_phone =  $this->encrypt($mb, 'D', $this->key);
        if(empty($from_phone)){
//             $this->session->set('qx_phone', '13751750500');
            $phone = $this->session->get('qx_phone');
            if(empty($phone)){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "数据异常，请退出重试";
                echo "<script>alert('请先报名，再领取红包！')</script>";exit;
            }
            $sql = "SELECT * FROM qx_hongbao WHERE phone='".$phone."'";
            $data = $this->group->fetchOne($sql);
            if(empty($data)){
                $num = 25;
                $sql = "INSERT INTO qx_hongbao (phone, num, collect_num, url_source, add_time) VALUES('".$phone."','".$num."','0','".$url_source."','".time()."')";
                $result = $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if(!$resultId){
                    $ajax_result['errcode'] = 1002;
                    $ajax_result['errmsg'] = "系统繁忙，请稍后再试";
                    echo "<script>alert('系统繁忙，请稍后再试！')</script>";exit;
                }
            }
            $this->view->setVar("share_link", $this->domain_url.'/phone/hongbao/index2?mb='.$this->encrypt($phone,'E', $this->key));
            $this->view->setVar("hb", '');
        } else {
            $this->session->set('from_phone', $from_phone);
            $sql = "SELECT num FROM qx_hongbao WHERE phone='".$from_phone."'";
            $data = $this->group->fetchOne($sql);
//             echo "<pre>";print_r($data);exit;
            if(empty($data)){
                $redirect_url = $this->domain_url.'/phone/qixi/index';
                echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
            }
            if($from_phone == '20150806000'){
                $this->view->setVar("num_tips", 0);
            } else {
                $this->view->setVar("num_tips", $data['num'].'/25');
            }
            $this->view->setVar("num", $data['num']);
            $this->view->setVar("hb", 'getHB');
            $this->view->setVar("share_link", $this->domain_url.'/phone/hongbao/index2?mb='.$this->encrypt($from_phone,'E', $this->key));
        }
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("is_gdt", empty($is_gdt) ? 0 : $is_gdt);
    }
  
    //自己领自己的红包
    public function get_myhongbaoAction(){
        
        $content = $this->hongbao_array();
        $prize_id = $content['prize_id'];
        $total = $content['total'];
        $phone = $this->session->get('qx_phone');
        $sn = uniqid();
        $url_source = $this->session->get("url_source");
        
        $this->clickAction(1, $phone, $url_source);
        
        $sql = "SELECT * FROM qx_hongbao_record WHERE from_phone='".$phone."' AND phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if($data){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "您已经领取过了";
            $ajax_result['phone'] = $phone;
            $ajax_result['total'] = $data['total'];
            $ajax_result['sn'] = $data['sn'];
            $ajax_result['expire_time'] = '2015.08.30';
        } else {
            $sql = "INSERT INTO qx_hongbao_record (from_phone, phone, prize_id, total, sn, state, add_time) VALUES('".$phone."','".$phone."','".$prize_id."','".$total."','".$sn."','1','".time()."')";
            $result = $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            
            $up_sql = "UPDATE qx_hongbao SET num=num-1,collect_num=collect_num+1 WHERE phone='".$phone."'";
            $up_result = $this->group->execute($up_sql);
            
            //是否报名
            $list_sql = "SELECT id FROM qx_registration WHERE phone='".$phone."'";
            $result = $this->group->fetchOne($list_sql);

            $this->send_lq($phone, $total);
            
            if($resultId && $up_result){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "ok";
                $ajax_result['phone'] = $phone;
                $ajax_result['total'] = $total;
                $ajax_result['sn'] = $sn;
                $ajax_result['expire_time'] = '2015.08.30';
                $ajax_result['isBM'] = empty($result['id']) ? 0 : $result['id'];
            } else {
                $ajax_result['errcode'] = 1100;
                $ajax_result['errmsg'] = "系统繁忙，请稍后再试";
            }
        }
        die(json_encode($ajax_result));
    }
    
    //领取别人的红包
    public function get_hongbaoAction(){
        
        $content = $this->hongbao_array();
        $prize_id = $content['prize_id'];
        $total = $content['total'];
        $from_phone = $this->session->get('from_phone');
        $phone = trim($_POST['tel']);
        $sn = uniqid();
        
        //是否报名
        $list_sql = "SELECT id FROM qx_registration WHERE phone='".$phone."'";
        $isBM_result = $this->group->fetchOne($list_sql);
        
        $sql = "SELECT id,total,sn FROM qx_hongbao_record WHERE from_phone='".$from_phone."' AND phone='".$phone."'";
        $data = $this->group->fetchAll($sql);
        if(!empty($data[0]['id']) && $from_phone != $phone){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "您已经领过该红包了";
            $ajax_result['phone'] = $phone;
            $ajax_result['total'] = $data[0]['total'];
            $ajax_result['sn'] = $data[0]['sn'];
            $ajax_result['expire_time'] = '2015.08.30';
            $ajax_result['isBM'] = empty($isBM_result['id']) ? 0 : $isBM_result['id'];
        } else if(!empty($data[1]['id']) && $from_phone == $phone){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "您已经领过该红包了";
            $ajax_result['phone'] = $phone;
            $ajax_result['total'] = $data[1]['total'];
            $ajax_result['sn'] = $data[1]['sn'];
            $ajax_result['expire_time'] = '2015.08.30';
            $ajax_result['isBM'] = empty($isBM_result['id']) ? 0 : $isBM_result['id'];
        } else {
            $num_sql = "SELECT * FROM qx_hongbao WHERE phone='".$from_phone."'";
            $num_result = $this->group->fetchOne($num_sql);
            if($num_result['num'] <= 0){
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "红包抢完啦！";
                die(json_encode($ajax_result));
            } else {
                $sql = "INSERT INTO qx_hongbao_record (from_phone, phone, prize_id, total, sn, state, add_time) VALUES('".$from_phone."','".$phone."','".$prize_id."','".$total."','".$sn."','1','".time()."')";
                $result = $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                
                $up_sql = "UPDATE qx_hongbao SET num=num-1 WHERE phone='".$from_phone."'";
                $up_result = $this->group->execute($up_sql);
                
                $cuts_sql = "UPDATE qx_hongbao SET collect_num=collect_num+1 WHERE phone='".$phone."'";
                $cuts_result = $this->group->execute($cuts_sql);
                
                $this->send_lq($phone, $total);
                $this->send_fq($from_phone, $phone, $total);
                if($num_result['num'] - 1 == 0){
                    //红包抢完啦，发送模板消息给红包发起者
                    $this->send_num($from_phone);
                }
                
                if($resultId && $up_result && $cuts_result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "ok";
                    $ajax_result['phone'] = $phone;
                    $ajax_result['total'] = $total;
                    $ajax_result['sn'] = $sn;
                    $ajax_result['expire_time'] = '2015.08.30';
                    $ajax_result['isBM'] = empty($isBM_result['id']) ? 0 : $isBM_result['id'];
                } else {
                    $ajax_result['errcode'] = 1100;
                    $ajax_result['errmsg'] = "系统繁忙，请稍后再试";
                }
            }
        }
        die(json_encode($ajax_result));
    }

    
    /**
     * 
     *查看红包
     * 
     */

    //微信绑定
    public function listAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(!strpos($agent,"MicroMessenger")){
            echo "<script>alert('请在微信浏览器中打开！');javascript:history.back(-1);</script>";exit;
        }
        $openid = empty($_REQUEST['openid']) ? '' : $_REQUEST['openid'];
        if($openid){
            $this->session->set('hb_openid', $openid);
        } else {
            $openid = $this->session->get('hb_openid');
            if(empty($openid)){
                $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
                $redirect_url = $this->config->pcHome .'/api/Across_oauth.php?scope=snsapi_base&url='.$url;//静默授权
                echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
            }
        }
//         $openid = 'oghnDt7O_sWIel36VVufhrVdGDFA';
        $this->session->set('hb_openid', $openid);
        $sql = "SELECT * FROM qx_hongbao_binding WHERE openid='".$openid."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if(!empty($data['phone']) && !empty($data['binding_time'])){
                //已绑定，进入用户列表页
                $uesrinfo_list = json_decode($this->get_hongbaolistAction($data['phone']),true);
//                 echo '<pre>';print_r($uesrinfo_list);exit;
                $this->view->setVar("list", $uesrinfo_list);
                $this->view->setVar("count", empty($uesrinfo_list) ? 0 : count($uesrinfo_list));
                $this->view->setVar("isBD", 1);
            } else {
                //未绑定，显示绑定页
                $this->view->setVar("list", '');
                $this->view->setVar("count", 0);
                $this->view->setVar("isBD", 0);
            }
            $isBM_sql = "SELECT id FROM qx_registration WHERE phone='".$data['phone']."'";
            $isBM = $this->group->fetchOne($isBM_sql);
            if(empty($isBM['id'])){
                $this->view->setVar("share_link", $this->domain_url.'/phone/qixi/index');
            } else {
                $this->view->setVar("share_link", $this->domain_url.'/phone/hongbao/index2?mb='.$this->encrypt($data['phone'],'E', $this->key));
            }
        } else {
            $sql = "INSERT INTO qx_hongbao_binding (openid, phone, add_time, binding_time) VALUES('".$openid."','','".time()."','0')";
            $this->group->execute($sql);
            //未绑定，显示绑定页
            $this->view->setVar("list", '');
            $this->view->setVar("count", 0);
            $this->view->setVar("isBD", 0);
            $this->view->setVar("share_link", $this->domain_url.'/phone/qixi/index');
        }
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
    }
    
    //获取短信验证码
    public function getVerifyAction(){

        $verify = rand(1000, 9999);//获取随机验证码
        $openid = $this->session->get('hb_openid');
        $phone = trim($_POST['phone']);
        
        if(empty($phone)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        if(empty($openid)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "数据异常，请退出重试！";
            die(json_encode($ajax_result));
        }

        $isBD_sql = "SELECT id,binding_time FROM qx_hongbao_binding WHERE phone='".$phone."'";
        $isBD_data = $this->group->fetchOne($isBD_sql);
        if(!empty($isBD_data['binding_time'])){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "该号码已被绑定";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM qx_hongbao_binding WHERE openid='".$openid."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            if(!empty($data['phone']) && !empty($data['binding_time'])){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "您已绑定过手机号了！";
		    } else {
		        $sql = "UPDATE qx_hongbao_binding SET phone='".$phone."',verify='".$verify."' WHERE openid='".$openid."'";
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
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "系统繁忙，请退出重试fail:null";
            die(json_encode($ajax_result));
        }
    }
    
    //手机号验证
    public function submitAction(){
    
        $phone = trim($_POST['phone']);
        $verify = trim($_POST['code']);
        $openid = $this->session->get('hb_openid');
        
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
        if(empty($openid)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "数据异常，请退出重试！";
            die(json_encode($ajax_result));
        }
    
        $isBD_sql = "SELECT id FROM qx_hongbao_binding WHERE phone='".$phone."' AND binding_time <> 0";
        $isBD_data = $this->group->fetchOne($isBD_sql);
        if(!empty($isBD_data['id'])){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "该号码已被绑定";
            die(json_encode($ajax_result));
        } else {
            $sql = "SELECT * FROM qx_hongbao_binding WHERE openid='".$openid."'";
            $data = $this->group->fetchOne($sql);
            if(!empty($data)){
                if(!empty($data['phone']) && !empty($data['binding_time'])){
    		        $ajax_result['errcode'] = 1002;
    		        $ajax_result['errmsg'] = "您已绑定过手机号了！";
    		    } else if($data['verify'] != $verify){
    		        $ajax_result['errcode'] = 1004;
    		        $ajax_result['errmsg'] = "验证码错误，请重新输入！";
    		    } else if($data['phone'] != $phone){
    		        $ajax_result['errcode'] = 1001;
    		        $ajax_result['errmsg'] = "验证的手机号码错误！";
    		    } else {
    		        $sql = "UPDATE qx_hongbao_binding SET binding_time='".time()."' WHERE openid='".$openid."'";
    		        $result = $this->group->execute($sql);
    		        if($result){
    		            $ajax_result['errcode'] = 0;
    		            $ajax_result['errmsg'] = "绑定成功";
    		            $ajax_result['content'] = json_decode($this->get_hongbaolistAction($phone),true);
    		        } else {
    		            $ajax_result['errcode'] = 1003;
    		            $ajax_result['errmsg'] = "系统繁忙，请退出重试";
    		        }
                }
                die(json_encode($ajax_result));
            } else {
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "请先获取验证码！";
                die(json_encode($ajax_result));
            }
        }
    }
    
    //获取已领取的红包券/是否已报名
    public function get_hongbaolistAction($phone){
    
        $list_sql = "SELECT * FROM qx_hongbao_record WHERE phone='".$phone."' ORDER BY add_time DESC";
        $data = $this->group->fetchAll($list_sql);
        foreach ($data as $k => $key){
            $list[$k]['id'] = $key['id'];
            $list[$k]['sn'] = $key['sn'];
            $list[$k]['state'] = $key['state'];
            $list[$k]['total'] = $key['total'];
            $list[$k]['expire_time'] = '2015.08.30';
            $list[$k]['tips'] = '仅限东鹏品牌使用';
            $list[$k]['link'] = $this->domain_url.'/phone/hongbao/use?id='.$key['id'];
        }
        $list = empty($list) ? '' : $list;
        return (json_encode($list));
    }

    /**
     * 
     * 使用红包
     * 
     */
    //新版
    public function newUseAction(){
    
        $id = trim($_POST['cardID']);
        $code = trim($_POST['sn']);
        if($code != 2015){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "验证码错误！";
            die(json_encode($ajax_result));
        }
        $openid = $this->session->get('hb_openid');
        $sql = "SELECT phone FROM qx_hongbao_binding WHERE openid='".$openid."'";
        $data = $this->group->fetchOne($sql);
        $phone = $data['phone'];
    
        $res_sql = "SELECT * FROM qx_hongbao_record WHERE id='".$id."'";
        $res = $this->group->fetchOne($res_sql);
        if($phone != $res['phone']){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "非法操作，这不是您的抵购券！";
            die(json_encode($ajax_result));
        } else if($res['state'] == 3){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "抵购券已使用！";
            die(json_encode($ajax_result));
        } else {
            $sql = "UPDATE qx_hongbao_record SET state=3,verify_time='".time()."' WHERE id='".$id."'";
            $result = $this->group->execute($sql);
            if($result){
                $data['openid'] = $openid;
                $data['first'] = "您好， 您的七夕家装节抵购券验证成功";
                $data['template_id'] = "GoXq3aZNc4mU3bslhwV7A-x6dGNzd0A2OjksIsZ2m3k";
                $data['keyword1'] = "七夕家装节抵购券";
                $data['keyword2'] = "金额".$res['total']."元";
                $data['keyword3'] = date('Y-m-d H:i',time());
                $data['content'] = "通知好友报名并分享红包链接，还可领取更多的抵购红包噢！";
                $this->send($data);
                
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "验证成功！";
                die(json_encode($ajax_result));
            } else {
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "系统繁忙，请稍后再试！";
                die(json_encode($ajax_result));
            }
        }
    }
    
    /**
     * 旧版
     */
    //抵购券使用
    public function useAction(){
    	$this->view->setVar("domain", "http://".$_SERVER['SERVER_NAME']);
    	
        $id = trim($_GET['id']);
        $openid = $this->session->get('hb_openid');
        $sql = "SELECT phone FROM qx_hongbao_binding WHERE openid='".$openid."'";
        $data = $this->group->fetchOne($sql);
        $phone = $data['phone'];
        
        $res_sql = "SELECT * FROM qx_hongbao_record WHERE id='".$id."'";
        $res = $this->group->fetchOne($res_sql);
        if($phone != $res['phone']){
            echo "<script>alert('非法操作，这不是您的抵购券！')</script>";exit;
        }
        $this->session->set('sn_id', $id);
        
        $brand_list = $this->brand_listAction();
        $this->view->setVar("brand_list", $brand_list);
        
        //是否报名
        $isBM_sql = "SELECT id FROM qx_registration WHERE phone='".$phone."'";
        $isBM = $this->group->fetchOne($isBM_sql);
        if(empty($isBM['id'])){
            $this->view->setVar("share_link", $this->domain_url.'/phone/qixi/index');
        } else {
            $this->view->setVar("share_link", $this->domain_url.'/phone/hongbao/index2?mb='.$this->encrypt($phone,'E', $this->key));
        }
        
        $signPackage = $this->jssdk->GetSignPackage();
        $this->view->setVar("signPackage", $signPackage);
        $this->view->setVar("result", $res);
    }
    
    //提交验证资料
    public function sn_verifyAction(){
        
        $id = $this->session->get('sn_id');
        $res_sql = "SELECT * FROM qx_hongbao_record WHERE id='".$id."'";
        $res = $this->group->fetchOne($res_sql);
        if($res['state'] == 2){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "工作人员正在拼命验证中...<br/>请稍后留意公众号消息!";
            die(json_encode($ajax_result));
        }
        if($res['state'] == 3){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "该券已验证！";
            die(json_encode($ajax_result));
        }
        if (!empty($_FILES["file"]["name"])) {
            $path="uploads/qx_hongbao/";
            if(!file_exists($path)){
                mkdir("$path", 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $tp = array("image/gif", "image/pjpeg", "image/jpeg", "image/png");//允许上传的文件格式
            if(!in_array($_FILES["file"]["type"], $tp)){
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "格式不对，图片仅支持gif、jpg、png格式";
                die(json_encode($ajax_result));
            }
            if($_FILES['file']['size'] > 10485760){
                //不得超过10M
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "图片太大";
                die(json_encode($ajax_result));
            }
            $filetype = $_FILES['file']['type'];
            if ($filetype == 'image/jpg' || $filetype == 'image/pjpeg' || $filetype == 'image/jpeg') {
                $type = '.jpg';
            }
            if ($filetype == 'image/png') {
                $type = '.png';
            }
            if($filetype == 'image/gif'){
                $type = '.gif';
            }
            if($_FILES["file"]["name"]){
                $today = date("YmdHis"); //获取时间并赋值给变量
                $file2 = $path.$today.$type; //图片的完整路径
                $img = $today.$type; //图片名称
                $flag=1;
            }
            if($flag){
                $result = move_uploaded_file($_FILES["file"]["tmp_name"], $file2);
            }
        } else {
             $ajax_result['errcode'] = 1000;
             $ajax_result['errmsg'] = "上传图片失败";
             die(json_encode($ajax_result));
        }
        $sn = $_POST['q_id'];
        $brand = $_POST['q_brand'];
        $order_number = $_POST['q_order'];
        $order_money = $_POST['q_num'];
        if(empty($sn)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "券号错误";
            die(json_encode($ajax_result));
        }
        if(empty($order_number)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请输入订单号";
            die(json_encode($ajax_result));
        }
        if(empty($order_money)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请输入订单金额";
            die(json_encode($ajax_result));
        }
        if(empty($brand)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "请选择验证品牌";
            die(json_encode($ajax_result));
        }
        $sql = "UPDATE qx_hongbao_record SET brand='".$brand."',order_number='".$order_number."',order_money='".$order_money."',state=2,img_link='".$file2."',verify_time='".time()."' WHERE sn='".$sn."' AND id='".$id."'";
        $result = $this->group->execute($sql);
        if($result){
            $openid = $this->session->get('hb_openid');
            if(empty($openid)){
                $yz_sql = "SELECT openid FROM qx_hongbao_binding WHERE phone='".$res['phone']."'";
                $yz_res = $this->group->fetchOne($yz_sql);
                $openid = $yz_res['openid'];
            }
            $this->yz_send($openid, $res['total']);
            
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "提交成功";
            die(json_encode($ajax_result));
        } else {
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            die(json_encode($ajax_result));
        }
    }
    
    //红包抽取
    function hongbao_array(){
        
        $prize_info = array(
            1 => array('total' => 30, 'num' =>10, 'gl' => 20),
            2 => array('total' => 50, 'num' =>10, 'gl' => 25),
            3 => array('total' => 20, 'num' =>10, 'gl' => 10),
            4 => array('total' => 40, 'num' =>10, 'gl' => 30),
            5 => array('total' => 60, 'num' =>10, 'gl' => 5),
            6 => array('total' => 80, 'num' =>10, 'gl' => 5),
            7 => array('total' => 100, 'num' =>10, 'gl' => 5),
        );
        $start = 0;
        $type = rand(1, 100);
        foreach ($prize_info as $k => $key){
        
            $prize[$k]['start'] = $start + 1;
            $prize[$k]['end'] = $start + $key['gl'];
        
            $start = $prize[$k]['end'];
        
            if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){
                
                $content['prize_id'] = $k;
                $content['total'] = $key['total'];
//                 $sql = "SELECT COUNT(*) from qx_hongbao_record WHERE prize_id='".$k."'";
//                 $data = $this->group->fetchOne($sql);
//                 $num = $data[0];
//                 if($num >= $key['num']){
//                     $content['prize_id'] = 0;
//                     $content['total'] = 10;
//                 } else {
//                     $content['prize_id'] = $k;
//                     $content['total'] = rand($key['min'], $key['max']);
//                 }
            }
        }
        return $content;
    }
    
    //品牌限额
    public function brand_listAction(){
        $brand = trim($_POST['name']);
        $arr = array(
            1 => array('name' => '索菲亚衣柜', 'total' => 1000),
            2 => array('name' => '东鹏', 'total' => 2000),
            3 => array('name' => '大自然', 'total' => 3000),
            4 => array('name' => '美的', 'total' => 4000),
            5 => array('name' => '马克菠萝', 'total' => 5000),
            6 => array('name' => '顾家家居', 'total' => 6000),
        );
        if(empty($brand)){
            return $arr;
        } else {
            foreach ($arr as $k => $key){
                if($key['name'] == $brand){
                    die (json_encode($arr[$k]));
                }
            }
        }
    }
    
    //发送模板消息给领取人
    public function send_lq($phone, $total){
        //微信是否绑定过手机号，若绑定过则发送模板消息
        $is_binding_sql = "SELECT openid,send_num FROM qx_hongbao_binding WHERE phone='".$phone."'";
        $is_binding_result = $this->group->fetchOne($is_binding_sql);
        if($is_binding_result['send_num'] < 5){
            if(!empty($is_binding_result['openid'])){
                $access_token = $this->weixinapi->get_access_token();
                $send_data =  '{
                               "touser":"'.$is_binding_result['openid'].'",
                               "template_id":"vIneig0KVaCJk7TQsGgoEPHIzb3szSXml71323ZwjLg",
                               "url":"'.$this->domain_url.'/phone/hongbao/list",
                               "topcolor":"#FF0000",
                               "data":{
                                       "first": {
                                           "value":"恭喜你获得七夕家装节返现红包！",
                                           "color":"#173177"
                                       },
                                       "keyword1":{
                                           "value":"七夕家装节返现红包（1个）",
                                           "color":"#173177"
                                       },
                                       "keyword2": {
                                           "value":"'.$total.'元",
                                           "color":"#173177"
                                       },
                                       "remark":{
                                           "value":"通知好友报名并分享红包链接，还可领取更多的抵购红包噢！",
                                           "color":"#173177"
                                       }
                               }
                            }';
               $template_send = $this->weixinapi->template_send($access_token, $send_data);
               $sql = "UPDATE qx_hongbao_binding SET send_num=send_num+1 WHERE openid='".$is_binding_result['openid']."'";
               $result = $this->group->execute($sql);
            }
        }
    }
    
    //发送模板消息给发起人
    public function send_fq($from_phone, $phone, $total){
        //判断发起者的微信是否绑定过手机号，若绑定过则发送模板消息
        $is_binding_sql = "SELECT openid,send_num FROM qx_hongbao_binding WHERE phone='".$from_phone."'";
        $is_binding_result = $this->group->fetchOne($is_binding_sql);
        if($is_binding_result['send_num'] < 5){
            if(!empty($is_binding_result['openid'])){
                $access_token = $this->weixinapi->get_access_token();
                $send_data =  '{
                                   "touser":"'.$is_binding_result['openid'].'",
                                   "template_id":"uRo7TiKLxA_MuMg9LmtiMa6aOqRKm3HpJ0q7-ZQBCq8",
                                   "url":"'.$this->domain_url.'/phone/hongbao/list",
                                   "topcolor":"#FF0000",
                                   "data":{
                                           "first": {
                                               "value":"'.$this->funs_model->hidtel($phone).'领走了您分享的七夕家装节红包",
                                               "color":"#173177"
                                           },
                                           "keyword1":{
                                               "value":"'.$total.'元",
                                               "color":"#173177"
                                           },
                                           "keyword2": {
                                               "value":"'.date('Y-m-d H:i', time()).'",
                                               "color":"#173177"
                                           },
                                           "remark":{
                                               "value":"通知好友报名并分享红包链接，还可领取更多的抵购红包噢！",
                                               "color":"#173177"
                                           }
                                   }
                                }';
                $template_send = $this->weixinapi->template_send($access_token, $send_data);
                $sql = "UPDATE qx_hongbao_binding SET send_num=send_num+1 WHERE openid='".$is_binding_result['openid']."'";
                $result = $this->group->execute($sql);
            }
        }
    }
    
    //红包领完啦，发送模板消息给发起人
    public function send_num($from_phone){
        //微信是否绑定过手机号，若绑定过则发送模板消息
        $is_binding_sql = "SELECT openid FROM qx_hongbao_binding WHERE phone='".$from_phone."'";
        $is_binding_result = $this->group->fetchOne($is_binding_sql);
        if(!empty($is_binding_result['openid'])){
            $access_token = $this->weixinapi->get_access_token();
            $send_data =  '{
                           "touser":"'.$is_binding_result['openid'].'",
                           "template_id":"B-zUWWEvfBjoCj7GvqVNp2029e0QEH_cVL_U4r5tqyw",
                           "url":"'.$this->domain_url.'/phone/hongbao/list",
                           "topcolor":"#FF0000",
                           "data":{
                                   "first": {
                                       "value":"返现红包变更通知",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"腾讯家居·优居网",
                                       "color":"#173177"
                                   },
                                   "keyword2": {
                                       "value":"您分享的七夕家装节返现红包已被小伙伴们领完了！",
                                       "color":"#173177"
                                   },
                                   "remark":{
                                       "value":"通知好友报名并分享红包链接，还可领取更多的抵购红包噢！",
                                       "color":"#173177"
                                   }
                           }
                        }';
            $template_send = $this->weixinapi->template_send($access_token, $send_data);
        }
    }
    
    //发送抵购券验证通知
    public function yz_send($openid, $total){
        //微信是否绑定过手机号，若绑定过则发送模板消息
        $total = empty($total) ? '' : '（'.$total.'元）';
        if(!empty($openid)){
            $access_token = $this->weixinapi->get_access_token();
            $send_data =  '{
                           "touser":"'.$openid.'",
                           "template_id":"4JlQS1PIqWaICmqDDyhOkrCC0H-jKUFSlU00XQeQUwA",
                           "url":"'.$this->domain_url.'/phone/hongbao/list",
                           "topcolor":"#FF0000",
                           "data":{
                                   "first": {
                                       "value":"您好，您的七夕家装节返现红包验证申请已成功提交，请耐心等待工作人员的验证。",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"七夕家装节返现红包'.$total.'",
                                       "color":"#173177"
                                   },
                                   "keyword2": {
                                       "value":"正在验证",
                                       "color":"#173177"
                                   },
                                   "keyword3": {
                                       "value":"'.date('Y-m-d H:i',time()).'",
                                       "color":"#173177"
                                   },
                                   "remark":{
                                       "value":"通知好友报名并分享红包链接，还可领取更多的抵购红包噢！",
                                       "color":"#173177"
                                   }
                           }
                        }';
            $template_send = $this->weixinapi->template_send($access_token, $send_data);
        }
    }
    
    //发送验证通知
    public function send($data){
        if(!empty($data['openid'])){
            $access_token = $this->weixinapi->get_access_token();
            $send_data =  '{
                           "touser":"'.$data['openid'].'",
                           "template_id":"'.$data['template_id'].'",
                           "url":"'.$this->domain_url.'/phone/hongbao/list",
                           "topcolor":"#FF0000",
                           "data":{
                                   "first": {
                                       "value":"'.$data['first'].'",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"'.$data['keyword1'].'",
                                       "color":"#173177"
                                   },
                                   "keyword2": {
                                       "value":"'.$data['keyword2'].'",
                                       "color":"#173177"
                                   },
                                   "keyword3": {
                                       "value":"'.$data['keyword3'].'",
                                       "color":"#173177"
                                   },
                                   "remark":{
                                       "value":"'.$data['content'].'",
                                       "color":"#173177"
                                   }
                           }
                        }';
            $template_send = $this->weixinapi->template_send($access_token, $send_data);
        }
    }
    //加密解密
    function encrypt($string,$operation,$key=''){
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return urldecode(substr($result,8));
            }else{
                return'';
            }
        }else{
            return urlencode(str_replace('=','',base64_encode($result)));
        }
    }
    //分享点击
    public function onclickAction(){
        $btn_id = $_POST['btn_id'];
        $phone = $this->session->get('qx_phone');
        $url_source = $this->session->get("url_source");
        $this->clickAction($btn_id, $phone, $url_source);
        die(1);
    }
    
    //页面布点
    public function clickAction($btn_id, $phone, $url_source){
        $sql = "INSERT INTO qx_hongbao_budian (btn_id, phone, url_source, add_time) VALUES('".$btn_id."','".$phone."','".$url_source."','".time()."')";
        $this->group->execute($sql);
    }
}

?>