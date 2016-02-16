<?php
namespace Apps\Phone\Controllers;

class SendController extends ControllerBase {
	
	public function indexAction(){
	    $data = '客户你好，你的验证码为：34353，5分钟内有效，请完成注册。';
	    $post_data = array();
	    $post_data['account'] = iconv('GB2312', 'GB2312',"jiekou-clcs-01");
	    $post_data['pswd'] = iconv('GB2312', 'GB2312',"Tch111222");
	    $post_data['mobile'] ="18802031940";
	    $post_data['msg']=mb_convert_encoding("$data",'UTF-8', 'auto');
	    $url='http://222.73.117.158/msg/HttpBatchSendSM?';
	    $o="";
	    foreach ($post_data as $k=>$v)
	    {
	        $o.= "$k=".urlencode($v)."&";
	    }
	    $post_data=substr($o,0,-1);
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $result = curl_exec($ch);
	     
	}
	
	public function sendAction(){
	    header("Content-Type: text/html; charset=UTF-8");
	    $flag = 0;
	    $params=''; //要post的数据
	    //以下信息自己填以下
	    $argv = array(
	        'name' => '3086533498@qq.com',//必填参数。用户账号
	        'pwd' => '52F4A74F3EAD7BFF6EF5A84D0F96',//必填参数。（web平台：基本资料中的接口密码）
	        'content' => "【腾讯家居·优居网】您的短信验证码为：1234",//必填参数。发送内容（1-500 个汉字）UTF-8编码
	        'mobile' => 13751750640,//必填参数。手机号码。多个以英文逗号隔开
	        'stime' => '',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
	        'sign' => '',    //必填参数。用户签名。
	        'type' => 'pt',  //必填参数。固定值 pt
	        'extno' => ''    //可选参数，扩展码，用户定义扩展码，只能为数字
	    );
	    //print_r($argv);exit;
	    //构造要post的字符串
	    //echo $argv['content'];
	    foreach ($argv as $key => $value) {
	        if ($flag!=0) {
	            $params .= "&";
	            $flag = 1;
	        }
	        $params.= $key."="; $params.= urlencode($value);// urlencode($value);
	        $flag = 1;
	    }
	    $url = "http://api.1xinxi.cn:1860/asmx/smsservice.aspx?".$params; //提交的url地址
	    $con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
	    if($con == '0'){
	        return 0;//发送成功
	    } else {
	        return 1;//发送失败
	    }
	}
}

?>