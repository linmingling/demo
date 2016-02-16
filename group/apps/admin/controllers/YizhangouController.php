<?php
namespace Apps\Admin\Controllers;

//一站购后台

class YizhangouController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}
	
	private function canAccess($actionId){
		if(!$actionId) return false;
		$data = $this->group->fetchOne("select * from yizhangou_regions where id = ".(int)$actionId,\Phalcon\Db::FETCH_ASSOC);
		if(empty($data)) return false;
		
		return true;
	}
	
	public function indexAction(){
		$params = $this->dispatcher->getParams();
        $user_id = $this->session->get("user_id");
		$E = new \Library\Model\Ext();
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			$data = array('hide'=>($post['hide'] ? '1' : '0'),'endtime'=>'NULL');
			if($post['endtime']) $data['endtime'] = $post['endtime'];
			if($_FILES['headimg']['size'] > 0){
				$imgType = substr($_FILES['headimg']["type"],6);
				$imgName = date('YmdHis').rand(100,999).".".$imgType;
				if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
				move_uploaded_file($_FILES['headimg']["tmp_name"],"uploads/yizhangou/".$imgName);
				$data['headimg'] = $imgName;
			}
			
			if($params[0] == 'add'){
				$city = $this->group->fetchColumn("select region from yizhangou_regions where region = '".$post['city']."'");
				if(!$city){
					$data['region'] = $post['city'];
					$data['addtime'] = date('Y-m-d H:i:s');
					$sql = "insert into yizhangou_regions(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
					$sql = str_replace("'NULL'","NULL",$sql);
				}else{
					exit("您添加的该城市已经存在了");
				}
			}elseif($params[0] == 'modify'){
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update yizhangou_regions set ".$str." where id = ".(int)$params[1];
				$sql = str_replace("'NULL'","NULL",$sql);
			}
			$this->group->execute($sql);
			header("Location:/admin/yizhangou/index");
		}		
		
		if(isset($params[0]) && $params[0] == 'add'){
			$province = $E->regions(array('pid'=>1));
			$this->view->setVars(array('type'=>'add','province'=>$province['list']));
			$this->view->pick("yizhangou/region");
		}elseif(isset($params[0]) && $params[0] == 'modify'){
			$city = $E->regions();
			$info = $this->group->fetchOne("select * from yizhangou_regions where id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'modify','info'=>$info,'city'=>$city['list']));
			$this->view->pick("yizhangou/region");
		}elseif(isset($params[0]) && $params[0] == 'delete'){
			$this->group->execute("delete from yizhangou_regions where id = ".(int)$params[1]);
			header("Location:/admin/yizhangou/index");
		}
		
		$city = $E->regions();
		$data = $this->group->fetchAll("select * from yizhangou_regions ",\Phalcon\Db::FETCH_ASSOC);
		$this->view->setVars(array('data'=>$data,'city'=>$city['list']));
	}
	
	public function actionAction(){
		$params = $this->dispatcher->getParams();
        $user_id = $this->session->get("user_id");
		
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			$data = array(
				'group_id'=>(int)$params[1],'name'=>$post['name'],'tag'=>$post['tag'],'zhe'=>$post['zhe'],'zeng'=>$post['zeng'],'zhuan'=>$post['zhuan'],'hide'=>($post['hide'] ? '1' : '0'),
				'starttime'=>$post['starttime'],'endtime'=>$post['endtime'],'buy'=>$post['buy'],'listtitle'=>$post['listtitle'],'sort'=>$post['sort'],
				'logofile'=>array(),'logo2file'=>array(),'logo3file'=>array(),'liangfiel'=>array(),'logdesc'=>$post['logdesc'],
			);
			foreach($_FILES as $k=>$v){
				if(is_array($v['size'])){
					foreach($v['size'] as $m=>$n){
						if($n > 0){
							$imgType = substr($v["type"][$m],6);
							if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
							$imgName = date('YmdHis').rand(100,999).".".$imgType;
							move_uploaded_file($v["tmp_name"][$m],"uploads/yizhangou/".$imgName);
							$data[$k][] = array(
								'name'=>$imgName,
								'item'=>$post[$k."-item"][$m] ? base64_encode($post[$k."-item"][$m]) : '',
								'url'=>$post[$k."-url"][$m] ? $post[$k."-url"][$m] : '',
								'sort'=>$post[$k."-sort"][$m] ? $post[$k."-sort"][$m] : '',
							);
						}
					}
				}elseif($v['size'] > 0){
					$imgType = substr($v["type"],6);
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) exit('只能上传 jpeg png gif 格式图片');
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					move_uploaded_file($v["tmp_name"],"uploads/yizhangou/".$imgName);
					$data[$k] = $imgName;
				}
			}
			
 			foreach($post['latitude'] as $m=>$n){
				$address[] = array('name'=>base64_encode($post['shopname'][$m]),'address'=>base64_encode($post['address'][$m]),'latitude'=>$n);
			}
			$data['address'] = json_encode($address);
			
			$item[] = array('name'=>base64_encode('品牌表'),'sort'=>$post['logo_sort']);
			$item[] = array('name'=>base64_encode('品牌表2'),'sort'=>$post['logo_sort2']);
			$item[] = array('name'=>base64_encode('品牌表3'),'sort'=>$post['logo_sort3']);
			$item[] = array('name'=>base64_encode('地图'),'sort'=>$post['map_sort']);
 			foreach($post['sub_name'] as $m=>$n){
				$item[] = array('name'=>base64_encode($n),'sort'=>$post['sub_sort'][$m]);
			}
			$data['item'] = json_encode($item);
			
			if($params[0] == 'add'){
				$data['createtime'] = date('Y-m-d H:i:s');
				$data['successimg'] = empty($data['successimg']) ? "" : json_encode($data['successimg']);
				$data['dikouimg'] = empty($data['dikouimg']) ? "" : json_encode($data['dikouimg']);
				$data['subjectimg'] = empty($data['subjectimg']) ? "" : json_encode($data['subjectimg']);
				$data['bottomimg'] = empty($data['bottomimg']) ? "" : json_encode($data['bottomimg']);
				$data['logofile'] = empty($data['logofile']) ? "" : json_encode($data['logofile']);
				$data['logo2file'] = empty($data['logo2file']) ? "" : json_encode($data['logo2file']);
				$data['logo3file'] = empty($data['logo3file']) ? "" : json_encode($data['logo3file']);
				$data['liangfiel'] = empty($data['liangfiel']) ? "" : json_encode($data['liangfiel']);
				
				$sql = "insert into yizhangou_list(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
			}elseif($params[0] == 'modify'){
				foreach($post['logofile2'] as $m=>$n){
					$tmp = json_decode($n,true);
					$tmp['url'] = $post['logofile2-url'][$m]; $tmp['item'] = base64_encode($post['logofile2-item'][$m]); $tmp['sort'] = $post['logofile2-sort'][$m];
					$data['logofile'][] = $tmp;
				}
				foreach($post['logo2file2'] as $m=>$n){
					$tmp = json_decode($n,true);
					$tmp['url'] = $post['logo2file2-url'][$m]; $tmp['item'] = base64_encode($post['logo2file2-item'][$m]); $tmp['sort'] = $post['logo2file2-sort'][$m];
					$data['logo2file'][] = $tmp;
				}
				foreach($post['logo3file2'] as $m=>$n){
					$tmp = json_decode($n,true);
					$tmp['url'] = $post['logo3file2-url'][$m]; $tmp['item'] = base64_encode($post['logo3file2-item'][$m]); $tmp['sort'] = $post['logo3file2-sort'][$m];
					$data['logo3file'][] = $tmp;
				}
				foreach($post['liangfiel2'] as $m=>$n){
					$tmp = json_decode($n,true);
					$tmp['url'] = $post['liangfiel2-url'][$m]; $tmp['item'] = base64_encode($post['liangfiel2-item'][$m]); $tmp['sort'] = $post['liangfiel2-sort'][$m];
					$data['liangfiel'][] = $tmp;
				}
				if(isset($data['subjectimg'])) $data['subjectimg'] = json_encode($data['subjectimg']);
				if(isset($data['dikouimg'])) $data['dikouimg'] = json_encode($data['dikouimg']);
				if(isset($data['bottomimg'])) $data['bottomimg'] = json_encode($data['bottomimg']);
				if(isset($data['successimg'])) $data['successimg'] = json_encode($data['successimg']);
				if(isset($data['logofile'])) $data['logofile'] = json_encode($data['logofile']);
				if(isset($data['logo2file'])) $data['logo2file'] = json_encode($data['logo2file']);
				if(isset($data['logo3file'])) $data['logo3file'] = json_encode($data['logo3file']);
				if(isset($data['liangfiel'])) $data['liangfiel'] = json_encode($data['liangfiel']);
				$str = "";
				foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = '".$v."'";
				$sql = "update yizhangou_list set ".$str." where id = ".(int)$params[2];
			}
			$this->group->execute($sql);
			header("Location:/admin/yizhangou/action/list/".$params[1]);
		}
		
		if(isset($params[0]) && $params[0] == 'add'){
			$this->view->tag = $this->group->fetchAll("select id,tag from yizhangou_tag where group_id = '".$params[1]."'",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'add','groupId'=>$params[1]));
			$this->view->pick("yizhangou/action");
		}elseif(isset($params[0]) && $params[0] == 'modify'){
			$info = $this->group->fetchOne("select * from yizhangou_list where id = ".(int)$params[2],\Phalcon\Db::FETCH_ASSOC);
			$info['successimg'] = json_decode($info['successimg'],true);
			$info['dikouimg'] = json_decode($info['dikouimg'],true);
			$info['subjectimg'] = json_decode($info['subjectimg'],true);
			$info['bottomimg'] = json_decode($info['bottomimg'],true);
			$info['logofile'] = json_decode($info['logofile'],true);
			$info['logo2file'] = json_decode($info['logo2file'],true);
			$info['logo3file'] = json_decode($info['logo3file'],true);
			$info['liangfiel'] = json_decode($info['liangfiel'],true);
			$info['address'] = json_decode($info['address'],true);
			$info['item'] = json_decode($info['item'],true);
			foreach($info['item'] as $m=>$n){
				if(base64_decode($n['name']) == '品牌表'){
					$this->view->logo_sort = $n['sort']; unset($info['item'][$m]);
				}
				if(base64_decode($n['name']) == '品牌表2'){
					$this->view->logo_sort2 = $n['sort']; unset($info['item'][$m]);
				}
				if(base64_decode($n['name']) == '品牌表3'){
					$this->view->logo_sort3 = $n['sort']; unset($info['item'][$m]);
				}
				if(base64_decode($n['name']) == '地图'){
					$this->view->map_sort = $n['sort']; unset($info['item'][$m]);
				}
			}
			$this->view->tag = $this->group->fetchAll("select id,tag from yizhangou_tag where group_id = '".$params[1]."'",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'modify','info'=>$info,'groupId'=>$params[1]));
			$this->view->pick("yizhangou/action");
		}elseif(isset($params[0]) && $params[0] == 'delete'){
			$this->group->execute("delete from yizhangou_list where id = ".(int)$params[2]);
			header("Location:/admin/yizhangou/action/list/".$params[1]);
		}elseif(isset($params[0]) && $params[0] == 'list'){
			$data = $this->group->fetchAll("select * from yizhangou_list where group_id = ".(int)$params[1],\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('type'=>'list','data'=>$data,'groupId'=>$params[1]));
			$this->view->pick("yizhangou/action_list");
		}
	}
	
	public function tagAction(){
 		$params = $this->dispatcher->getParams();
		$db = $this->group;
		
		if($params[0] == 'add'){
			header('Content-type:application/json;charset=utf-8;');
			$id = $db->fetchColumn("select id from yizhangou_tag where group_id = '".$params[1]."' and tag = '".$_POST['tag']."'");
			if($id) die(json_encode(array('state'=>0,'msg'=>'该标签已经存在')));
			$sql = "insert into yizhangou_tag(`group_id`,`tag`) values('".$params[1]."','".$_POST['tag']."')";
			$res = $db->execute($sql);
			if($res){
				die(json_encode(array('state'=>1,'msg'=>$db->lastInsertId())));
			}
			die(json_encode(array('state'=>0,'msg'=>'添加失败')));
		}elseif($params[0] == 'delete'){
			header('Content-type:application/json;charset=utf-8;');
			$sql = "delete from yizhangou_tag where id = ".$_POST['tagId'];
			$res = $db->execute($sql);
			if($res){
				die(json_encode(array('state'=>1,'msg'=>'删除成功')));
			}
			die(json_encode(array('state'=>0,'msg'=>'删除失败')));
		}elseif($params[0] == 'list'){
			header('Content-type:application/json;charset=utf-8;');
			$data = $db->fetchAll("select id,tag from yizhangou_tag where group_id = ".$params[1],\Phalcon\Db::FETCH_ASSOC);
			die(json_encode(array('num'=>count($data),'list'=>$data)));
		}elseif($params[0] == 'show'){
			$this->view->setVars(array('groupId'=>$params[1]));
		}
	}
	
	
	public function baomingAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$ajax = $this->dispatcher->getParam(1,'int');
		if($ajax){
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
			
			$where = "";
 			if(isset($_GET['phone']) && $_GET['phone']){
				$where .= " and phone = '".$_GET['phone']."'";
			}
			if(isset($_GET['userId']) && $_GET['userId']){
				$where .= " and user_id = '".$_GET['userId']."'";
			}
			if(isset($_GET['userName']) && $_GET['userName']){
				$where .= " and user_name = '".$_GET['userName']."'";
			}
			
			$total = $this->group->fetchColumn("select count(id) from yizhangou_baoming where action_id = $actionId and fanye = '0' and vcard = '0'".$where);
			$sql = "select * from yizhangou_baoming where action_id = $actionId and fanye = '0' and vcard = '0' ".$where." order by time desc limit $offset,$limit";
			$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			
			if(empty($res)) die(json_encode(array('total'=>0,'rows'=>array())));
			
			foreach($res as $k){
				$data[] = $k;
			}
			
			die(json_encode(array('total'=>$total,'rows'=>$data)));
		}
		$groupId = $this->group->fetchColumn("select group_id from yizhangou_list where id = ".$actionId);
		
		$this->view->setVars(array('actionId'=>$actionId,'groupId'=>$groupId));
	}

	public function clickAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		$ajax = $this->dispatcher->getParam(1,'int');
		if($ajax){
			$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
			$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;

			$where = "";
			if(isset($_GET['phone']) && $_GET['phone']){
				$where .= " and phone = '".$_GET['phone']."'";
			}
			if(isset($_GET['tn']) && $_GET['tn']){
				$where .= " and tn = '".$_GET['tn']."'";
			}

			$total = $this->group->fetchColumn("select count(id) from yizhangou_click where action_id = $actionId ".$where);
			$sql = "select * from yizhangou_click where action_id = $actionId ".$where." limit $offset,$limit";
			$res = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);

			if(empty($res)) die(json_encode(array('total'=>0,'rows'=>array())));

			foreach($res as $k){
				$data[] = $k;
			}

			die(json_encode(array('total'=>$total,'rows'=>$data)));
		}
		$groupId = $this->group->fetchColumn("select group_id from yizhangou_list where id = ".$actionId);

		$this->view->setVars(array('actionId'=>$actionId,'groupId'=>$groupId));
	}
	
	public function percentAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		
		$tmp = $this->group->fetchAll("select * from yizhangou_click where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			if(!isset($data[$k['tn']])){
				$data[$k['tn']] = 1;
			}else{
				$data[$k['tn']] = $data[$k['tn']] + 1;
			}
		}
		asort($data);
		$this->view->setVars(array('count'=>array_sum($data),'data'=>$data));
	}
	
	public function exportAction(){
		$actionId = $this->dispatcher->getParam(0,'int');
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=baoming_".$actionId.".csv");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		
		$E = new \Library\Model\Ext();
		$regions = $E->regions();
		
		$title = "用户id,用户名,手机号,是否验证,来源,领票,领卷,翻页,v卡,ip,报名时间,市,区,地址\r\n";
		echo mb_convert_encoding($title,"GBK","UTF-8");
			
		$tmp = $this->group->fetchAll("select * from yizhangou_baoming where action_id = $actionId",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$yz = $k['auth'] == 1 ? '是' : '否';
			$ispiao = $k['ispiao'] ? '是' : '否';
			$isquan = $k['isquan'] ? '是' : '否';
			$vcard = $k['vcard'] ? '是' : '否';
			$fanye = $k['fanye'] ? '是' : '否';
			$str = $k['user_id'].",".$k['user_name'].",".$k['phone'].",".$yz.",".$k['from'].",".$ispiao.",".$isquan.",".$fanye.",".$vcard.",".$k['ip'].",".$k['time'].",".$regions['list'][$k['city']].",".$regions['list'][$k['district']].",".$k['address']."\r\n";
			echo mb_convert_encoding($str,"GBK","UTF-8");
		}
		
		exit();
	}
}

