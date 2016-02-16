<?php
namespace Apps\Admin\Controllers;

use Library\Com\SecurityContext;

class ZhanController extends ControllerBase {
	
    private $funs_model;
	public function initialize(){
		parent::initialize();
		$this->funs_model = new \Library\Com\Funs();
	}
	
	/**
	 * 返回省份
	 */
	private function CityBox(){
		$data = array();
		$tmp = $this->group->fetchAll("select * from region",\Phalcon\Db::FETCH_ASSOC);
		foreach($tmp as $k){
			$data[$k['region_id']] = $k;
		}
		return $data;
	}
	
	public function indexAction(){
		header("Location:/admin/zhan/action/list");
	}
	
	/**
	 * 根据用户权限过滤SQL的语句
	 * 返回查询region城市的条件SQL语句：region表别名必须为r.
	 */
	private function getCityPrivilegeSqlClause() {
		$citiesPriv = SecurityContext::getExtUserAttributes()['admin_cities']; //获取当前用户管理的城市
		if ($citiesPriv) {
			$sql = " (";
			for ($i = 0; $i< count($citiesPriv); $i++) {
				$city = $citiesPriv[$i];
				if($city == "*") return "1=1";
				$sql .= "r.region_pinyin = '" . $city . "'";
				if ($i!=count($citiesPriv)-1)
					$sql .=  " or ";
			}
			$sql .= ") ";
			return $sql;
		} else { // 无任何权限，返回永不成立的查询条件，不能查询出结果
			return " 1=2 ";
		}
	}
	
	/**
	 * 根据用户权限过滤SQL的语句
	 * 返回查询zhan_list活动的条件SQL语句：zhan_list表别名必须为z.
	 */
	private function getActionsPrivilegeSqlClause() {
		$actionsPriv = SecurityContext::getExtUserAttributes()['admin_actions']; //获取当前用户管理的活动
		if ($actionsPriv) {
			$sql = " (";
			for ($i = 0; $i< count($actionsPriv); $i++) {
				$zhanId = $actionsPriv[$i];
				if($zhanId == "*") return "1=1";
				$sql .= "z.zhan_id = '" . $zhanId . "'";
				if ($i!=count($actionsPriv)-1)
					$sql .=  " or ";
			}
			$sql .= ") ";
			return $sql;
		} else { // 无任何权限，返回永不成立的查询条件，不能查询出结果
			return " 1=2 ";
		}
	}
	
	/**
	 * 活动管理
	 */
	public function actionAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$user_id = $this->session->get("user_id");
		$funs = new \Library\Com\Funs();
		
		$db = $this->group;
		$data = array();
		
		if($type == 'list'){
			// 城市权限控制
			if (SecurityContext::getCurrentUsername() != 'admin') {
				$sql = "select distinct z.* from zhan_list z, zhan_city c, region r where z.zhan_id = c.zhan_id and c.city_id = r.region_id and " . $this->getCityPrivilegeSqlClause() . " and " . $this->getActionsPrivilegeSqlClause();
				$data = $this->group->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			} else {
				$data = $this->group->fetchAll("select * from zhan_list",\Phalcon\Db::FETCH_ASSOC);
			}
			
			foreach ($data as $k=>$v)
			{
				$sql = "select count(1) from zhan_register where zhan_id = {$v['zhan_id']}";
				$data[$k]['sum_register'] = $this->group->fetchColumn($sql);
			
				$sql = "select count(1) from zhan_register where zhan_id = {$v['zhan_id']} and auth='1'";
				$data[$k]['auth_register'] = $this->group->fetchColumn($sql);
			}

// 			var_dump($data);die;
			$this->view->setVars(array('data'=>$data));
			$this->view->pick("zhan/actionlist");
		}elseif($type == 'add'){
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if($post['zhan_name']){
					$zhanId = $db->fetchColumn("select zhan_id from zhan_list where zhan_name = '".$post['zhan_name']."'");
					if($zhanId) $this->alertMsg("该活动名已经存在,请换个名称",true);
					
					$data['show'] = isset($post['show']) ? 1 : 0;
					$data['zhan_name'] = $post['zhan_name'];
					$data['creater'] = SecurityContext::getCurrentUsername();
					$data['starttime'] = $post['starttime'] ? $post['starttime'] : 'NULL';
					$data['endtime'] = $post['endtime'] ? $post['endtime'] : 'NULL';
					$data['addtime'] = date('Y-m-d H:i:s');
					$data['act_type'] = $post['act_type'];
					$data['sort'] = $post['sort'];
					$sql = "insert into zhan_list(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')";
					$db->execute(str_replace("'NULL'","NULL",$sql));
					
					//crm添加项目名
					$url = $this->config->crm_host .'/pc/api/group/'.md5(md5('yoju360_crm').'add'.date('Y-m-d')).'/add';
					$data = '{"groupName": "'.$post['zhan_name'].'"}';
					$res = $funs->curlPOST($url, $data);
					
					header("Location:/admin/zhan/action/list");
				}
			}
			$this->view->pick("zhan/actionadd");
		}elseif($type == 'modify'){
			$zhanId = $this->dispatcher->getParam(1,'int');
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if($post['zhan_name']){
					$oldName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = $zhanId");
					$resId = $db->fetchColumn("select zhan_id from zhan_list where zhan_id != $zhanId and zhan_name = '".$post['zhan_name']."'");
					if($resId) $this->alertMsg("该活动名已经存在,请换个名称",true);
					
					$data['show'] = isset($post['show']) ? 1 : 0;
					$data['zhan_name'] = $post['zhan_name'];
					$data['starttime'] = $post['starttime'] ? $post['starttime'] : 'NULL';
					$data['endtime'] = $post['endtime'] ? $post['endtime'] : 'NULL';
					$data['act_type'] = $post['act_type'];
					$data['sort'] = $post['sort'];
					
					if(isset($_FILES['logo1']) && $_FILES['logo1']['size'] > 0){  //默认logo
						$imgType = substr($_FILES['logo1']["type"],6);
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
						move_uploaded_file($_FILES['logo1']["tmp_name"],"uploads/zhan/".$imgName);
						$data['logo1'] = $imgName;
					}
					
					if(isset($_FILES['logo2']) && $_FILES['logo2']['size'] > 0){  //替换logo
						$imgType = substr($_FILES['logo2']["type"],6);
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
						move_uploaded_file($_FILES['logo2']["tmp_name"],"uploads/zhan/".$imgName);
						$data['logo2'] = $imgName;
					}
					
					$str = ""; foreach($data as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = ".($v == 'NULL' ? "NULL" : "'".$v."'");
					$db->execute("update zhan_list set $str where zhan_id = $zhanId");
					
					$url = $this->config->crm_host .'/pc/api/group/'.md5(md5('yoju360_crm').'modify'.date('Y-m-d')).'/modify';
					$data = '{"newGroupName": "'.$post['zhan_name'].'","oldGroupName":"'.$oldName.'"}';
					$res = $funs->curlPOST($url, $data);
					
					header("Location:/admin/zhan/action/list");
				}
			}
			$data = $db->fetchOne("select * from zhan_list where zhan_id = $zhanId",\Phalcon\Db::FETCH_ASSOC);
			$this->view->setVars(array('data'=>$data));
			$this->view->pick("zhan/actionmodify");
		}elseif($type == 'delete'){
			$zhanId = $this->dispatcher->getParam(1,"int");
			if($zhanId){
				$db->execute("delete from zhan_city where zhan_id = '".$zhanId."'");
				$db->execute("delete from zhan_item where zhan_id = '".$zhanId."'");
				$db->execute("delete from zhan_img where zhan_id = '".$zhanId."'");
				$db->execute("delete from zhan_list where zhan_id = '".$zhanId."'");
			}
			header("Location:/admin/zhan/action/list");
		}elseif($type == 'logodel'){
			$zhanId = $this->dispatcher->getParam(1,'int');
			$name = $this->dispatcher->getParam(2,'string');
			if($name == 'logo1'){
				$db->execute("update zhan_list set `logo1` = '' where zhan_id = $zhanId");
			}elseif($name == 'logo2'){
				$db->execute("update zhan_list set `logo2` = '' where zhan_id = $zhanId");
			}
			die(json_encode(array('code'=>1,'msg'=>'删除成功')));
		}
	}

	//城市分站管理
	public function cityAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$funs = new \Library\Com\Funs();
		$db = $this->group;
		
		if($type == 'list'){
			$zhanId = $this->dispatcher->getParam(1,"int");
			// 不是超级管理员，只能查看所管辖城市
			if (SecurityContext::getCurrentUsername() != 'admin')
				$data = $db->fetchAll("select r.region_pinyin, r.region_name, a.* from zhan_city as a join region as r on a.city_id = r.region_id where zhan_id = $zhanId and " . $this->getCityPrivilegeSqlClause(),\Phalcon\Db::FETCH_ASSOC);
			else 
				$data = $db->fetchAll("select r.region_pinyin, r.region_name, a.* from zhan_city as a join region as r on a.city_id = r.region_id where zhan_id = $zhanId",\Phalcon\Db::FETCH_ASSOC);
			
			$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = $zhanId");
			$actType = $db->fetchColumn("select act_type from zhan_list where zhan_id = $zhanId");
			
			$this->view->setVars(array('zhanId'=>$zhanId,'zhanName'=>$zhanName,'data'=>$data,'actType'=>$actType));
			$this->view->pick("zhan/citylist");
		}elseif($type == 'add'){
			$zhanId = $this->dispatcher->getParam(1,"int");
			$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = $zhanId");
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				$city_id = $post['city'];
				if($this->request->hasPost('province') && $post['province'] >= 2 && $post['province'] <= 5) $city_id = $post['province'];
				
				if($city_id){
					$checkZhanCity = $db->fetchColumn("select c_id from zhan_city where city_id = $city_id and zhan_id = $zhanId limit 1");
					if ($checkZhanCity) {
						$this->alertMsg("该城市已经添加过了",true); die();
					}
					$info['ph_show'] = isset($post['ph_show']) ? 1 : 0;
					$info['fy_show'] = isset($post['fy_show']) ? 1 : 0;
					$info['topadv_show'] = isset($post['topadv_show']) ? 1 : 0;
					$info['fy_goto'] = isset($post['fy_goto']) ? 1 : 0;
					$info['city_id'] = $city_id;
					$info['zhan_id'] = $zhanId;
					$info['starttime'] = $post['starttime'] ? $post['starttime'] : 'NULL';
					$info['endtime'] = $post['endtime'] ? $post['endtime'] : 'NULL';
					$info['addtime'] = date('Y-m-d H:i:s');
					$info['title'] = $post['title'];
					$info['zhe_txt'] = $post['zhe_txt'];
					$info['zeng_txt'] = $post['zeng_txt'];
					$info['zt_txt'] = $post['zt_txt'];
					$info['brand_txt'] = $post['brand_txt'];
					$info['coupons_txt'] = $post['coupons_txt'];
					$info['init_num'] = $post['init_num'];
					$sql = "insert into zhan_city(`".implode('`,`',array_keys($info))."`) values('".implode("','",$info)."')";
					$db->execute(str_replace("'NULL'","NULL",$sql));
					$cId = $db->lastInsertId();
					
					if(isset($_FILES['topadv']) && $_FILES['topadv']['size'] > 0){  //头部广告
						$imgType = substr($_FILES['topadv']["type"],6);
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
						move_uploaded_file($_FILES['topadv']["tmp_name"],"uploads/zhan/".$imgName);
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','".$imgName."','3','".$post['topadv_url']."')");
					}
					
					$cityName = $db->fetchColumn("select region_name from region where region_id = $city_id");
					$url = $this->config->crm_host .'/pc/api/city/'.md5(md5('yoju360_crm').'add'.date('Y-m-d')).'/add';
					$data = '{"groupName": "'.$zhanName.'","cityName":"'.$cityName.'"}';
					$res = $funs->curlPOST($url, $data);
					
					header("Location:/admin/zhan/city/list/$zhanId");
				}
				$this->alertMsg("您没有选择城市",true);
			}
			
			$actType = $db->fetchColumn("select act_type from zhan_list where zhan_id = $zhanId");
			// 不是超级管理员，只能添加所管辖城市活动
			if (SecurityContext::getCurrentUsername()!='admin')
				$cityBox = $db->fetchAll("select * from region r where " . $this->getCityPrivilegeSqlClause(),\Phalcon\Db::FETCH_ASSOC);
			else
				$cityBox = $this->CityBox();
			$this->view->setVars(array('zhanId'=>$zhanId,'zhanName'=>$zhanName,'cityBox'=>$cityBox,'actType'=>$actType));
			$this->view->pick("zhan/cityadd");
		}elseif($type == 'modify'){
			$cId = $this->dispatcher->getParam(1,"int");
			$data = $db->fetchOne("select c.*, r.region_name from zhan_city as c left join region as r on c.city_id = r.region_id where c_id = $cId",\Phalcon\Db::FETCH_ASSOC);
			$zhanId = $data['zhan_id'];
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if($cId){
					$info['ph_show'] = isset($post['ph_show']) ? 1 : 0;
					$info['fy_show'] = isset($post['fy_show']) ? 1 : 0;
					$info['topadv_show'] = isset($post['topadv_show']) ? 1 : 0;
					$info['fy_goto'] = isset($post['fy_goto']) ? 1 : 0;
					$info['starttime'] = $post['starttime'] ? $post['starttime'] : 'NULL';
					$info['endtime'] = $post['endtime'] ? $post['endtime'] : 'NULL';
					$info['title'] = $post['title'];
					$info['zhe_txt'] = $post['zhe_txt'];
					$info['zeng_txt'] = $post['zeng_txt'];
					$info['zt_txt'] = $post['zt_txt'];
					$info['brand_txt'] = $post['brand_txt'];
					$info['coupons_txt'] = $post['coupons_txt'];
					$info['init_num'] = $post['init_num'];
					$str = ""; foreach($info as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = ".($v == 'NULL' ? "NULL" : "'".$v."'");
					$db->execute("update zhan_city set $str where c_id = '".$cId."'");
					
					if(isset($_FILES['topadv']) && $_FILES['topadv']['size'] > 0){  //头部广告
						$imgId = $db->fetchColumn("select img_id from zhan_img where img_type = '3' and c_id = '".$cId."' limit 1");
						$imgType = substr($_FILES['topadv']["type"],6);
						$imgName = date('YmdHis').rand(100,999).".".$imgType;
						if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
						move_uploaded_file($_FILES['topadv']["tmp_name"],"uploads/zhan/".$imgName);
						if(!$imgId){
							$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','".$imgName."','3','".$post['topadv_url']."')");
						}else{
							$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['topadv_url']."' where img_id = '".$imgId."'");
						}
					}elseif($post['topadv_url']){
						$db->execute("update zhan_img set `img_url` = '".$post['topadv_url']."' where img_id = '".$imgId."'");
					}
					header("Location:/admin/zhan/city/list/".$data['zhan_id']);
				}
			}
			$tmp = $db->fetchOne("select img_name,ifnull(img_url,'') as img_url from zhan_img where img_type = '3' and c_id = '".$cId."' limit 1",\Phalcon\Db::FETCH_ASSOC);
			$data['topadv_url'] = $tmp['img_url'];
			$data['topadv_img'] = $tmp['img_name'];
			$data['wx_img'] = $db->fetchColumn("select img_name from zhan_img where img_type = '5' and c_id = '".$cId."' limit 1");
			$data['dikou_img'] = $db->fetchColumn("select img_name from zhan_img where img_type = '6' and c_id = '".$cId."' limit 1");
			$zhanName = $db->fetchColumn("select zhan_name from zhan_list where zhan_id = ".$data['zhan_id']);
			$actType = $db->fetchColumn("select act_type from zhan_list where zhan_id = ".$data['zhan_id']);
			
			$this->view->setVars(array('data'=>$data,'zhanName'=>$zhanName,'actType'=>$actType));
			$this->view->pick("zhan/citymodify");
		}elseif($type == 'delete'){
			$cId = $this->dispatcher->getParam(1,"int");
			if($cId){
				$zhanId = $db->fetchColumn("select zhan_id from zhan_city where c_id = '".$cId."'");
				$db->execute("delete from zhan_city where c_id = '".$cId."'");
				$db->execute("delete from zhan_item where c_id = '".$cId."'");
				$db->execute("delete from zhan_img where c_id = '".$cId."'");
				header("Location:/admin/zhan/city/list/".$zhanId);
			} else {
				header("Location:/admin/zhan/action/list");
			}
		}
	}
	
	//栏目管理
	public function itemAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$db = $this->group;
		
		if($type == 'add'){
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if((int)$post['dataType'] ==  1){
					$data['sys_default'] = (int)$post['itemName'];
					$data['item_name'] = '';
				}elseif((int)$post['dataType'] ==  2){
					$data['sys_default'] = 0;
					$data['item_name'] = $post['itemName'];
				}
				$data['c_id'] = $post['cId'];
				$data['zhan_id'] = $db->fetchColumn("select zhan_id from zhan_city where c_id = '".$post['cId']."'");
				$data['type'] = $post['itemType'];
				$data['row'] = $post['itemRow'];
				$data['column'] = $post['itemColumn'];
				$data['item_sort'] = $post['itemSort'];
				$db->execute("insert into zhan_item(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
				//$itemId = $db->lastInsertId();
				die(json_encode(array('code'=>1,'msg'=>'添加成功')));
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}elseif($type == 'edit'){
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if($post['itemId'] && $post['dataType']){
					if((int)$post['dataType'] == 1){
						$sql = "update zhan_item set `sys_default` = '".$post['itemName']."',`row` = '".$post['itemRow']."',`column` = '".$post['itemColumn']."',`item_sort` = '".$post['itemSort']."' where item_id = '".$post['itemId']."'";
					}else{
						$sql = "update zhan_item set `item_name` = '".$post['itemName']."',`row` = '".$post['itemRow']."',`column` = '".$post['itemColumn']."',`item_sort` = '".$post['itemSort']."' where item_id = '".$post['itemId']."'";
					}
					$db->execute($sql);
					die(json_encode(array('code'=>1,'msg'=>'编辑成功')));
				}
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}elseif($type == 'del'){
			$itemId = $this->dispatcher->getParam(1,'int');
			if($itemId){
				$db->execute("delete from zhan_item where item_id = '".$itemId."'");
				$db->execute("delete from zhan_img where item_id = '".$itemId."'");
				die(json_encode(array('code'=>1,'msg'=>'删除成功')));
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}elseif($type == 'imgupload'){
			if($this->request->isPost() == true){
				$post = $this->request->getPost();
				if(!$post['itemId']) die(json_encode(array('code'=>0,'msg'=>'参数错误')));
				$info = $db->fetchOne("select * from zhan_item where item_id = '".$post['itemId']."'",\Phalcon\Db::FETCH_ASSOC);
				if(isset($_FILES['file']) && $_FILES['file']['size'] > 0){
					$imgType = substr($_FILES['file']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die(json_encode(array('code'=>0,'msg'=>'图片格式不匹配')));;
					move_uploaded_file($_FILES['file']["tmp_name"],"uploads/zhan/".$imgName);
					$data['img_name'] = $imgName;
				}
				$data['item_id'] = $post['itemId'];
				$data['zhan_id'] = $info['zhan_id'];
				$data['c_id'] = $info['c_id'];
				$data['type'] = $info['type'];
				if($post['imgtype'] == 'bg'){
					$data['img_type'] = '1';
					$data['click_bmWnd'] = $post['imgBmOpen'];
					$resId = $db->fetchColumn("select img_id from zhan_img where img_type = '1' and item_id = '".$post['itemId']."'");
					if($resId){
						if(isset($data['img_name'])){
							$db->execute("update zhan_img set `img_name` = '".$data['img_name']."',`click_bmWnd` = '".$data['click_bmWnd']."' where item_id = '".$post['itemId']."' and img_type = '1'");
						}else{
							$db->execute("update zhan_img set `click_bmWnd` = '".$data['click_bmWnd']."' where item_id = '".$post['itemId']."' and img_type = '1'");
						}
						die(json_encode(array('code'=>1,'resId'=>$resId,'msg'=>'修改成功')));
					}else{
						if($data['img_name']) $db->execute("insert into zhan_img(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
						die(json_encode(array('code'=>1,'resId'=>$db->lastInsertId(),'msg'=>'添加成功')));
					}					
				}elseif($post['imgtype'] == 'fg'){
					$data['img_type'] = '2';
					$data['img_url'] = $post['imgUrl'];
					$data['img_sort'] = $post['imgSort'];
					if(!isset($data['img_name'])){
						$db->execute("update zhan_img set `img_url` = '".$data['img_url']."',`img_sort` = '".$data['img_sort']."' where img_id = '".$post['oldId']."'");
						die(json_encode(array('code'=>1,'resId'=>$post['oldId'],'msg'=>'修改成功')));
					}else{
						$db->execute("insert into zhan_img(`".implode('`,`',array_keys($data))."`) values('".implode("','",$data)."')");
						die(json_encode(array('code'=>1,'resId'=>$db->lastInsertId(),'msg'=>'添加成功')));
					}
				}
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}elseif($type == 'imgshow'){
			$itemId = $this->dispatcher->getParam(1,'int');
			
			$data = $db->fetchAll("select * from zhan_img where item_id = $itemId order by img_type asc,img_sort asc",\Phalcon\Db::FETCH_ASSOC);
			
			die(json_encode(array('code'=>1,'msg'=>$data)));
		}elseif($type == 'imgdel'){
			$imgId = $this->dispatcher->getParam(1,'int');
			if($imgId){
				$db->execute("delete from zhan_img where img_id = '".$imgId."'");
				die(json_encode(array('code'=>1,'msg'=>'删除成功')));
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}
	}

	//平滑页编辑
	public function phpageAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$cId = $this->dispatcher->getParam(1,'int');
		$db = $this->group;
		
		if($type == 'show'){
			$info = $db->fetchOne("select b.zhan_name,a.* from zhan_city as a left join zhan_list as b on a.zhan_id = b.zhan_id where a.c_id = $cId",\Phalcon\Db::FETCH_ASSOC);
			$cityBox = $this->CityBox();
			
			$sql = "select ifnull(b.item_name,'') as sys_name,a.sys_default,a.item_id,a.item_name,a.type,a.item_sort,a.row,a.column from zhan_item as a left join zhan_item_default as b on a.sys_default = b.id where a.c_id = $cId and a.type = '1' order by a.item_sort asc";
			$item = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			
			$wxShareImg = $db->fetchOne("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '5'",\Phalcon\Db::FETCH_ASSOC);
			$dikou = $db->fetchOne("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '6'",\Phalcon\Db::FETCH_ASSOC);
			$successAdv = $db->fetchAll("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '4' order by img_sort asc limit 3",\Phalcon\Db::FETCH_ASSOC);
			$successBg = $db->fetchAll("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '8' limit 1",\Phalcon\Db::FETCH_ASSOC);
			$afterPhoneImg = $db->fetchOne("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '9' limit 1",\Phalcon\Db::FETCH_ASSOC);
			$afterYzmImg = $db->fetchOne("select * from zhan_img where type = '1' and c_id = '".$cId."' and img_type = '10' limit 1",\Phalcon\Db::FETCH_ASSOC);
			
			$this->view->setVars(array('info'=>$info,'cityBox'=>$cityBox,'item'=>$item,'wxShareImg'=>$wxShareImg,'dikou'=>$dikou,'successAdv'=>$successAdv,'successBg'=>$successBg,'afterPhoneImg'=>$afterPhoneImg,'afterYzmImg'=>$afterYzmImg));
		}elseif($type == 'edit'){
			if($this->request->isPost() == true){
				$zhanId = $db->fetchColumn("select zhan_id from zhan_city where c_id = '".$cId."'");
				$post = $this->request->getPost();
// 				var_dump($_FILES);die;
				$info = array();  //print_r($post);exit();
				if(isset($post['ph_register']) && $post['ph_register']) $info['ph_register'] = 2;
				$info['tobm_txt_1'] = $post['tobm_txt'];
				$info['bmwnd_txt_1'] = $post['bmwnd_txt'];
				$info['bmhx_txt_1'] = $post['bmhx_txt'];
				$info['bmsuccess_txt_1'] = $post['bmsuccess_txt'];
				$info['submit_btn_txt_1'] = $post['submit_btn_txt'];
				$info['sms_bm_1'] = $post['sms_bm'];
				$info['wx_share_1'] = $post['wx_share'];
				$str = ""; foreach($info as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = ".($v == 'NULL' ? "NULL" : "'".$v."'");
				$db->execute("update zhan_city set $str where c_id = '".$cId."'");
				
				if(isset($_FILES['wx_img']) && $_FILES['wx_img']['size'] > 0){  //微信分享小图
					$imgId = $db->fetchColumn("select img_id from zhan_img where type = '1' and img_type = '5' and c_id = '".$cId."' limit 1");
					$imgType = substr($_FILES['wx_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['wx_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($imgId){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$imgId."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','1','".$imgName."','5')");
					}
				}
				if(isset($_FILES['dikou']) && $_FILES['dikou']['size'] > 0){  //抵扣卷
					$imgType = substr($_FILES['dikou']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['dikou']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['dikou_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['dikou_url']."' where img_id = '".$post['dikou_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','1','".$imgName."','6','".$post['dikou_url']."')");
					}
				}
				if(isset($_FILES['success_adv1']) && $_FILES['success_adv1']['size'] > 0){  //成功页广告1
					$imgType = substr($_FILES['success_adv1']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv1']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv1_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url1']."' where img_id = '".$post['success_adv1_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','1','".$imgName."','4','".$post['success_adv_url1']."')");
					}
				}
				if(isset($_FILES['success_adv2']) && $_FILES['success_adv2']['size'] > 0){  //成功页广告2
					$imgType = substr($_FILES['success_adv2']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv2']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv2_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url2']."' where img_id = '".$post['success_adv2_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','1','".$imgName."','4','".$post['success_adv_url2']."')");
					}
				}
				if(isset($_FILES['success_adv3']) && $_FILES['success_adv3']['size'] > 0){  //成功页广告3
					$imgType = substr($_FILES['success_adv3']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv3']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv3_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url3']."' where img_id = '".$post['success_adv3_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','1','".$imgName."','4','".$post['success_adv_url3']."')");
					}
				}
				if(isset($_FILES['success_bg']) && $_FILES['success_bg']['size'] > 0){  //成功页背景图
					$imgType = substr($_FILES['success_bg']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_bg']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_bg_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['success_bg_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','1','".$imgName."','8')");
					}
				}
				if(isset($_FILES['after_phone_img']) && $_FILES['after_phone_img']['size'] > 0){  //关闭手机号输入框时弹出广告
					$imgType = substr($_FILES['after_phone_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['after_phone_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['after_phone_imgId']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['after_phone_imgId']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','1','".$imgName."','9')");
					}
				}
				if(isset($_FILES['after_yzm_img']) && $_FILES['after_yzm_img']['size'] > 0){  //关闭验证码输入框时弹出广告
					$imgType = substr($_FILES['after_yzm_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['after_yzm_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['after_yzm_imgId']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['after_yzm_imgId']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','1','".$imgName."','10')");
					}
				}
				header("Location:/admin/zhan/city/list/$zhanId");
			}
		}elseif($type == 'imgdel'){
			if($cId){
				$db->execute("delete from zhan_img where type = '1' and img_id = $cId and img_type in ('4','6','8','9','10')");
				die(json_encode(array('code'=>1,'msg'=>'删除成功')));
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}
	}
		
	//翻页编辑
	public function fypageAction(){
		$type = $this->dispatcher->getParam(0,'string');
		$cId = $this->dispatcher->getParam(1,'int');
		$db = $this->group;
		
		if($type == 'show'){
			$info = $db->fetchOne("select b.zhan_name,a.* from zhan_city as a left join zhan_list as b on a.zhan_id = b.zhan_id where a.c_id = $cId",\Phalcon\Db::FETCH_ASSOC);
			$cityBox = $this->CityBox();
			
			$sql = "select ifnull(b.item_name,'') as sys_name,a.sys_default,a.item_id,a.item_name,a.type,a.item_sort,a.row,a.column from zhan_item as a left join zhan_item_default as b on a.sys_default = b.id where a.c_id = $cId and a.type = '2' order by a.item_sort asc";
			$item = $db->fetchAll($sql,\Phalcon\Db::FETCH_ASSOC);
			
			$wxShareImg = $db->fetchOne("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '5'",\Phalcon\Db::FETCH_ASSOC);
			$dikou = $db->fetchOne("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '6'",\Phalcon\Db::FETCH_ASSOC);
			$successAdv = $db->fetchAll("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '4' order by img_sort asc limit 3",\Phalcon\Db::FETCH_ASSOC);
			$successBg = $db->fetchAll("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '8' limit 1",\Phalcon\Db::FETCH_ASSOC);
			$afterPhoneImg = $db->fetchOne("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '9' limit 1",\Phalcon\Db::FETCH_ASSOC);
			$afterYzmImg = $db->fetchOne("select * from zhan_img where type = '2' and c_id = '".$cId."' and img_type = '10' limit 1",\Phalcon\Db::FETCH_ASSOC);
				
			$this->view->setVars(array('info'=>$info,'cityBox'=>$cityBox,'item'=>$item,'wxShareImg'=>$wxShareImg,'dikou'=>$dikou,'successAdv'=>$successAdv,'successBg'=>$successBg,'afterPhoneImg'=>$afterPhoneImg,'afterYzmImg'=>$afterYzmImg));
		}elseif($type == 'edit'){
			if($this->request->isPost() == true){
				$zhanId = $db->fetchColumn("select zhan_id from zhan_city where c_id = '".$cId."'");
				$post = $this->request->getPost();
				$info = array();
				if(isset($post['fy_register']) && $post['fy_register']) $info['fy_register'] = 2;
				$info['sponsor'] = $post['sponsor'];
				$info['bmwnd_txt_2'] = $post['bmwnd_txt'];
				$info['bmhx_txt_2'] = $post['bmhx_txt'];
				$info['tobm_txt_2'] = $post['tobm_txt'];
				$info['bmsuccess_txt_2'] = $post['bmsuccess_txt'];
				$info['submit_btn_txt_2'] = $post['submit_btn_txt'];
				$info['sms_bm_2'] = $post['sms_bm'];
				$info['wx_share_2'] = $post['wx_share'];
				$str = ""; foreach($info as $k=>$v) $str .= ($str == "" ? "" : "," )."`".$k."` = ".($v == 'NULL' ? "NULL" : "'".$v."'");
				$db->execute("update zhan_city set $str where c_id = '".$cId."'");
				
				if(isset($_FILES['wx_img']) && $_FILES['wx_img']['size'] > 0){  //微信分享小图
					$imgId = $db->fetchColumn("select img_id from zhan_img where type = '2' and img_type = '5' and c_id = '".$cId."' limit 1");
					$imgType = substr($_FILES['wx_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['wx_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($imgId){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$imgId."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','2','".$imgName."','5')");
					}
				}
				if(isset($_FILES['dikou']) && $_FILES['dikou']['size'] > 0){  //抵扣卷
					$imgType = substr($_FILES['dikou']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['dikou']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['dikou_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['dikou_url']."' where img_id = '".$post['dikou_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','2','".$imgName."','6','".$post['dikou_url']."')");
					}
				}
				if(isset($_FILES['success_adv1']) && $_FILES['success_adv1']['size'] > 0){  //成功页广告1
					$imgType = substr($_FILES['success_adv1']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv1']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv1_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url1']."' where img_id = '".$post['success_adv1_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','2','".$imgName."','4','".$post['success_adv_url1']."')");
					}
				}
				if(isset($_FILES['success_adv2']) && $_FILES['success_adv2']['size'] > 0){  //成功页广告2
					$imgType = substr($_FILES['success_adv2']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv2']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv2_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url2']."' where img_id = '".$post['success_adv2_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','2','".$imgName."','4','".$post['success_adv_url2']."')");
					}
				}
				if(isset($_FILES['success_adv3']) && $_FILES['success_adv3']['size'] > 0){  //成功页广告3
					$imgType = substr($_FILES['success_adv3']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_adv3']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_adv3_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."',`img_url` = '".$post['success_adv_url3']."' where img_id = '".$post['success_adv3_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`,`img_url`) values('".$zhanId."','".$cId."','2','".$imgName."','4','".$post['success_adv_url3']."')");
					}
				}
				if(isset($_FILES['success_bg']) && $_FILES['success_bg']['size'] > 0){  //成功页背景图
					$imgType = substr($_FILES['success_bg']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['success_bg']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['success_bg_id']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['success_bg_id']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','2','".$imgName."','8')");
					}
				}
				if(isset($_FILES['after_phone_img']) && $_FILES['after_phone_img']['size'] > 0){  //关闭手机号输入框时弹出广告
					$imgType = substr($_FILES['after_phone_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['after_phone_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['after_phone_imgId']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['after_phone_imgId']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','2','".$imgName."','9')");
					}
				}
				if(isset($_FILES['after_yzm_img']) && $_FILES['after_yzm_img']['size'] > 0){  //关闭验证码输入框时弹出广告
					$imgType = substr($_FILES['after_yzm_img']["type"],6);
					$imgName = date('YmdHis').rand(100,999).".".$imgType;
					if(!in_array($imgType,array('gif','png','jpg','pjpeg','jpeg'))) die('只能上传 jpeg png gif 格式图片');
					move_uploaded_file($_FILES['after_yzm_img']["tmp_name"],"uploads/zhan/".$imgName);
					if($post['after_yzm_imgId']){
						$db->execute("update zhan_img set `img_name` = '".$imgName."' where img_id = '".$post['after_yzm_imgId']."'");
					}else{
						$db->execute("insert into zhan_img(`zhan_id`,`c_id`,`type`,`img_name`,`img_type`) values('".$zhanId."','".$cId."','2','".$imgName."','10')");
					}
				}
				header("Location:/admin/zhan/city/list/$zhanId");
			}
		}elseif($type == 'imgdel'){
			if($cId){
				$db->execute("delete from zhan_img where type = '2' and img_id = $cId and img_type in ('4','6','8','9','10')");
				die(json_encode(array('code'=>1,'msg'=>'删除成功')));
			}
			die(json_encode(array('code'=>0,'msg'=>'参数错误')));
		}
	}

	public function citylistbyidAction(){
		$id = $this->dispatcher->getParam(0,"int");
		if($id){
			$data = array();
			if($id > 5){ // 小于7为直辖市，不需要再选择
				$data = $this->group->fetchAll("select r.region_id as city_id, r.type, r.parent_id, r.region_name as city_name from region r where r.parent_id = $id",\Phalcon\Db::FETCH_ASSOC);
			}
			die(json_encode(array('code'=>1,'msg'=>$data)));
		}
		die(json_encode(array('code'=>0,'msg'=>'参数错误')));
	}
	
	public function systemitemAction(){
		$type = $this->dispatcher->getParam(0,"int");
		if($type){
			$data = $this->group->fetchAll("select * from zhan_item_default where type = '".$type."'",\Phalcon\Db::FETCH_ASSOC);
			die(json_encode(array('code'=>1,'msg'=>$data)));
		}
		die(json_encode(array('code'=>0,'msg'=>'参数错误')));
	}
	

	/**
	 * 活动数据统计
	 */
	public function register_listAction()
    {
        
        $act_id = $this->dispatcher->getParam(0,"int");
        $act_name = $this->get_actioninfo($act_id);
        $this->view->setVar("act_id", $act_id);
        $this->view->setVar("act_name", $act_name);
        $this->session->set('us_input', '');
        
	    $zhanId = $this->dispatcher->getParam(0,"int");
	    $cityBox = $this->CityBox();
    	
	    $sql = "SELECT count(*) FROM zhan_register where zhan_id = '{$zhanId}'";
	    $a_count = $this->group->fetchColumn($sql);
// 	    var_dump($a_count);die;
	    
	    //数据列表
	    $sql = "SELECT * FROM zhan_list where zhan_id = '{$zhanId}'";
	    $zhanInfo = $this->group->fetchOne($sql);
	    
	    $sql = "select c_id,title,city_id,zhan_id from zhan_city where zhan_id = '{$zhanId}'";
	    $cityList = $this->group->fetchAll($sql);
	    
	    $mb_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE zhan_id = '{$zhanId}'";
	    $mb_count = $this->group->fetchOne($mb_sql);
	    
	    $page = new \Library\Com\Page($mb_count['num'], 10);
	    $list_sql = "SELECT * FROM zhan_register where zhan_id = '{$zhanId}' ORDER BY addtime DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    
	    foreach ($list as $k=>$v)
	    {
	    	$list[$k]['city_id'] = $this->get_city_id($v['c_id']);
	    }
	    //         echo '<pre>';print_r($list);exit;
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar('data',$zhanInfo);
	    $this->view->setVar('citybox',$cityBox);
	    $this->view->setVar('cityList',$cityList);
	    $this->view->setVar("list", $list);
	    $this->view->setVar("mb_count", $mb_count['num']);
	    $this->view->setVar("a_count", $a_count);

	}
	
    public function budian_statisticsAction()
	{
	    
	    $act_id = $this->dispatcher->getParam(0,"int");
	    $act_name = $this->get_actioninfo($act_id);
	    $this->view->setVar("act_id", $act_id);
	    $this->view->setVar("act_name", $act_name);
	    
	    $bm_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE btn_id <> '' AND zhan_id=".$act_id;
	    $bm_count = $this->group->fetchOne($bm_sql);
	    
	    $sql = "SELECT COUNT(*) AS num FROM zhan_budian WHERE zhan_id=".$act_id;
	    $count = $this->group->fetchOne($sql);
	    
	    //总的转化率
	    $total_zhl = sprintf("%.4f", $bm_count['num']/$count['num'])*100;
	    $this->view->setVar('click_num', $count['num']);
	    $this->view->setVar('bm_count', $bm_count['num']);
	    $this->view->setVar('total_zhl', $total_zhl);
	    
	    //各屏布点数据统计
	    $group_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM zhan_budian WHERE zhan_id=".$act_id." GROUP BY btn_id";
	    $group_list = $this->group->fetchAll($group_sql);
// 	    echo '<pre>';print_r($group_list);exit;
	    $city_zhl_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM zhan_register WHERE btn_id <> '' AND zhan_id=".$act_id." GROUP BY btn_id";
	    $zhl_list = $this->group->fetchAll($city_zhl_sql);
	    foreach ($zhl_list as $k => $key){
	        $bdzhl_arr[$key['btn_id']] = $key;
	    }
	    foreach ($group_list as $k => $key){
	        if($key['btn_id']){
	            $group_arr[$k]['name'] = $key['btn_id'];
	            $group_arr[$k]['proportion'] = sprintf("%.4f", $key['num']/$count['num'])*100;
	            $group_arr[$k]['click_num'] = $key['num'];//点击量
	            if(empty($bdzhl_arr[$key['btn_id']]['num'])){
	                $group_arr[$k]['bm_num'] = 0;//报名数
	                $group_arr[$k]['zhl'] = 0/$key['num'];//转化率
	            } else {
	                $group_arr[$k]['bm_num'] = $bdzhl_arr[$key['btn_id']]['num'];
	                $group_arr[$k]['zhl'] = sprintf("%.4f", $bdzhl_arr[$key['btn_id']]['num']/$key['num'])*100;
	            }
	            $group_arr[$k]['color'] = $this->color_class(rand(1, 6));
	        }
	    }
	    
	    if(!empty($group_arr)){
	        $array_sort = $this->funs_model->array_sort($group_arr, 'proportion', 'DESC');
	        $this->view->setVar('array_sort', $array_sort);
	        $this->view->setVar('btn_num', count($group_arr));
	    }
// 	            echo '<pre>';print_r($bdzhl_arr);exit;
	    
	    //各城市站布点数据统计
	    $city_box = $this->CityBox();
	    $city_sql = "SELECT c_id, COUNT(c_id) AS num FROM zhan_budian WHERE zhan_id=".$act_id." GROUP BY c_id";
	    $city_list = $this->group->fetchAll($city_sql);
	    foreach ($city_list as $k => $key){
	        $city_arr[$k]['c_id'] = $key['c_id'];
	        $city_arr[$k]['city'] = $city_box[$this->get_city_id($key['c_id'])]['region_name'];
	        $city_arr[$k]['proportion'] = sprintf("%.4f", $key['num']/$count['num'])*100;
	        $city_arr[$k]['click_num'] = $key['num'];
	        $city_arr[$k]['color'] = $this->color_class(rand(1, 6));
	    }
	    if(!empty($city_arr)){
	        $city_sort = $this->funs_model->array_sort($city_arr, 'proportion', 'DESC');
	        $this->view->setVar('city_sort', $city_sort);
	        $this->view->setVar('city_num', count($city_sort));
	    }
	}
	
	public function get_actioninfo($act_id)
	{
	    $sql = "SELECT zhan_name FROM zhan_list WHERE zhan_id=".$act_id;
	    $info = $this->group->fetchOne($sql);
	    return $info['zhan_name'];
	}
	
	//比例图颜色
	public function color_class($color)
	{
	    $color_class = array(
	        1 => 'bg-primary',
	        2 => 'bg-success',
	        3 => 'bg-info',
	        4 => 'bg-dark',
	        5 => 'bg-warning',
	        6 => 'bg-danger',
	    );
	    return $color_class[$color];
	}
	
	public function get_city_id($c_id)
	{
	    $sql = "SELECT city_id FROM zhan_city WHERE c_id=".$c_id;
	    $info = $this->group->fetchOne($sql);
	    return $info['city_id'];
	}
	
	//城市排行
	public function city_rankingAction()
	{
	    $act_id = $this->dispatcher->getParam(0,"int");
	    $act_name = $this->get_actioninfo($act_id);
	    $this->view->setVar("act_id", $act_id);
	    $this->view->setVar("act_name", $act_name);
	    
	    if($this->request->isPost() == true)
	    {
	        $post = $this->request->getPost();
	        $starttime = $post['starttime'];
	        $endtime = date('Y-m-d',(strtotime($post['endtime'])+86400));
	        $where = " AND addtime >= '".$starttime."' AND addtime < '".$endtime."'";
	        if($post['starttime'] == $post['endtime']){
	            $time = $starttime;
	        } else if($post['starttime'] > $post['endtime']){
	            echo "<script>alert('时间段格式错误，起始时间应小于结束时间！')</script>";exit;
	        } else {
	            $time = $starttime.'-'.$post['endtime'];
	        }
	        $this->session->set('starttime', $starttime);
	        $this->session->set('endtime', $post['endtime']);
	    } else {
	        $where = " AND addtime >= '".date('Y-m-d',time())."' AND addtime < '".date('Y-m-d',strtotime("+1 day"))."'";
	        $time = date('Y-m-d',time());
	        $this->session->set('starttime', '');
	        $this->session->set('endtime', '');
	    }
	    
// 	    $mb_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE zhan_id = '{$act_id}'".$where;
// 	    $mb_count = $this->group->fetchOne($mb_sql);
// 	    $this->view->setVar("mb_count", $mb_count['num']);
	    $city_box = $this->CityBox();
	    
// 	    $page = new \Library\Com\Page($mb_count['num'], 10);
	    $city_sql = "SELECT c_id,city_id FROM zhan_city WHERE zhan_id=".$act_id;
	    $list = $this->group->fetchAll($city_sql);
// 	echo "<pre>";print_r($list);exit;

        //同城数
	    $list_sql = "SELECT * FROM zhan_register WHERE zhan_id ='".$act_id."'".$where;
	    $data_list = $this->group->fetchAll($list_sql);
	    if($data_list){
    	    foreach ($data_list as $k => $key){
    	        $city_id = $this->get_city_id($key['c_id']);
    	        if($city_box[$city_id]['region_name'] == $key['phone_city'] || $city_box[$city_id]['region_name'] == $key['ip_city']){
    	            $tc_count_arr[$key['c_id']] = $tc_count_arr[$key['c_id']] + 1; 
    	        }
    	    }
	    }
// 	    echo '<pre>';print_r($tc_count_arr);exit;
	    
	    //报名人数
	    $num_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." GROUP BY c_id";
	    $num_count = $this->group->fetchAll($num_count_sql);
	    foreach ($num_count as $k => $key){
	        $num_count_arr[$key['c_id']] = $key['num'];
	    }
// 	    	    echo '<pre>';print_r($num_count_arr);exit;
	    //已验证数
	    $yz_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." AND auth='1' GROUP BY c_id";
	    $yz_count = $this->group->fetchAll($yz_count_sql);
	    foreach ($yz_count as $k => $key){
	        $yz_count_arr[$key['c_id']] = $key['num'];
	    }
// 	    	    echo '<pre>';print_r($yz_count);exit;
	    //地址数
	    $dz_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." AND address <> '' GROUP BY c_id";
	    $dz_count = $this->group->fetchAll($dz_count_sql);
	    foreach ($dz_count as $k => $key){
	        $dz_count_arr[$key['c_id']] = $key['num'];
	    }
	    // 	    echo '<pre>';print_r($dz_count);exit;
	    
	    
	    foreach ($list as $k => $key){
	        $city_list[$k]['time'] = $time;
	        $city_list[$k]['city_name'] = $city_box[$key['city_id']]['region_name'];
	        $city_list[$k]['num'] = empty($num_count_arr[$key['c_id']]) ? 0 : $num_count_arr[$key['c_id']];
	        $city_list[$k]['yz'] = empty($yz_count_arr[$key['c_id']]) ? 0 : $yz_count_arr[$key['c_id']];
	        $city_list[$k]['dz'] = empty($dz_count_arr[$key['c_id']]) ? 0 : $dz_count_arr[$key['c_id']];
	        $city_list[$k]['tc'] = empty($tc_count_arr[$key['c_id']]) ? 0 : $tc_count_arr[$key['c_id']];
	        @$city_list[$k]['yzl'] = sprintf("%.4f",$yz_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	        @$city_list[$k]['dzl'] = sprintf("%.4f",$dz_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	        @$city_list[$k]['tcl'] = sprintf("%.4f",$tc_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	    }
	    $city_list = $this->funs_model->array_sort($city_list, 'num', 'DESC');
	    $this->view->setVar('starttime',$starttime);
	    $this->view->setVar('endtime',$post['endtime']);
	    $this->view->setVar('city_list', array_merge($city_list));
	    $this->view->setVar('act_id',$act_id);
// 	    	    echo '<pre>';print_r($city_list);exit;
	}
	
	public function city_ranking_xlsAction(){
	    
	    $act_id = $this->dispatcher->getParam(0,"int");
	    $type = $this->dispatcher->getParam(1);
	    
	    $act_name = $this->get_actioninfo($act_id);
	    
	    $starttime = $this->session->get('starttime');
	    $endtime = $this->session->get('endtime');
	    if(empty($type))
	    {
	        $where = " AND addtime >= '".$starttime."' AND addtime < '".date('Y-m-d',(strtotime($endtime)+86400))."'";
	        if($starttime == $endtime){
	            $time = $starttime;
	        } else {
	            $time = $starttime.'-'.$endtime;
	        }
	    } else {
	        $where = "";
	        $time = '活动起始时间-'.date('Y-m-d',time());
	    }
	     
	    $mb_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE zhan_id = '{$act_id}'".$where;
	    $mb_count = $this->group->fetchOne($mb_sql);
	    $this->view->setVar("mb_count", $mb_count['num']);
	    $city_box = $this->CityBox();
	     
	    $page = new \Library\Com\Page($mb_count['num'], 10);
	    $city_sql = "SELECT c_id,city_id FROM zhan_city WHERE zhan_id=".$act_id." LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($city_sql);
	    
	    //同城数
	    $list_sql = "SELECT * FROM zhan_register WHERE zhan_id ='".$act_id."'".$where;
	    $data_list = $this->group->fetchAll($list_sql);
	    if($data_list){
	        foreach ($data_list as $k => $key){
	            $city_id = $this->get_city_id($key['c_id']);
	            if($city_box[$city_id]['region_name'] == $key['phone_city'] || $city_box[$city_id]['region_name'] == $key['ip_city']){
	                $tc_count_arr[$key['c_id']] = $tc_count_arr[$key['c_id']] + 1;
	            }
	        }
	    }
	    //报名人数
	    $num_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." GROUP BY c_id";
	    $num_count = $this->group->fetchAll($num_count_sql);
	    foreach ($num_count as $k => $key){
	        $num_count_arr[$key['c_id']] = $key['num'];
	    }
	    //已验证数
	    $yz_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." AND auth='1' GROUP BY c_id";
	    $yz_count = $this->group->fetchAll($yz_count_sql);
	    foreach ($yz_count as $k => $key){
	        $yz_count_arr[$key['c_id']] = $key['num'];
	    }
	    //地址数
	    $dz_count_sql = "SELECT c_id,COUNT(c_id) AS num FROM zhan_register WHERE zhan_id ='".$act_id."'".$where." AND address <> '' GROUP BY c_id";
	    $dz_count = $this->group->fetchAll($dz_count_sql);
	    foreach ($dz_count as $k => $key){
	        $dz_count_arr[$key['c_id']] = $key['num'];
	    }
	    foreach ($list as $k => $key){
	        $city_list[$k]['time'] = $time;
	        $city_list[$k]['city_name'] = $city_box[$key['city_id']]['region_name'];
	        $city_list[$k]['num'] = empty($num_count_arr[$key['c_id']]) ? 0 : $num_count_arr[$key['c_id']];
	        $city_list[$k]['yz'] = empty($yz_count_arr[$key['c_id']]) ? 0 : $yz_count_arr[$key['c_id']];
	        $city_list[$k]['dz'] = empty($dz_count_arr[$key['c_id']]) ? 0 : $dz_count_arr[$key['c_id']];
	        $city_list[$k]['tc'] = empty($tc_count_arr[$key['c_id']]) ? 0 : $tc_count_arr[$key['c_id']];
	        @$city_list[$k]['yzl'] = sprintf("%.4f",$yz_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	        @$city_list[$k]['dzl'] = sprintf("%.4f",$dz_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	        @$city_list[$k]['tcl'] = sprintf("%.4f",$tc_count_arr[$key['c_id']] / $num_count_arr[$key['c_id']])*100;
	    }
	    $city_list = $this->funs_model->array_sort($city_list, 'num', 'DESC');
	    
	    $str = "时间\t城市\t报名人数\t已验证数\t同城数\t填写地址数\t手机验证率\t同城率\t填写地址率\t\n";
	    $str = iconv('utf-8','gb2312',$str);
	    foreach ($city_list as $k => $key){
	        $time = iconv('utf-8','gb2312//IGNORE',$key['time']);
	        $city_name = iconv('utf-8','gb2312//IGNORE',$key['city_name']);
	        $num = iconv('utf-8','gb2312//IGNORE',$key['num']);
	        $yz = iconv('utf-8','gb2312//IGNORE', $key['yz']);
	        $tc = iconv('utf-8','gb2312//IGNORE',$key['tc']);
	        $dz = iconv('utf-8','gb2312//IGNORE',$key['dz']);
	        $yzl = iconv('utf-8','gb2312//IGNORE',$key['yzl'].'%');
	        $tcl = iconv('utf-8','gb2312//IGNORE', $key['tcl'].'%');
	        $dzl = iconv('utf-8','gb2312//IGNORE',$key['dzl'].'%');
	        	
	        $str .= $time."\t".$city_name."\t".$num."\t".$yz."\t".$tc."\t".$dz."\t".$yzl."\t".$tcl."\t".$dzl."\t\n";
	        	
	    }
	    $filename = date('YmdHis').'.xls';
	    $this->funs_model->exportExcel($filename, $str);
	}
	
	//用户搜索
	public function usersearchAction()
	{
		$zhanId = $this->dispatcher->getParam(0,"int");
		$cityBox = $this->CityBox();
		 
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$zhanId = $post['zhan_id'];
// 			var_dump($post);die;
			$cityId = $post['city_id'];
			$auth = $post['auth'];
			$from = trim($post['from']);
			$starttime = trim($post['starttime']);
			$endtime = trim($post['endtime']);
			$searchTag = true;
			
			$where = " where zhan_id = '{$zhanId}'";
			$input = array();
			if(!empty($cityId))
			{
				$where .= " and c_id = '{$cityId}'";
				$input['city_id'] = $cityId;
			}

			if($auth !== '')
			{
				$where .= " and auth = '{$auth}'";
				$input['auth'] = $auth == 1?'是':'否';
			}

			if(!empty($from))
			{
				$where .= " and `from` = '{$from}'";
				$input['from'] = $from;
			}

			if(!empty($starttime))
			{
				$where .= " and addtime >= '{$starttime}'";
				$input['starttime'] = $starttime;
			}

			if(!empty($endtime))
			{
				$endtime = date('Y-m-d H:i:s',strtotime($endtime)+86400);
				$where .= " and addtime <= '{$endtime}'";
				$input['endtime'] = date('Y-m-d',strtotime($endtime)-86400);
			}
			$this->session->set('us_input', $input);
			
		}
		else 
		{
			$searchTag = true;
			$where = " where zhan_id = '{$zhanId}'";
			$input = $this->session->get('us_input');
			if(isset($input['city_id']))
			{
				$where .= " and c_id = '{$input['city_id']}'";
			}
			
			if(isset($input['auth']))
			{
				$auth = $input['auth'] == '是'?1:0;
				$where .= " and auth = '{$auth}'";
			}
			
			if(isset($input['from']))
			{
				$where .= " and `from` = '{$input['from']}'";
			}
			
			if(isset($input['starttime']))
			{
				$where .= " and addtime >= '{$input['starttime']}'";
			}
			
			if(isset($input['endtime']))
			{
				$endtime = date('Y-m-d H:i:s',strtotime($input['endtime'])+86400);
				$where .= " and addtime <= '{$endtime}'";
			}
		}
// 		var_dump($this->session->get('us_input'));die;

		$sql = "SELECT count(*) FROM zhan_register where zhan_id = '{$zhanId}'";
		
		$a_count = $this->group->fetchColumn($sql);
		//数据列表
		$sql = "SELECT * FROM zhan_list where zhan_id = '{$zhanId}'";
		$zhanInfo = $this->group->fetchOne($sql);
		 
		$sql = "select c_id,title,city_id,zhan_id from zhan_city where zhan_id = '{$zhanId}'";
		$cityList = $this->group->fetchAll($sql);
		 
		$mb_sql = "SELECT COUNT(*) AS num FROM zhan_register $where";
		$mb_count = $this->group->fetchOne($mb_sql);
		 
		$page = new \Library\Com\Page($mb_count['num'], 10);
		$list_sql = "SELECT * FROM zhan_register $where ORDER BY addtime DESC LIMIT ".$page->firstRow.','.$page->listRows;
// 		var_dump($list_sql);die;
		$list = $this->group->fetchAll($list_sql);
		
		foreach ($list as $k=>$v)
		{
			$list[$k]['city_id'] = $this->get_city_id($v['c_id']);
		}
// 		        echo '<pre>';print_r($list);exit;
		$this->view->setVar('page',$page->show());
		$this->view->setVar('data',$zhanInfo);
		$this->view->setVar('searchtag',$searchTag);
		$this->view->setVar('citybox',$cityBox);
		$this->view->setVar('cityList',$cityList);
		$this->view->setVar('input',$input);
		$this->view->setVar("list", $list);
		$this->view->setVar("mb_count", $mb_count['num']);
		$this->view->setVar("act_id", $zhanId);
		$this->view->setVar("act_name", $zhanInfo['zhan_name']);
		$this->view->pick("zhan/register_list");
		$this->view->setVar("a_count", $a_count);
	}
	
	public function bmtable_xlsAction()
	{
		$zhanId = $this->dispatcher->getParam(0,"int");
		$input = $this->session->get('us_input');
// 		var_dump($this->session->get('us_input'));die;
		$where = "";
		if(isset($input['city_id']))
		{
			$where .= " and c_id = '{$input['city_id']}'";
		}

		if(isset($input['auth']))
		{
			$auth = $input['auth'] == '是'?1:0;
			$where .= " and auth = '{$auth}'";
		}

		if(isset($input['from']))
		{
			$where .= " and `from` = '{$input['from']}'";
		}

		if(isset($input['starttime']))
		{
			$where .= " and addtime >= '{$input['starttime']}'";
		}

		if(isset($input['endtime']))
		{
			$where .= " and addtime <= '" . date('Y-m-d',strtotime($input['endtime'])+86400) . "'";
		}
		 
		$cityBox = $this->CityBox();
		$str = "姓名\t报名城市\t手机号码\t手机归属地\t是否验证\t详细地址\t来源\t报名形式\tIP地址\tIP所属地址\t报名时间\t\n";
		$str = iconv('utf-8','gb2312',$str);
		 
		$list_sql = "SELECT * FROM zhan_register where zhan_id = '{$zhanId}'" . $where;
	    $list = $this->group->fetchAll($list_sql);
		 
		foreach ($list as $k => $key){
			$name = iconv('utf-8','gb2312//IGNORE',$key['name']);
			$cityId = $this->get_city_id($key['c_id']);
			$city = iconv('utf-8','gb2312//IGNORE',$cityBox[$cityId]['region_name']);
			$phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
			$phone_addr = iconv('utf-8','gb2312//IGNORE',$key['phone_province'] . $key['phone_city']);
			$auth = iconv('utf-8','gb2312//IGNORE',$key['auth']==1?'已验证':'未验证');
			$address = iconv('utf-8','gb2312//IGNORE',$cityBox[$k['addr_city']]['region_name'] . $cityBox[$k['addr_city']]['addr_district'] . $key['address']);
			$from = iconv('utf-8','gb2312//IGNORE',$key['from']);
			$type = iconv('utf-8','gb2312//IGNORE',$key['type']==1?'平滑':'翻页');
			$ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
			$ip_address = iconv('utf-8','gb2312//IGNORE', $key['ip_province'] . $key['ip_city']);
			$addtime = iconv('utf-8','gb2312//IGNORE',$key['addtime']);
			
			$str .= $name."\t".$city."\t".$phone."\t".$phone_addr."\t".$auth."\t".$address."\t".$from."\t".$type."\t".$ip."\t".$ip_address."\t".$addtime."\t\n";
			
		}
		$filename = date('YmdHis').'.xls';
		$this->funs_model->exportExcel($filename, $str);
	}
	
	/**
	 * 导出全部XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public function bmtable_allxlsAction()
	{
		$zhanId = $this->dispatcher->getParam(0,"int");
		$cityBox = $this->CityBox();
// 		var_dump($cityBox);die;
		
		/*
		$str = "姓名\t报名城市\t手机号码\t手机归属地\t是否验证\t详细地址\t来源\t报名形式\tIP地址\tIP所属地址\t报名时间\t\n";
		
		 
		 $str = iconv('utf-8','gb2312',$str);
	
		$list_sql = "SELECT * FROM zhan_register where zhan_id = '{$zhanId}'";
	    $list = $this->group->fetchAll($list_sql);
	
		foreach ($list as $k => $key){
			$name = iconv('utf-8','gb2312//IGNORE',$key['name']);
			$cityId = $this->get_city_id($key['c_id']);
			$city = iconv('utf-8','gb2312//IGNORE',$cityBox[$cityId]['region_name']);
			$phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
			$phone_addr = iconv('utf-8','gb2312//IGNORE',$key['phone_province'] . $key['phone_city']);
			$auth = iconv('utf-8','gb2312//IGNORE',$key['auth']==1?'已验证':'未验证');
			$address = iconv('utf-8','gb2312//IGNORE',$cityBox[$k['addr_city']]['region_name'] . $cityBox[$k['addr_city']]['addr_district'] . $key['address']);
			$from = iconv('utf-8','gb2312//IGNORE',$key['from']);
			$type = iconv('utf-8','gb2312//IGNORE',$key['type']==1?'平滑':'翻页');
			$ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
			$ip_address = iconv('utf-8','gb2312//IGNORE', $key['ip_province'] . $key['ip_city']);
			$addtime = iconv('utf-8','gb2312//IGNORE',$key['addtime']);
			
			$str .= $name."\t".$city."\t".$phone."\t".$phone_addr."\t".$auth."\t".$address."\t".$from."\t".$type."\t".$ip."\t".$ip_address."\t".$addtime."\t\n";
			
		}
		$filename = date('YmdHis').'.xls';
		$this->funs_model->exportExcel($filename, $str); */
		
		$filename = date('YmdHis').'.csv';
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=".$filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		$title = "姓名,报名城市,手机号码,手机归属地,是否验证,详细地址,来源,报名形式,IP地址,IP所属地址,报名时间\r\n";
		echo mb_convert_encoding($title,"GBK","UTF-8");
		
		$list_sql = "SELECT * FROM zhan_register where zhan_id = '{$zhanId}'";
		$list = $this->group->fetchAll($list_sql);
// 		var_dump($list);die;
		
		
		foreach ($list as $k => $key){
// 			var_dump( $cityBox[$list[$k]['addr_district']]['region_name']);die;
			$name = $key['name'];
			
			$cityId = $this->get_city_id($key['c_id']);
			$city = $cityBox[$cityId]['region_name'];
			$phone = $key['phone'];
			$phone_addr = $key['phone_province'] . $key['phone_city'];
			$auth = $key['auth']==1?'已验证':'未验证';
			$address = $cityBox[$key['addr_city']]['region_name'] . $cityBox[$key['addr_district']]['region_name'] . $key['address'];
			$from = $key['from'];
			$type = $key['type']==1?'平滑':'翻页';
			$ip = $key['ip'];
			$ip_address = $key['ip_province'] . $key['ip_city'];
			$addtime = $key['addtime'];
				
			$str = $name.",".$city.",".$phone.",".$phone_addr.",".$auth.",".$address.",".$from.",".$type.",".$ip.",".$ip_address.",".$addtime."\r\n";
			
			//$str = $name."\r\n";
			echo mb_convert_encoding($str,"GBK","UTF-8");
		}
		exit();
		
	}
	
	public function action_infoAction()
	{
	    $type = $this->dispatcher->getParam(1,"int");
	    $c_id = $this->dispatcher->getParam(0,"int");
	    $sql = "SELECT zhan_id,city_id FROM zhan_city where c_id = '{$c_id}'";
	    $zhan = $this->group->fetchOne($sql);
	    
	    $cityBox = $this->CityBox();
	    $city_name = $cityBox[$zhan['city_id']]['region_name'];
	    $this->view->setVar("city_name", $city_name);
	    $this->view->setVar("c_id", $c_id);
	    
	    $bm_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE btn_id <> '' AND zhan_id=".$zhan['zhan_id']." AND c_id='".$c_id."' AND type='".$type."'";
	    $bm_count = $this->group->fetchOne($bm_sql);
	    
	    $sql = "SELECT COUNT(*) AS num FROM zhan_budian WHERE zhan_id=".$zhan['zhan_id']." AND c_id='".$c_id."' AND type='".$type."'";
	    $count = $this->group->fetchOne($sql);
	    
	    //总的转化率
	    $total_zhl = sprintf("%.4f", $bm_count['num']/$count['num'])*100;
	    $this->view->setVar('click_num', $count['num']);
	    $this->view->setVar('bm_count', $bm_count['num']);
	    $this->view->setVar('total_zhl', $total_zhl);
	    
	    //各屏布点数据统计
	    $group_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM zhan_budian WHERE zhan_id=".$zhan['zhan_id']." AND c_id='".$c_id."'  AND type='".$type."' GROUP BY btn_id";
	    $group_list = $this->group->fetchAll($group_sql);
// 	    echo '<pre>';print_r($group_list);exit;
	    $city_zhl_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM zhan_register WHERE btn_id <> '' AND zhan_id=".$zhan['zhan_id']." AND c_id='".$c_id."'  AND type='".$type."' GROUP BY btn_id";
	    $zhl_list = $this->group->fetchAll($city_zhl_sql);
	    foreach ($zhl_list as $k => $key){
	        $bdzhl_arr[$key['btn_id']] = $key;
	    }
	    foreach ($group_list as $k => $key){
	        if($key['btn_id']){
	            $group_arr[$k]['name'] = $key['btn_id'];
	            $group_arr[$k]['proportion'] = sprintf("%.4f", $key['num']/$count['num'])*100;
	            $group_arr[$k]['click_num'] = $key['num'];//点击量
	            if(empty($bdzhl_arr[$key['btn_id']]['num'])){
	                $group_arr[$k]['bm_num'] = 0;//报名数
	                $group_arr[$k]['zhl'] = 0/$key['num'];//转化率
	            } else {
	                $group_arr[$k]['bm_num'] = $bdzhl_arr[$key['btn_id']]['num'];
	                $group_arr[$k]['zhl'] = sprintf("%.4f", $bdzhl_arr[$key['btn_id']]['num']/$key['num'])*100;
	            }
	            $group_arr[$k]['color'] = $this->color_class(rand(1, 6));
	        }
	    }
	    
	    if(!empty($group_arr)){
	        $array_sort = $this->funs_model->array_sort($group_arr, 'proportion', 'DESC');
	        $this->view->setVar('array_sort', $array_sort);
	        $this->view->setVar('btn_num', count($group_arr));
	    }
// 	            echo '<pre>';print_r($bdzhl_arr);exit;
	    
	    //各城市站布点数据统计
	    $city_box = $this->CityBox();
	    $city_sql = "SELECT c_id, COUNT(c_id) AS num FROM zhan_budian WHERE zhan_id=".$zhan['zhan_id']." AND c_id='".$c_id."'  AND type='".$type."' GROUP BY c_id";
	    $city_list = $this->group->fetchAll($city_sql);
	    foreach ($city_list as $k => $key){
	        $city_arr[$k]['city'] = $city_box[$this->get_city_id($key['c_id'])]['region_name'];
	        $city_arr[$k]['proportion'] = sprintf("%.4f", $key['num']/$count['num'])*100;
	        $city_arr[$k]['click_num'] = $key['num'];
	        $city_arr[$k]['color'] = $this->color_class(rand(1, 6));
	    }
	    if(!empty($city_arr)){
	        $city_sort = $this->funs_model->array_sort($city_arr, 'proportion', 'DESC');
	        $this->view->setVar('city_sort', $city_sort);
	        $this->view->setVar('city_num', count($city_sort));
	    }
	}
	
	
	/**
	 * 分站用户数据统计
	 * 
	 * 
	 */
	public function cityUserInfoAction()
	{
		$this->session->set('us_input', '');
		$cId = $this->dispatcher->getParam(0,"int");
		$input = array('city_id' =>$cId );
		$this->session->set('us_input', $input);
		$this->view->setVar('c_id',$cId);
		
		$cityBox = $this->CityBox();
		
		$sql = "select * from zhan_city where c_id = '{$cId}'";
		$cityInfo = $this->group->fetchOne($sql);
		$zhanId = $cityInfo['zhan_id'];
		
		$this->view->setVar('city_id',$cityInfo['city_id']);
		 
		$sql = "SELECT count(*) FROM zhan_register where zhan_id = '{$zhanId}'";
		$a_count = $this->group->fetchColumn($sql);
		 
		//数据列表
		$sql = "SELECT * FROM zhan_list where zhan_id = '{$zhanId}'";
		$zhanInfo = $this->group->fetchOne($sql);
		 
		$sql = "select c_id,title,city_id,zhan_id from zhan_city where zhan_id = '{$zhanId}' and c_id = '{$cId}' ";
		$cityList = $this->group->fetchAll($sql);
		 
		$mb_sql = "SELECT COUNT(*) AS num FROM zhan_register WHERE zhan_id = '{$zhanId}' and c_id = '{$cId}' ";
		$mb_count = $this->group->fetchOne($mb_sql);
		 
		$page = new \Library\Com\Page($mb_count['num'], 10);
		$list_sql = "SELECT * FROM zhan_register where zhan_id = '{$zhanId}' and c_id = '{$cId}' ORDER BY addtime DESC LIMIT ".$page->firstRow.','.$page->listRows;
		$list = $this->group->fetchAll($list_sql);
		 
		foreach ($list as $k=>$v)
		{
			$list[$k]['city_id'] = $this->get_city_id($v['c_id']);
		}
		//         echo '<pre>';print_r($list);exit;
		$this->view->setVar('page',$page->show());
		$this->view->setVar('data',$zhanInfo);
		$this->view->setVar('citybox',$cityBox);
		$this->view->setVar('cityList',$cityList);
		$this->view->setVar("list", $list);
		$this->view->setVar("mb_count", $mb_count['num']);
		$this->view->setVar("a_count", $a_count);
	}
	
	public function cityUserSearchAction()
	{
		$zhanId = $this->dispatcher->getParam(0,"int");
		$cityBox = $this->CityBox();
		$this->view->setVar('c_id',$cId);
		
			
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$zhanId = $post['zhan_id'];
			// 			var_dump($post);die;
			$cityId = $post['city_id'];
			$this->view->setVar('c_id',$cityId);
			$cityRegionId = $post['city_region_id'];
			$this->view->setVar('city_id',$cityRegionId);
			$auth = $post['auth'];
			$from = trim($post['from']);
			$starttime = trim($post['starttime']);
			$endtime = trim($post['endtime']);
				
			$where = " where zhan_id = '{$zhanId}'";
			$input = array();
			if(!empty($cityId))
			{
				$where .= " and c_id = '{$cityId}'";
				$input['city_id'] = $cityId;
			}
		
			if($auth !== '')
			{
				$where .= " and auth = '{$auth}'";
				$input['auth'] = $auth == 1?'是':'否';
			}
		
			if(!empty($from))
			{
				$where .= " and `from` = '{$from}'";
				$input['from'] = $from;
			}
		
			if(!empty($starttime))
			{
				$where .= " and addtime >= '{$starttime}'";
				$input['starttime'] = $starttime;
			}
		
			if(!empty($endtime))
			{
				$endtime = date('Y-m-d H:i:s',strtotime($endtime)+86400);
				$where .= " and addtime <= '{$endtime}'";
				$input['endtime'] = date('Y-m-d',strtotime($endtime)-86400);
			}
			
			$input['city_region_id'] = $cityRegionId;
			$this->session->set('us_input', $input);
				
		}
		else
		{
			$where = " where zhan_id = '{$zhanId}'";
			$input = $this->session->get('us_input');
			if(isset($input['city_id']))
			{
				$where .= " and c_id = '{$input['city_id']}'";
			}
			
			if(isset($input['auth']))
			{
				$auth = $input['auth'] == '是'?1:0;
				$where .= " and auth = '{$auth}'";
			}
			
			if(isset($input['from']))
			{
				$where .= " and `from` = '{$input['from']}'";
			}
			
			if(isset($input['starttime']))
			{
				$where .= " and addtime >= '{$input['starttime']}'";
			}
			
			if(isset($input['endtime']))
			{
				$endtime = date('Y-m-d H:i:s',strtotime($input['endtime'])+86400);
				$where .= " and addtime <= '{$endtime}'";
			}
			
			$this->view->setVar('c_id',$input['city_id']);
			$this->view->setVar('city_id',$input['city_region_id']);
		}
		// 		var_dump($this->session->get('us_input'));die;
		
		$sql = "SELECT count(*) FROM zhan_register where zhan_id = '{$zhanId}'";
		
		$a_count = $this->group->fetchColumn($sql);
		//数据列表
		$sql = "SELECT * FROM zhan_list where zhan_id = '{$zhanId}'";
		$zhanInfo = $this->group->fetchOne($sql);
			
		$sql = "select c_id,title,city_id,zhan_id from zhan_city where zhan_id = '{$zhanId}'";
		$cityList = $this->group->fetchAll($sql);
			
		$mb_sql = "SELECT COUNT(*) AS num FROM zhan_register $where";
		$mb_count = $this->group->fetchOne($mb_sql);
			
		$page = new \Library\Com\Page($mb_count['num'], 10);
		$list_sql = "SELECT * FROM zhan_register $where ORDER BY addtime DESC LIMIT ".$page->firstRow.','.$page->listRows;
		// 		var_dump($list_sql);die;
		$list = $this->group->fetchAll($list_sql);
		
		foreach ($list as $k=>$v)
		{
			$list[$k]['city_id'] = $this->get_city_id($v['c_id']);
		}
		// 		        echo '<pre>';print_r($list);exit;
		$this->view->setVar('page',$page->show());
		$this->view->setVar('data',$zhanInfo);
		$this->view->setVar('citybox',$cityBox);
		$this->view->setVar('cityList',$cityList);
		$this->view->setVar('input',$input);
		$this->view->setVar("list", $list);
		$this->view->setVar("mb_count", $mb_count['num']);
		$this->view->setVar("act_id", $zhanId);
		$this->view->setVar("act_name", $zhanInfo['zhan_name']);
		$this->view->pick("zhan/cityUserInfo");
		$this->view->setVar("a_count", $a_count);
	}
	
	public function ABtestAction()
	{
		$type = $this->dispatcher->getParam(0,'string');
		$zhanId = $this->dispatcher->getParam(1,"int");
		$this->view->setVar("zhanid", $zhanId);
		$db = $this->group;
		
		if($type == 'list')
		{
			$sql = "select * from zhan_abtest where zhan_id = '{$zhanId}'";
			$data = $db->fetchAll($sql,\Phalcon\db::FETCH_ASSOC);
			$this->view->setVar("data", $data);
			$this->view->pick("zhan/abtestlist");
		}
		elseif ($type == 'add')
		{
			$sql = "select * from zhan_abtest where zhan_id = '{$zhanId}'";
			$data = $db->fetchAll($sql,\Phalcon\db::FETCH_ASSOC);
			$i = 1;
			foreach ($data as $k=>$v)
			{
				$data[$k]['num'] = $i;
				$i++;
			}
			$this->view->setVar("data", $data);
			$this->view->pick("zhan/abadd");
		}
		elseif ($type == 'modify')
		{
			if($this->request->isPost() == true)
			{
				$post = $this->request->getPost();
// 				var_dump($post);die;
				//信息完整性
				if(in_array('', $post))
				{
					$ajax_result['errcode'] = 1001;
					$ajax_result['errmsg'] = "请填写完整信息";
					die(json_encode($ajax_result));
				}
				
				//是否重复提交场景
				$countRep = array_count_values($post);
				if($countRep['1'] > 1 or $countRep['2'] >1)
				{
					$ajax_result['errcode'] = 1002;
					$ajax_result['errmsg'] = "不能提交相同的场景";
					die(json_encode($ajax_result));
				}
				
				//处理数据入库
				$postData = array_chunk($post, 2);
				$db->execute("begin");
				$persentSum = 0;
				$deleteOutData = array();
				foreach ($postData as $k=>$v)
				{
					if(!preg_match("/^[0-9]*[1-9][0-9]*%$/", $v[1]))
					{
						$db->execute("rollback");
						$ajax_result['errcode'] = 1003;
						$ajax_result['errmsg'] = "流量分配格式不正确";
						die(json_encode($ajax_result));
					}
					
					//总流量值
					$persentSum += substr($v[1], 0,-1);
					
					$sql = "select id from zhan_abtest where zhan_id = $zhanId and scene = '{$v[0]}'";
					$sceneId = $db->fetchColumn($sql);
					if($sceneId)
					{
						$sql = "update zhan_abtest set flow = '{$v['1']}' where id = $sceneId";
						$db->execute($sql);
					}
					else 
					{
						$sql = "insert into zhan_abtest (zhan_id,scene,flow,addtime) values ('{$zhanId}','{$v[0]}','{$v[1]}','" . date('Y-m-d H:i:s') . "')";
						$db->execute($sql);
					}
					
					array_push($deleteOutData, $v[0]);
				}
				
				//删除关闭的场景
				$deleteOutStr = implode(',', $deleteOutData);
				if(empty($deleteOutStr))
				{
					$where = "";
				}
				else 
				{
					$where = " and scene not in ($deleteOutStr)";
				}
				$sql = "delete from zhan_abtest where zhan_id = '{$zhanId}' $where";
				$db->execute($sql);
				
				if($persentSum == 100 || $persentSum == 0)
				{
					$db->execute("commit");
				}
				else 
				{
					$db->execute("rollback");
					$ajax_result['errcode'] = 1004;
					$ajax_result['errmsg'] = "流量分配总和不足或大于100%";
					die(json_encode($ajax_result));
				}
				
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "ok";
				die(json_encode($ajax_result));
			}
		}
		
		
		
	}
}

?>