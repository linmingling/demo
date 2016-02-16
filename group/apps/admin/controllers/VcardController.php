<?php
namespace Apps\Admin\Controllers;

//v卡后台

class VcardController extends ControllerBase 
{

	public function initialize()
	{
		parent::initialize();
	}

	public function indexAction()
	{
		$params = $this->dispatcher->getParams();
		$user_id = $this->session->get("user_id");
		$E = new \Library\Model\Ext();
	
		$city = $E->regions();
		$data = $this->group->fetchAll("select * from yizhangou_regions ",\Phalcon\Db::FETCH_ASSOC);
		$this->view->setVars(array('data'=>$data,'city'=>$city['list']));
		
		$sum = $this->group->fetchColumn("select count(*) from vcard_user where action_id in (select id from yizhangou_list where name='全民家居购')");
		$this->view->setVar("sum", $sum);
		if(isset($params[0]) && $params[0] == 'delimg')
		{
			$this->group->execute("update vcard_info set ". $params[2] ."='' where action_id = ".(int)$params[1]);
			// 			die("update yiyuanqiang_list set ". $params[2] ."='' where id = ".(int)$params[1]);
			header("Location:/admin/vcard/manage/modify/".(int)$params[1]);
		}
	}
	
	public function actionAction()
	{
		$params = $this->dispatcher->getParams();
		$user_id = $this->session->get("user_id");
		
		if(isset($params[0]) && $params[0] == 'list'){
			$data = $this->group->fetchAll("select * from yizhangou_list where group_id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'list','data'=>$data,'groupId'=>$params[1]));
			$this->view->pick("vcard/action_list");
		}
	}
	
	public function manageAction()
	{
		header("Content-type: text/html; charset=utf-8");
		$params = $this->dispatcher->getParams();
		
		//活动和地区信息
		$sql = "select * from yizhangou_list where id =" . (int)$params[1];
		$actionInfo = $this->group->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		$this->view->setVars(array('actionname'=>$actionInfo['name']));
		$this->view->setVars(array('groupid'=>$actionInfo['group_id']));
		$regionInfo = $this->group->fetchOne("select * from yizhangou_regions where id={$actionInfo['group_id']}",\Phalcon\Db::FETCH_ASSOC);
		$E = new \Library\Model\Ext();
		$cityList = $E->regions();
		$city = $cityList['list'][$regionInfo['region']];
		
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$data = array(
					'active_name' => $post['active_name'],
					'head_url' => $post['head_url'],
					'adv1_url' => $post['adv1_url'],
					'adv2_url' => $post['adv2_url'],
			);
				
			foreach($_FILES as $k=>$v)
			{
				$urlName = str_replace('_img','_url',$k);
				if($data[$urlName] != '')
				{
					if($v['size'] > 0)
					{
						$imgType = substr($v["type"],6);
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						move_uploaded_file($v["tmp_name"],"vcard/upload/".$imgName);
						$data[$k] = $imgName;
					}
				}
				else
				{
					$data[$k] = '';
				}
			}
				
			if(isset($data['files'])) unset($data['files']);
			if($params[0] == 'add')
			{
				$data['add_time'] = date('Y-m-d H:i:s');
				$data['action_id'] = (int)$params[1];
				$data['city'] = $city;
				$data['region_id'] = $regionInfo['region'];
				$sql = "insert into vcard_info(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
			}
			elseif($params[0] == 'modify')
			{
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update vcard_info set ".$str." where action_id = ".(int)$params[1];
			}
			$this->group->execute($sql);
			
			header("Location:/admin/vcard/action/list/{$actionInfo['group_id']}");
				
		}
		
		if(isset($params[0]) && $params[0] == 'modify')
		{
			$info = $this->group->fetchOne("select * from vcard_info where action_id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			if($info)
			{
				$this->view->setVars(array('type'=>'modify','info'=>$info,'actionid'=>(int)$params[1]));
			}
			else 
			{
				$this->view->setVars(array('type'=>'add','actionid'=>(int)$params[1]));
			}
			$this->view->pick("vcard/manage");
		}
		
	}
	
	public function statcityAction()
	{
		$params = $this->dispatcher->getParams();
		$regionId = (int)$params[0];
		$db = $this->group;
		$data = $db->fetchAll("select id,group_id,name from yizhangou_list where group_id = $regionId",\Phalcon\Db::FETCH_ASSOC);
		foreach ($data as $k=>$v)
		{
			$data[$k]['register_count'] = $db->fetchColumn("select count(1) from yizhangou_baoming where action_id={$v['id']}");
			$data[$k]['vcard_count'] = $db->fetchColumn("select count(1) from vcard_user where action_id={$v['id']}");
			$data[$k]['vcard_active'] = $db->fetchColumn("select count(1) from vcard_user where status=1 and action_id={$v['id']}");
			$data[$k]['new_count'] = $db->fetchColumn("select count(1) from vcard_user where is_new=1 and action_id={$v['id']}");
			
		}
// 		var_dump($data);die;
		$this->view->setVars(array('type'=>'list','data'=>$data,'groupId'=>$regionId));
		$this->view->pick("vcard/stat_city");
	}
	
	public function userinfoAction()
	{
		$params = $this->dispatcher->getParams();
		$actionId = (int)$params[0];
		$regTag = isset($params[1])?(int)$params[1]:0;
		$this->view->setVar("actionid", $actionId);
		$this->view->setVar("regtag", $regTag);
		$db = $this->group;
		
		if($regTag == 1)
		{
			$sql = "SELECT COUNT(1) FROM vcard_user a left join yizhangou_baoming b on a.phone=b.phone where b.action_id=$actionId";
		}
		else 
		{
			$sql = "SELECT COUNT(1) FROM yizhangou_baoming where action_id=$actionId";
		}
		$count = $db->fetchColumn($sql);
// 		die($count);
		
		$page = new \Library\Com\Page($count, 10);
		
		if($regTag == 1)
		{
			$sql = "SELECT b.id,b.phone,b.user_name FROM vcard_user a left join yizhangou_baoming b on a.phone=b.phone where b.action_id=$actionId ORDER BY time DESC LIMIT ".$page->firstRow.','.$page->listRows;
		}
		else 
		{
			$sql = "SELECT id,phone,user_name FROM yizhangou_baoming where action_id=$actionId ORDER BY time DESC LIMIT ".$page->firstRow.','.$page->listRows;
		}
		$list = $this->group->fetchAll($sql);
// 		var_dump($list);die;
		foreach ($list as $k => $key)
		{
			$sql = "SELECT * FROM vcard_user WHERE action_id=$actionId AND phone={$key['phone']}";
			$row = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			$list[$k]['active_time'] = $row?$row['add_time']:'-';
			$list[$k]['is_new'] = $row?$row['is_new']:false;
			$list[$k]['status'] = $row?$row['status']:false;
			$list[$k]['is_active'] = $row?true:false;
			if($regTag == 1 && !$row)
			{
				unset($list[$k]);
			}
			
		}
// 		var_dump($list);die;
		$this->view->setVar('page', $page->show());
		$this->view->setVar("list", $list);
		$this->view->pick("vcard/user_info");
	}
	
	
	
}


?>