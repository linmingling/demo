<?php
namespace Apps\Phone\Controllers;

use Library\Com\Funs;

class ControllerBase extends \Phalcon\Mvc\Controller {
	
	protected function onConstruct(){
		
	}
	
	protected function sso_author_login($info, $only_sso = false){
		$time = time();
		$token = md5('yt123$%^'.$time);
		$head_pic = !empty($info['head_pic']) ? $info['head_pic'] : '';
		
		$param = array(
				"token" => $token,
				"time"  => $time,
				"oauth_type" => $info['oauth_type'],
				"oauth_openid" =>  $info['oauth_openid'],
				"oauth_unionid"=>  $info['oauth_unionid'],
				"nick_name" => $info['nick_name'],
				"email" => '',
				"mobile" => '',
				"head_pic" => $head_pic,
				"sex" => $info['sex']
		);
		$response  = Funs::curlPost($this->config->zxHome .'/index.php?m=Sso&c=Index&a=oauth_login', $param);
		$results = json_decode($response, true);

		if ($only_sso) return;
		if ($results['code'] === 0) {
			$open_id = $results['msg'];
			$sql_x = "SELECT user_id,user_name,email FROM ecs_users WHERE open_id='$open_id' LIMIT 1";
			$row = $this->upin->fetchOne($sql_x,\Phalcon\Db::FETCH_ASSOC);
			if (!$row) {
				$sql = "INSERT INTO ecs_users(user_name, head_pic, reg_time, open_id) VALUES('".$info['nick_name']."','".$head_pic."','".date('Y-m-d H:i:s')."','".$open_id."')";
				$this->upin->execute($sql);
				$row = $this->upin->fetchOne($sql_x,\Phalcon\Db::FETCH_ASSOC);
			}
			if(!$row['user_name'] && $info['nick_name']){
				//用户昵称为空时，更新用户昵称
				$sql = "UPDATE ecs_users SET user_name = '".$info['nick_name']."' WHERE user_id = ".$row['user_id'];
				$this->upin->execute($sql);
			}
			
			$this->session->set('user_id',$row['user_id']);
			$this->session->set('user_name',$row['user_name']);
			$this->session->set('email',$row['email']);
			
			$this->session->set('wx_openid',$info['oauth_openid']);
			$this->session->set('wechaname',$info['nick_name']);
			$this->session->set('headimgurl',$head_pic);
			$this->session->set('sex',$info['sex']);
			$this->session->set('unionid',$info['oauth_unionid']);
			
			return $open_id;
		}
		return false;
	}
	
	public function wxlogin($ignoreUserCreation=false){
		$user_id = $this->session->has('user_id') ? $this->session->get('user_id') : 0;
		$user_phone = $this->session->has('user_phone') ? $this->session->get('user_phone') : 0;
		
		if(strpos($_SERVER['HTTP_USER_AGENT'],"MicroMessenger")){
			if((!$user_id || !$user_phone) && (!isset($_GET['auth']) || $_GET['auth']!=1)){
				if ($_GET['ignored']==1)
					return;
				
				$REQUEST_URI = str_replace("&auth=1","",$_SERVER['REQUEST_URI']);
				$REQUEST_URI = str_replace("?auth=1","?",$REQUEST_URI);
				$url = 'http://'.$_SERVER['HTTP_HOST'].$REQUEST_URI;
				if(!strpos($url,'rand=')){
					$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
				}
				if ($ignoreUserCreation) {
					$redirect_url = $this->config->pcHome .'/api/weixin_oauth.php?scope=wx_login&url='.urlencode($url).'&cookie_name=group_auth&ignore_user_creation=1';
				} else {
					$redirect_url = $this->config->pcHome .'/api/weixin_oauth.php?scope=wx_login&url='.urlencode($url).'&cookie_name=group_auth';
				}
				
				//header("Location:".$redirect_url); //微信不支持header跳转
				echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
			}
		}
	}
	
	public function wxSubscribe($openId,$type = 1){
		if($type == 1 && $openId){
			$sql = "select follow_form_id as openid,unionid,follow_time,last_time from lanrain_follow where follow_form_id = '".$openId."' and follow_to_id = 'gh_32ec728d275c'";
			$data = $this->lanrain->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			return $data;
		}elseif($type == 2 && $openId){
			$sql = "select follow_form_id as openid,unionid,follow_time,last_time from lanrain_follow where unionid = '".$openId."' and follow_to_id = 'gh_32ec728d275c'";
			$data = $this->lanrain->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			return $data;
		}else{
			return false;
		}
	}
	
}
