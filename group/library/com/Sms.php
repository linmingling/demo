<?php
/**
 * 短信接口类
 */
namespace Library\Com;

class Sms{
   
    /**
     * 提供商：http://web.1xinxi.cn
     * @param unknown $phone    要发送的手机号
     * @param unknown $content  发送内容
     * @return number           返回状态
     */
   public function sendSms($phone, $content, $stime = ''){
        header("Content-Type: text/html; charset=UTF-8");
        $flag = 0;
        $params=''; //要post的数据
        //以下信息自己填以下
        $argv = array(
            'name' => '3086533498@qq.com',//必填参数。用户账号
            'pwd' => '52F4A74F3EAD7BFF6EF5A84D0F96',//必填参数。（web平台：基本资料中的接口密码）
            'content' => $content,//必填参数。发送内容（1-500 个汉字）UTF-8编码
            'mobile' => $phone,//必填参数。手机号码。多个以英文逗号隔开
            'stime' => $stime, //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
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
        
    /**
     * 提供商：http://www.yunpian.com
     * 通用接口发短信
     * apikey 为云片分配的apikey
     * text 为短信内容
     * mobile 为接受短信的手机号
    */
    public function send_sms($mobile, $text){
        //营销账户，不能发送验证码;
		$apikey = '6bbfa312715246cf6ebee3354ca4992f';
        $url="http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode("$text");
        $post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }
    
    public function code_send($mobile, $text){
        //普通账户,只能发送验证码，不能发送营销信息
        $apikey = 'ac6c3ca5db4493f3105e6fc73847662c';
        $url="http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode("$text");
        $post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }
    
    /**
     * 模板接口发短信
     * apikey 为云片分配的apikey
     * tpl_id 为模板id
     * tpl_value 为模板值
     * mobile 为接受短信的手机号
     */
    public function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile){
        $url="http://yunpian.com/v1/sms/tpl_send.json";
        $encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
        $post_string="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }
    
    /**
     * url 为服务的url地址
     * query 为请求串
     */
    public function sock_post($url, $query){
        $data = "";
        $info=parse_url($url);
        $fp=fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head="POST ".$info['path']." HTTP/1.0\r\n";
        $head.="Host: ".$info['host']."\r\n";
        $head.="Referer: http://".$info['host'].$info['path']."\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: ".strlen(trim($query))."\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write=fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        return $data;
    }
    
}

