<?php
namespace Library\Model;

use Library\Com\Funs;

class Ext extends Base{
	
    public function initialize(){
        parent::initialize();
    }
	
	public function regions($params = null){
		$info = $this->api("Ext.regions",$params);
		if($info['state'] != 1000) return false;
		return $info['data'];
	}
	
	public function wxMsg($openid,$data){
		$url = "http://tao.jia360.com/index.php?g=API&m=WeixinApi&a=access_token&token=zbesbc1444283765&appid=wxd43f7b5d8539e718&appsecret=a42b85c54c3e79b709023df894f42778";
		$res = Funs::curlGet($url);
		$acc = json_decode($res,true);
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$acc;
		$postData = array(
			'touser'=>$openid,
			'template_id'=>'U9dWVmVHtra72LeaNp6RfhGcxXVI9RLsRZiDiB6IeGU',
			'url' => $data['url'],
			'topcolor' => '#FF0000',
			'data' => array(
				'first' => array('value'=>$data['first'],'color'=>'#173177'),
				'keyword1' => array('value'=>$data['name'],'color'=>'#173177'),
				'keyword2' => array('value'=>$data['money'],'color'=>'#173177'),
				'keyword3' => array('value'=>$data['time'],'color'=>'#173177'),
				'remark' => array('value'=>$data['remark'],'color'=>'#173177'),
			),
		);
		Funs::curlPOST($url,json_encode($postData));
		
	}
}

?>