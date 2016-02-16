<?php
namespace Apps\Admin\Controllers;

//优品团

class GroupController extends ControllerBase{
    private $funs_model;
	public function initialize(){
		parent::initialize();
		$this->funs_model = new \Library\Com\Funs();
	}
	
	public function indexAction(){
	    
	    $this->session->set('select', '');
	    $this->session->set('search', '');
	    
	    $sql = "SELECT COUNT(1) FROM group_list";
	    $count = $this->group->fetchColumn($sql);
	    
	    $start_sql = "SELECT COUNT(1) FROM group_list WHERE is_open=1";
	    $start_num = $this->group->fetchColumn($start_sql);
	    
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM group_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($sql);
	    foreach ($list as $k => $key){
	        $sql = "SELECT COUNT(1) FROM group_goods_list WHERE action_id='".$key['id']."' AND is_show=1 AND start_time<'".time()."' AND end_time>'".time()."'";
	        $end_sql = "SELECT COUNT(1) FROM group_goods_list WHERE action_id='".$key['id']."' AND is_show=1 AND end_time<'".time()."'";
	        $soon_sql = "SELECT COUNT(1) FROM group_goods_list WHERE action_id='".$key['id']."' AND is_show=1 AND start_time>'".time()."'";
	        $show_sql = "SELECT COUNT(1) FROM group_goods_list WHERE action_id='".$key['id']."' AND is_show=0";
	        $list[$k]['start_num'] = $this->group->fetchColumn($sql);
	        $list[$k]['end_num'] = $this->group->fetchColumn($end_sql);
	        $list[$k]['soon_num'] = $this->group->fetchColumn($soon_sql);
	        $list[$k]['show_num'] = $this->group->fetchColumn($show_sql);
	    }
// 	    echo '<pre>'; print_r($list);exit;
	    $this->view->setVar('select', '');
	    $this->view->setVar('search', '');
	    $this->view->setVar('num', $count);
	    $this->view->setVar('start_num', $start_num);
	    $this->view->setVar('page', $page->show());
	    $this->view->setVar("list", $list);
	}
	//分站添加、编辑
	public function addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $city_code = trim($_POST['city_code']);
	        if(empty($city_code)){
	            $this->_message('请选择城市', 'group/add', false);
	        }
	        $city_name = $this->getCityName($city_code);
	        $banner_img = trim($_POST['banner_img']);
	        $banner_url = trim($_POST['banner_url']);
	        foreach ($_POST['class_id'] as $k=>$key){
	            if($key != 0){
	                $class_arr[] = $key;
	            }
	        }
	        $class_id = implode(',', $class_arr);
	        $phone = trim($_POST['phone']);
	        $email = trim($_POST['email']);
	        $work_info = trim($_POST['work_info']);
	        $is_open = $_POST['is_open'];
	        
	        if(empty($id)){
	            $sql = "INSERT INTO group_list (city_name, city_code, banner_img, banner_url, class_id, phone, email, work_info, is_open, add_time) VALUES('".$city_name."','".$city_code."','".$banner_img."','".$banner_url."','".$class_id."','".$phone."','".$email."','".$work_info."','".$is_open."','".time()."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功！', 'group/index', true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', 'group/index', false);
	            }
	        } else {
	            $sql = "UPDATE group_list SET city_name='".$city_name."',city_code='".$city_code.
	                   "',banner_img='".$banner_img."',banner_url='".$banner_url."',class_id='".$class_id."',phone='".$phone.
	                   "',email='".$email."',work_info='".$work_info."',is_open='".$is_open.
	                   "' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', 'group/index', true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', 'group/index', false);
	            }
	        }
	        
	    } else {
	        $sql = "SELECT * FROM group_city_list";
	        $data = $this->group->fetchAll($sql);
	        $this->view->setVar("city_list", $data);
	         
	        //分类
	        $sql = "SELECT * FROM group_class_list";
	        $class_list = $this->group->fetchAll($sql);
	        $this->view->setVar("class_list", $class_list);
	        
	        $id = $this->dispatcher->getParam(1);
	        if($id){
	            $sql = "SELECT * FROM group_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $class_id = explode(',', $data['class_id']);
	            $this->view->setVar("class_id", $class_id);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	//根据城市code获取城市名称
	public function getCityName($city_code){
	    $sql = "SELECT city_name FROM group_city_list WHERE city_code='".$city_code."'";
	    $data = $this->group->fetchOne($sql);
	    return $data['city_name'];
	}
	//分站删除
	public function deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    if($id){
	        $sql = "DELETE FROM group_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        $this->_message('操作成功', 'group/index', true);
	    } else {
	        $this->_message('非法操作', 'group/index', false);
	    }
	}
	
	/**
	 * 商品管理
	 */
	public function goods_listAction(){
	    $action_id = $this->dispatcher->getParam(0);
	    $city = $this->dispatcher->getParam(1);
	    $this->view->setVar("city", $city);
	    $this->view->setVar("act_id", $action_id);
	    
	    //分类
	    $sql = "SELECT * FROM group_class_list";
	    $class_list = $this->group->fetchAll($sql);
	    foreach ($class_list as $k => $key){
	        $class_list_arr[$key['id']] = $key['class_name'];
	    }
	    $this->view->setVar("class_list_arr", $class_list_arr);
	    //品牌
	    $sql = "SELECT * FROM group_brand_list";
	    $brand_list = $this->group->fetchAll($sql);
	    foreach ($brand_list as $k => $key){
	        $brand_list_arr[$key['id']] = $key['name'];
	    }
	    $this->view->setVar("brand_list_arr", $brand_list_arr);
	    
	    $sql = "SELECT COUNT(1) FROM group_goods_list WHERE action_id=".$action_id;
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM group_goods_list WHERE action_id=".$action_id." ORDER BY add_time LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	//添加/编辑
	public function goods_addAction(){
	    $act_id = $this->dispatcher->getParam(0);
	    $city = $this->dispatcher->getParam(1);
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $action_id         = $act_id;
	        $goods_name        = trim($_POST['goods_name']);
	        $class_id          = trim($_POST['class_id']);
	        $brand_id          = trim($_POST['brand_id']);
	        $sale_address      = trim($_POST['sale_address']);
	        $stock             = trim($_POST['stock']);
	        $sold_num          = trim($_POST['sold_num']);
	        $market_price      = trim($_POST['market_price']);
	        $exclusive_price   = trim($_POST['exclusive_price']);
	        $order_price       = trim($_POST['order_price']);
	        $service           = trim($_POST['service']);
	        $sort              = trim($_POST['sort']);
	        $limit_number      = trim($_POST['limit_number']);
	        $start_time        = strtotime(trim($_POST['start_time']));
	        $end_time          = strtotime(trim($_POST['end_time']));
	        $desc              = $_POST['desc'];
	        $notice            = $_POST['notice'];
	        $specification     = $_POST['specification'];
	        $guarantee         = $_POST['guarantee'];
	        $is_site           = $_POST['is_site'];
	        $is_show           = $_POST['is_show'];
	        $thumb_img 	= $_POST['thumb_img'];
	        foreach ($_POST['goods_img'] as $k=>$key){
	            if($key != ''){
	                $goods_arr[] = $key;
	            }
	        }
	        foreach ($_POST['discount'] as $k=>$key){
	            if($key != 0){
	                $discount_arr[] = $key;
	            }
	        }
	        foreach ($_POST['store'] as $k=>$key){
	            if($key != 0){
	                $store_arr[] = $key;
	            }
	        }
	        $goods_img = implode(',', $goods_arr);
	        $discount = implode(',', $discount_arr);
	        $store = implode(',', $store_arr);
	        if($service == 1 && $order_price != $exclusive_price){
    	       $this->_message('物流配送类的产品应付全款（预购价与专享价相同）', '', false);
	        }
	        if(empty($id)){
	            $sql = "INSERT INTO group_goods_list (".
	                   "action_id, goods_name, goods_img, class_id, brand_id, sale_address, stock, sold_num,".
	                   "market_price, exclusive_price, order_price, limit_number, service, sort, start_time, end_time,".
	                   " goods_desc, notice, specification, guarantee, discount_id, store_id, is_site, add_time, is_show,thumb_img".
	                   ") VALUES('".$action_id."','".$goods_name."','".$goods_img."','".$class_id."','".$brand_id."','".$sale_address."','"
	                   .$stock."','".$sold_num."','".$market_price."','".$exclusive_price."','".$order_price."','".$limit_number."','".$service."','"
	                   .$sort."','".$start_time."','".$end_time."','".$desc."','".$notice."','".$specification."','".$guarantee."','".$discount."','".$store."','".$is_site."','".time()."','".$is_show."','".$thumb_img."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功', "group/goods_list/$act_id/$city", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/goods_list", false);
	            }
	        } else {
	            $sql = "UPDATE group_goods_list SET action_id='".$action_id."',goods_name='".$goods_name."',goods_img='".$goods_img.
	                   "',class_id='".$class_id."',brand_id='".$brand_id."',sale_address='".$sale_address.
	                   "',stock='".$stock."',sold_num='".$sold_num."',market_price='".$market_price.
	                   "',exclusive_price='".$exclusive_price."',order_price='".$order_price."',limit_number='".$limit_number."',service='".$service."',sort='".$sort.
	                   "',start_time='".$start_time."',end_time='".$end_time."',goods_desc='".$desc."',notice='".$notice."',specification='".$specification."',guarantee='".$guarantee.
	                   "',discount_id='".$discount."',store_id='".$store."',is_site='".$is_site."',is_show='".$is_show."',thumb_img='".$thumb_img.
	                   "' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', "group/goods_list/$act_id/$city", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/goods_list", false);
	            }
	        }
	    } else {
	        $this->view->setVar("act_id", $act_id);
	        $this->view->setVar("city", $city);
	        
	        //分类
	        $sql = "SELECT class_id FROM group_list WHERE id=".$act_id;
	        $class_id = $this->group->fetchOne($sql);
	        if(!$class_id['class_id']){
	            $headr_url = "http://".$_SERVER['HTTP_HOST']."/admin/group/add/id/".$act_id;
	            header("location: $headr_url");exit;
	            exit;
	        }
	        $sql = "SELECT * FROM group_class_list WHERE id IN(".$class_id['class_id'].")";
	        $class_list = $this->group->fetchAll($sql);
	        $this->view->setVar("class_list", $class_list);
	        
	        //品牌
	        $sql = "SELECT * FROM group_brand_list";
	        $brand_list = $this->group->fetchAll($sql);
	        $this->view->setVar("brand_list", $brand_list);
	        
	        //优惠信息
	        $sql = "SELECT * FROM group_discount_list";
	        $discount_list = $this->group->fetchAll($sql);
	        $this->view->setVar("discount_list", $discount_list);
	        
	        //商户信息
	        $sql = "SELECT * FROM group_store_list";
	        $store_list = $this->group->fetchAll($sql);
	        $this->view->setVar("store_list", $store_list);
	        
	        $id = $this->dispatcher->getParam(2);
	        if($id){
	            $sql = "SELECT * FROM group_goods_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $discount = explode(',',$data['discount_id']);
	            $store = explode(',',$data['store_id']);
	            $goods_img = explode(',',$data['goods_img']);
	            
	            $this->view->setVar("discount", $discount);
	            $this->view->setVar("store", $store);
	            $this->view->setVar("goods_img", $goods_img);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	public function goods_deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    $act_id = $this->dispatcher->getParam(3);
	    $city = $this->dispatcher->getParam(2);
	    if($id){
	        $sql = "DELETE FROM group_goods_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        $this->_message('操作成功', "group/goods_list/$act_id/$city", true);
	    } else {
	        $this->_message('非法操作', "group/goods_list", false);
	    }
	}
	
	/**
	 * 城市管理
	 */
	public function city_indexAction(){
	    
	    $sql = "SELECT COUNT(1) FROM group_city_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM group_city_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	
	//城市站添加/编辑
	public function city_addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $city_name = trim($_POST['city_name']);
	        $city_code = trim($_POST['city_code']);
	        $lng = trim($_POST['lng']);
	        $lat = trim($_POST['lat']);
	        $isRemove = $_POST['isRemove'];
	        if(empty($id)){
	            $sql = "INSERT INTO group_city_list (city_name, city_code, lng, lat, add_time) VALUES('".$city_name."','".$city_code."','".$lng."','".$lat."','".time()."')";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId){
                    $this->_message('操作成功', "group/city_index", true);
                } else {
                    $this->_message('系统繁忙，请稍后重试', "group/city_index", false);
                }
	        } else {
	            $sql = "UPDATE group_city_list SET city_name='".$city_name."',city_code='".$city_code."',lng='".$lng."',lat='".$lat."' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', "group/city_index", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/city_index", false);
	            }
	        }
	    } else {
	        $id = $this->dispatcher->getParam(1);
	        if($id){
	            $sql = "SELECT * FROM group_city_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	
	public function city_deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    if($id){
	        $sql = "DELETE FROM group_city_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        $this->_message('操作成功', "group/city_index", true);
	    } else {
	        $this->_message('非法操作', "group/city_index", false);
	    }
	}
	
	
	/**
	 * 品牌管理
	 */
	
	public function brand_listAction(){
	    
	    $sql = "SELECT COUNT(1) FROM group_brand_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM group_brand_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	//添加、编辑
	public function brand_addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $name = trim($_POST['name']);
	        $img_url = trim($_POST['img_url']);
	        if(empty($id)){
	            $sql = "INSERT INTO group_brand_list (name, img_url, add_time) VALUES('".$name."','".$img_url."','".time()."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功', "group/brand_list", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/brand_list", false);
	            }
	        } else {
	            $sql = "UPDATE group_brand_list SET name='".$name."',img_url='".$img_url."' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', "group/brand_list", true);
	            } else {
	                 $this->_message('系统繁忙，请稍后重试', "group/brand_list", false);
	            }
	        }
	    } else {
	        $id = $this->dispatcher->getParam(1);
	        if($id){
	            $sql = "SELECT * FROM group_brand_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	
	/**
	 * 商品分类管理
	 */
	
	public function class_listAction(){
	    $sql = "SELECT COUNT(1) FROM group_class_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    $sql = "SELECT * FROM group_class_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	//商品分类添加、编辑
	public function class_addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $class_name = trim($_POST['class_name']);
	        if(empty($id)){
	            $sql = "INSERT INTO group_class_list (class_name, add_time) VALUES('".$class_name."','".time()."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功', "group/class_list", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/class_list", false);
	            }
	        } else {
	            $sql = "UPDATE group_class_list SET class_name='".$class_name."' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', "group/class_list", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/class_list", false);
	            }
	        }
	    } else {
	        $id = $this->dispatcher->getParam(1);
	        if($id){
	            $sql = "SELECT * FROM group_class_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	
	/**
	 * 订单列表
	 */
	public function order_listAction(){
	    
	    $this->session->set('select','');
	    $this->session->set('search','');
	    $this->session->set('end_search','');
	    
	    $sql = "SELECT COUNT(1) FROM ecs_order_info WHERE from_id=5";
	    $count = $this->upin->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM ecs_order_info WHERE from_id=5 ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->upin->fetchAll($sql);
	    foreach ($data as $k => $key){
	        $sql = "SELECT goods_name,goods_id FROM ecs_order_goods WHERE order_id='".$key['order_id']."'";
	        $goods_info = $this->upin->fetchOne($sql);
	        
	        $sql = "SELECT action_id FROM group_goods_list WHERE id='".$goods_info['goods_id']."'";
	        $action_id = $this->group->fetchOne($sql);
	        
	        $sql = "SELECT city_name FROM group_list WHERE id='".$action_id['action_id']."'";
	        $city_name = $this->group->fetchOne($sql);
	        
	        $sql = "SELECT phone FROM ecs_users WHERE user_id='".$key['user_id']."'";
	        $phone = $this->upin->fetchOne($sql);
	        
	        $data[$k]['goods_name'] = $goods_info['goods_name'];
	        $data[$k]['city_name'] = $city_name['city_name'];
	        $data[$k]['phone'] = $phone['phone'];
	        
	        if($key['province']){
    	        $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['province']."'";
    	        $province = $this->upin->fetchOne($sql);
    	        $data[$k]['province'] = $province['region_name'];
	        } else {
	            $data[$k]['province'] = '';
	        }
	        if($key['city']){
    	        $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['city']."'";
    	        $city = $this->upin->fetchOne($sql);
    	        $data[$k]['city'] = $city['region_name'];
	        }
	        if($key['district']){
    	        $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['district']."'";
    	        $district = $this->upin->fetchOne($sql);
    	        $data[$k]['district'] = $district['region_name'];
	        }
	    }
// 	    echo "<pre>";print_r($data);exit;
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	
	public function order_deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    if($id){
	        $sql = "DELETE FROM ecs_order_info WHERE order_id='".$id."'";
	        $data = $this->upin->execute($sql);
	        
	        $sql = "DELETE FROM ecs_order_goods WHERE order_id='".$id."'";
	        $data = $this->upin->execute($sql);
	        $this->_message('操作成功', "group/order_list", true);
	    } else {
	        $this->_message('非法操作', "group/order_list", false);
	    }
	}
	
	/**
	 * 优惠信息管理
	 */
	public function discount_listAction(){
	    $sql = "SELECT COUNT(1) FROM group_discount_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    $sql = "SELECT * FROM group_discount_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	public function discount_addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $keyword = trim($_POST['keyword']);
	        $info = trim($_POST['info']);
	        $details = trim($_POST['details']);
	        if(empty($id)){
	            $sql = "INSERT INTO group_discount_list (keyword, info, details, add_time) VALUES('".$keyword."','".$info."','".$details."','".time()."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功', "group/discount_list", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/discount_list", false);
	            }
	        } else {
	            $sql = "UPDATE group_discount_list SET keyword='".$keyword."',info='".$info."',details='".$details."' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
	                $this->_message('操作成功', "group/discount_list", true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试', "group/discount_list", false);
	            }
	        }
	    } else {
	        $id = $this->dispatcher->getParam(0);
	        if($id){
	            $sql = "SELECT * FROM group_discount_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	public function discount_deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    if($id){
	        $sql = "DELETE FROM group_discount_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        $this->_message('操作成功', "group/discount_list", true);
	    } else {
	        $this->_message('非法操作', "group/discount_list", false);
	    }
	}
	
	/**
	 * 门店管理
	 */
	public function store_listAction(){
	    $sql = "SELECT COUNT(1) FROM group_store_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    $sql = "SELECT * FROM group_store_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	public function store_addAction(){
	    if($this->request->isPost() == true){
	        $id = $_POST['id'];
	        $name = trim($_POST['name']);
	        $address = trim($_POST['address']);
	        $phone = trim($_POST['phone']);
	        $qq = trim($_POST['qq']);
	        $map_url = trim($_POST['map_url']);
	        if(empty($id)){
	            $sql = "INSERT INTO group_store_list (name, address, phone, qq, map_url, add_time) VALUES('".$name."','".$address."','".$phone."','".$qq."','".$map_url."','".time()."')";
	            $this->group->execute($sql);
	            $resultId = $this->group->lastInsertId();
	            if($resultId){
	                $this->_message('操作成功!', 'group/store_list', true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试！', 'group/store_list', false);
	            }
	        } else {
	            $sql = "UPDATE group_store_list SET name='".$name."',address='".$address."',phone='".$phone."',qq='".$qq."',map_url='".$map_url."' WHERE id='".$id."'";
	            $result = $this->group->execute($sql);
	            if($result){
                    $this->_message('操作成功!', 'group/store_list', true);
	            } else {
	                $this->_message('系统繁忙，请稍后重试！', 'group/store_list', false);
	            }
	        }
	    } else {
	        $id = $this->dispatcher->getParam(0);
	        if($id){
	            $sql = "SELECT * FROM group_store_list WHERE id='".$id."'";
	            $data = $this->group->fetchOne($sql);
	            $this->view->setVar("data", $data);
	        }
	    }
	}
	public function store_deleteAction(){
	    $id = $this->dispatcher->getParam(1);
	    if($id){
	        $sql = "DELETE FROM group_store_list WHERE id='".$id."'";
	        $data = $this->group->execute($sql);
	        $this->_message('操作成功!', 'group/store_list', true);
	    } else {
	        $this->_message('非法操作!', 'group/store_list', false);
	    }
	}
	
	/**
	 * 短信提醒
	 */
	public function message_listAction(){
	    $sql = "SELECT COUNT(1) FROM group_message_list";
	    $count = $this->group->fetchColumn($sql);
	    $page = new \Library\Com\Page($count, 10);
	    
	    $sql = "SELECT * FROM group_message_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $data = $this->group->fetchAll($sql);
	    foreach ($data as $k => $key){
	        $sql = "SELECT city_name FROM group_list WHERE id='".$key['action_id']."'";
	        $action_info = $this->group->fetchOne($sql);
	        $data[$k]['city_name'] = $action_info['city_name'];
	        
	        $sql = "SELECT goods_name FROM group_goods_list WHERE id='".$key['goods_id']."'";
	        $goods_info = $this->group->fetchOne($sql);
	        $data[$k]['goods_name'] = $goods_info['goods_name'];
	    }
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $data);
	}
	
	/**
	 * 搜索
	 */
	
	public function searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
            $search = $this->request->getPost("search");
            $where = $select."='".$search."'";
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $where = $select."='".$search."'";
	    }
	     
	    $sql = "SELECT COUNT(1) FROM group_list WHERE ".$where;
	    $count = $this->group->fetchColumn($sql);
	
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM group_list WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->pick("group/index");
	}
	
	public function brand_searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        $search = $this->request->getPost("search");
	        $where = $select." like '%".$search."%'";
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $where = $select."like '%".$search."%'";
	    }
	
	    $sql = "SELECT COUNT(1) FROM group_brand_list WHERE ".$where;
	    $count = $this->group->fetchColumn($sql);
	
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM group_brand_list WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->pick("group/brand_list");
	}
	
	public function discount_searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        $search = $this->request->getPost("search");
	        if($select == 'info'){
	            $where = $select." like '%".$search."%'";
	        } else {
	            $where = $select."='".$search."'";
	        }
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        if($select == 'info'){
	            $where = $select." like '%".$search."%'";
	        } else {
	            $where = $select."='".$search."'";
	        }
	    }
	
	    $sql = "SELECT COUNT(1) FROM group_discount_list WHERE ".$where;
	    $count = $this->group->fetchColumn($sql);
	
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM group_discount_list WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->pick("group/discount_list");
	}
	
	public function store_searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        $search = $this->request->getPost("search");
	        $where = $select." like '%".$search."%'";
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $where = $select."like '%".$search."%'";
	    }
	
	    $sql = "SELECT COUNT(1) FROM group_store_list WHERE ".$where;
	    $count = $this->group->fetchColumn($sql);
	
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM group_store_list WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->pick("group/store_list");
	}
	
	public function city_searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        $search = $this->request->getPost("search");
	        $where = $select." like '%".$search."%'";
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $where = $select."like '%".$search."%'";
	    }
	
	    $sql = "SELECT COUNT(1) FROM group_city_list WHERE ".$where;
	    $count = $this->group->fetchColumn($sql);
	    
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM group_city_list WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->group->fetchAll($list_sql);
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->pick("group/city_index");
	}
	
	public function order_list_searchAction(){
	
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        if($select == 'add_time'){
	            $search = $this->request->getPost("time");
	            $end_search = $this->request->getPost("end_time");
	            $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($end_search)+86400);
	        } else {
	            $search = $this->request->getPost("search");
	            $where = $select."='".$search."'";
	        }
	        $this->session->set('select',$select);
	        $this->session->set('search',$search);
	        $this->session->set('end_search',$end_search);
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $end_search = $this->session->get('end_search');
	        if($select == 'add_time'){
	            $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($end_search)+86400);
	        } else {
	            $where = $select."='".$search."'";
	        }
	    }
	    $sql = "SELECT COUNT(1) FROM ecs_order_info WHERE from_id=5 AND ".$where;
	    $count = $this->upin->fetchColumn($sql);
	
	    $page = new \Library\Com\Page($count, 10);
	    $list_sql = "SELECT * FROM ecs_order_info WHERE from_id=5 AND ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
	    $list = $this->upin->fetchAll($list_sql);
	    
	    foreach ($list as $k => $key){
	        $sql = "SELECT goods_name,goods_id FROM ecs_order_goods WHERE order_id='".$key['order_id']."'";
	        $goods_info = $this->upin->fetchOne($sql);
	         
	        $sql = "SELECT action_id FROM group_goods_list WHERE id='".$goods_info['goods_id']."'";
	        $action_id = $this->group->fetchOne($sql);
	         
	        $sql = "SELECT city_name FROM group_list WHERE id='".$action_id['action_id']."'";
	        $city_name = $this->group->fetchOne($sql);
	         
	        $sql = "SELECT phone FROM ecs_users WHERE user_id='".$key['user_id']."'";
	        $phone = $this->upin->fetchOne($sql);
	         
	        $list[$k]['goods_name'] = $goods_info['goods_name'];
	        $list[$k]['city_name'] = $city_name['city_name'];
	        $list[$k]['phone'] = $phone['phone'];
	         
	        if($key['province']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['province']."'";
	            $province = $this->upin->fetchOne($sql);
	            $list[$k]['province'] = $province['region_name'];
	        } else {
	            $list[$k]['province'] = '';
	        }
	        if($key['city']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['city']."'";
	            $city = $this->upin->fetchOne($sql);
	            $list[$k]['city'] = $city['region_name'];
	        }
	        if($key['district']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['district']."'";
	            $district = $this->upin->fetchOne($sql);
	            $list[$k]['district'] = $district['region_name'];
	        }
	    }
	    
	    $this->view->setVar('page',$page->show());
	    $this->view->setVar("list", $list);
	
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->setVar('end_search', $end_search);
	    $this->view->pick("group/order_list");
	}
	
	//数据统计
	public function data_statisticAction(){
	    
	    $type = $this->dispatcher->getParam(0);
	    
	    if($this->request->isPost() == true){
	        $select = $this->request->getPost("select");
	        $search = $this->request->getPost("search");
	        if($search){
	            $where = $select."='".$search."'";
	        } else {
	            $where = '1';
	        }
	        $start_time = $this->request->getPost("start_time");
	        $end_time = $this->request->getPost("end_time");
	        if($start_time){
	            $end_time = empty($end_time) ? $start_time : $end_time;
	            $and = ' AND add_time >= '.strtotime($start_time).' AND add_time < '.(strtotime($end_time)+86400);
	        } else {
	            $and = '';
	        }
	        $where = $where.$and;
	    } else {
	        $where = 1;
	    }
	   
	    if(empty($type) || $type == 'goods'){
	        
	        $sql = "SELECT goods_id,goods_name,COUNT(goods_id) AS num FROM group_goods_budian WHERE ".$where." GROUP BY goods_id";
	        $list = $this->group->fetchAll($sql);
	        
	        foreach ($list as $k => $key){
	            $btn_sql = "SELECT COUNT(1) FROM group_message_list WHERE ".$where." AND goods_id=".$key['goods_id'];
	            $btn_num = $this->group->fetchColumn($btn_sql);
	            
	            $buy_sql = "SELECT COUNT(1) FROM group_buy_budian WHERE ".$where." AND goods_id=".$key['goods_id'];
	            $buy_num = $this->group->fetchColumn($buy_sql);
	            
	            $order_sql = "SELECT COUNT(1) FROM ecs_order_info WHERE ".$where." AND order_id IN (SELECT order_id FROM ecs_order_goods WHERE goods_id = ".$key['goods_id'].") AND from_id = 5";
	            $order_num = $this->upin->fetchColumn($order_sql);
	             
	            $pay_sql = "SELECT COUNT(1) FROM ecs_order_info WHERE ".$where." AND order_id IN (SELECT order_id FROM ecs_order_goods WHERE goods_id = ".$key['goods_id'].") AND from_id = 5 AND pay_status=2";
	            $pay_num = $this->upin->fetchColumn($pay_sql);
	             
	            $list[$k]['but_click_num'] = $btn_num;
	            $list[$k]['buy_num'] = $buy_num;
	            $list[$k]['order_num'] = $order_num;
	            $list[$k]['pay_num'] = $pay_num;
	        }
	        
	    } else if($type == 'city'){
	        
	        $sql = "SELECT city_code,city_name FROM group_city_list";
	        $list = $this->group->fetchAll($sql);
	        
	        foreach ($list as $k => $key){
	            
	            $goods_sql = "SELECT COUNT(1) FROM group_goods_budian WHERE ".$where." AND city_code='".$key['city_code']."'";
	            $goods_num = $this->group->fetchColumn($goods_sql);
	            
	            $buy_sql = "SELECT COUNT(1) FROM group_buy_budian WHERE ".$where." AND city_code='".$key['city_code']."'";
	            $buy_num = $this->group->fetchColumn($buy_sql);
	            
	            $msg_sql = "SELECT COUNT(1) FROM group_message_list WHERE ".$where." AND city_code='".$key['city_code']."'";
	            $msg_num = $this->group->fetchColumn($msg_sql);
	        
	            $order_sql = "SELECT COUNT(1) FROM group_order_budian WHERE ".$where." AND city_code='".$key['city_code']."'";
	            $order_num = $this->group->fetchColumn($order_sql);
	        
	            $order_sql = "SELECT order_id FROM group_order_budian WHERE ".$where." AND city_code = '".$key['city_code']."'";
	            $order_id = $this->group->fetchAll($order_sql);
	            foreach ($order_id as $_k => $_key){
	                $order_array[$k][] = $_key['order_id'];
	            }
	            if($order_array[$k]){
	                $order_arr = implode(',', $order_array[$k]);
    	            $pay_sql = "SELECT COUNT(1) FROM ecs_order_info WHERE ".$where." AND order_id IN (".$order_arr.") AND from_id = 5 AND pay_status=2";
    	            $pay_num = $this->upin->fetchColumn($pay_sql);
	            } else {
					$pay_num = 0;
				}
	            
	            $list[$k]['goods_num'] = $goods_num;
	            $list[$k]['buy_num'] = $buy_num;
	            $list[$k]['msg_num'] = $msg_num;
	            $list[$k]['order_num'] = $order_num;
	            $list[$k]['pay_num'] = $pay_num;
	        }
// 	        echo '<pre>';print_r($list);exit;
	    } else {
	        
	        $sql = "SELECT url_source,COUNT(url_source) AS num FROM group_goods_budian WHERE ".$where." GROUP BY url_source";
	        $list = $this->group->fetchAll($sql);

	        foreach ($list as $k => $key){
	            if($key['url_source']){
	                if($key['url_source'] == 'timeline'){
	                    $tip = '（朋友圈）';
	                } else if($key['url_source'] == 'groupmessage'){
	                    $tip = '（微信群组）';
	                } else if($key['url_source'] == 'singlemessage'){
	                    $tip = '（微信好友）';
	                } else {
	                    $tip = '';
	                }
	                $list[$k]['url_source'] = $key['url_source'].$tip;
	            } else {
	                $list[$k]['url_source'] = '未定义 from 参数';
	            }
	            
	            $goods_sql = "SELECT COUNT(1) FROM group_goods_budian WHERE ".$where." AND url_source='".$key['url_source']."'";
	            $goods_num = $this->group->fetchColumn($goods_sql);
	             
	            $buy_sql = "SELECT COUNT(1) FROM group_buy_budian WHERE ".$where." AND url_source='".$key['url_source']."'";
	            $buy_num = $this->group->fetchColumn($buy_sql);
	            
	            $msg_sql = "SELECT COUNT(1) FROM group_message_list WHERE ".$where." AND url_source='".$key['url_source']."'";
	            $msg_num = $this->group->fetchColumn($msg_sql);
	            
	            $order_sql = "SELECT COUNT(1) FROM group_order_budian WHERE ".$where." AND url_source='".$key['url_source']."'";
	            $order_num = $this->group->fetchColumn($order_sql);
	             
	            $order_sql = "SELECT order_id FROM group_order_budian WHERE ".$where." AND url_source = '".$key['url_source']."'";
	            $order_id = $this->group->fetchAll($order_sql);
	            foreach ($order_id as $_k => $_key){
	                $order_array[$k][] = $_key['order_id'];
	            }
	            if($order_array[$k]){
	                $order_arr = implode(',', $order_array[$k]);
	                $pay_sql = "SELECT COUNT(1) FROM ecs_order_info WHERE ".$where." AND order_id IN (".$order_arr.") AND from_id = 5 AND pay_status=2";
	                $pay_num = $this->upin->fetchColumn($pay_sql);
	            } else {
					$pay_num = 0;
				}
	            $list[$k]['goods_num'] = $goods_num;
	            $list[$k]['buy_num'] = $buy_num;
	            $list[$k]['msg_num'] = $msg_num;
	            $list[$k]['order_num'] = $order_num;
	            $list[$k]['pay_num'] = $pay_num;
	        }
	    }

	    $this->view->setVar('type', $type);
	    $this->view->setVar('select', $select);
	    $this->view->setVar('search', $search);
	    $this->view->setVar('start_time', $start_time);
	    $this->view->setVar('end_time', $end_time);
	    $this->view->setVar('list', $list);
	}
	
	
	/**
	 * 导出XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public function order_list_xlsAction(){
	    
	    $type = $this->dispatcher->getParam(0);
	    if($type){
	        $where = '1';
	    } else {
	        $select = $this->session->get('select');
	        $search = $this->session->get('search');
	        $end_search = $this->session->get('end_search');
	        if(!empty($select) && !empty($search)){
	            if($select == 'add_time'){
	                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($end_search)+86400);
	            } else {
	                $where = $select."='".$search."'";
	            }
	        } else {
	            $where = '1';
	        }
	    }
	    
	    $list_sql = "SELECT * FROM ecs_order_info WHERE from_id=5 AND ".$where." ORDER BY add_time DESC";
	    $list = $this->upin->fetchAll($list_sql);
	    
	    foreach ($list as $k => $key){
	        $sql = "SELECT goods_name,goods_id FROM ecs_order_goods WHERE order_id='".$key['order_id']."'";
	        $goods_info = $this->upin->fetchOne($sql);
	         
	        $sql = "SELECT action_id FROM group_goods_list WHERE id='".$goods_info['goods_id']."'";
	        $action_id = $this->group->fetchOne($sql);
	         
	        $sql = "SELECT city_name FROM group_list WHERE id='".$action_id['action_id']."'";
	        $city_name = $this->group->fetchOne($sql);
	        
	        $sql = "SELECT phone FROM ecs_users WHERE user_id='".$key['user_id']."'";
	        $phone = $this->upin->fetchOne($sql);
	        
	        if($key['province']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['province']."'";
	            $province = $this->upin->fetchOne($sql);
	        }
	        if($key['city']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['city']."'";
	            $city = $this->upin->fetchOne($sql);
	        }
	        if($key['district']){
	            $sql = "SELECT region_name FROM ecs_region WHERE region_id='".$key['district']."'";
	            $district = $this->upin->fetchOne($sql);
	        }
	        
	        
	        $id = $key['order_id'];
	        $user_id = $key['user_id'];
	        $phone = $phone['phone'];
	        $transaction_id = $key['transaction_id'];
	        $order_sn = $key['order_sn'];
	        $city_name = $city_name['city_name'];
	        $goods_name = $goods_info['goods_name'];
	        $goods_amount = $key['goods_amount'];
	        $order_amount = $key['order_amount'];
	        $money_paid = $key['money_paid'];
	        $pay_name = $key['pay_name'];
	        $consignee = $key['consignee'];//收货人
	        $address = $province['region_name'].$city['region_name'].$district['region_name'].$key['address'];//收货地址
	        $mobile = $key['mobile'];//联系方式
	        if($key['is_separate'] == 1){
	            $is_separate = '已付余款';
	        }elseif($key['is_separate'] == 2){
	            $is_separate = '交易失败';
	        }else{
	            $is_separate = '';
	        }
	        $referer = $key['referer'];
	        $shipping_time = empty($key['shipping_time']) ? '' : date('Y-m-d H:i:s', $key['shipping_time']);
	        $add_time = empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']);
	        $pay_time = empty($key['pay_time']) ? '未支付' : date('Y-m-d H:i:s', $key['pay_time']);
	        
	        $str_r .= '<Row><Cell><Data ss:Type="String">'.$id.'</Data></Cell>'.
	   	               '<Cell><Data ss:Type="String">'.$user_id.'</Data></Cell>'.
	   	               '<Cell><Data ss:Type="String">'.$phone.'</Data></Cell>'.
	   	               '<Cell><Data ss:Type="String">'.$transaction_id.'</Data></Cell>'.
	   	               '<Cell><Data ss:Type="String">'.$order_sn.'</Data></Cell>'.
	   	               '<Cell><Data ss:Type="String">'.$city_name.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$goods_name.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$goods_amount.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$order_amount.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$money_paid.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$pay_name.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$is_separate.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$referer.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$consignee.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$address.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$mobile.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$shipping_time.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$add_time.'</Data></Cell>'.
                       '<Cell><Data ss:Type="String">'.$pay_time.'</Data></Cell></Row>';
	        
	    }

	    $str = '<?xml version="1.0" encoding="UTF-8"?>
                <?mso-application progid="Excel.Sheet"?>
                <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:c="urn:schemas-microsoft-com:office:component:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x2="http://schemas.microsoft.com/office/excel/2003/xml" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                  <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
                  </OfficeDocumentSettings>
                  <ss:Worksheet ss:Name="Sheet 1">
                    <Table>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
	                <Column ss:Width="50"/>
	                <Column ss:Width="50"/>
	                <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                	<Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                	<Column ss:Width="50"/>
                    <Column ss:Width="50"/>
                    <Row>
                      <Cell><Data ss:Type="String">ID</Data></Cell>
                      <Cell><Data ss:Type="String">用户ID</Data></Cell>
                      <Cell><Data ss:Type="String">账户注册（登录）手机号码</Data></Cell>
                      <Cell><Data ss:Type="String">支付单号</Data></Cell>
                      <Cell><Data ss:Type="String">订单号</Data></Cell>
                      <Cell><Data ss:Type="String">分站</Data></Cell>
                      <Cell><Data ss:Type="String">商品名称</Data></Cell>
                      <Cell><Data ss:Type="String">商品价格</Data></Cell>
                      <Cell><Data ss:Type="String">订单价格</Data></Cell>
                      <Cell><Data ss:Type="String">已付金额</Data></Cell>
                      <Cell><Data ss:Type="String">支付方式</Data></Cell>
                      <Cell><Data ss:Type="String">客户状态</Data></Cell>
                      <Cell><Data ss:Type="String">销售门店</Data></Cell>
	                  <Cell><Data ss:Type="String">收件人</Data></Cell>
        	          <Cell><Data ss:Type="String">收货地址</Data></Cell>
	                  <Cell><Data ss:Type="String">联系方式</Data></Cell>
                      <Cell><Data ss:Type="String">验证时间</Data></Cell>
                      <Cell><Data ss:Type="String">下单时间</Data></Cell>
                      <Cell><Data ss:Type="String">支付时间</Data></Cell>
                    </Row>'.$str_r.'</Table><x:WorksheetOptions/></ss:Worksheet></Workbook>';
	    
	    $filename = date('YmdHis').'.xls';
	    $this->funs_model->exportExcel($filename, $str);
	}
}
?>