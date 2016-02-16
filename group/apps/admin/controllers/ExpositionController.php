<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class ExpositionController extends ControllerBase {

    private $funs_model;
    private $point_model;
    private $location_model;

    public function initialize(){
        parent::initialize();
        $this->funs_model = new \Library\Com\Funs();
        $this->point_model = new \Library\Com\QxPoint();
        $this->location_model = new \Library\Com\Location();
    }

    //报名数据列表
    public function indexAction(){
        
        $this->session->set('select', '');
        $this->session->set('search', '');
        
        //数据列表
        $sql = "SELECT COUNT(*) FROM exposition";
        $count = $this->group->fetchOne($sql);

        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM exposition ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    }

    //预定数据列表
    public function SubscribeAction(){
        
        $this->session->set('select', '');
        $this->session->set('search', '');
        
        //数据列表
        $sql = "SELECT COUNT(*) AS num FROM exposition_subscribe";
        $count = $this->group->fetchOne($sql);

        $page = new \Library\Com\Page($count['num'], 10);
        $list_sql = "SELECT * FROM exposition_subscribe ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    }

	/**
	 * 导出XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public function bmtable_xlsAction(){

	    $select = $this->session->get('select');
	    $search = $this->session->get('search');
	    if(!empty($select) && !empty($search)){
	        if($select == 'add_time'){
	            $where = ' WHERE '.$select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
	        } else {
	            $where = ' WHERE '.$select."='".$search."'";
	        }
	    } else {
	        $where = '';
	    }

	    $str = "姓名\t手机号码\t区\t街道\t数据来源\tip地址\tip地址所属省市\t报名时间\t是否验证\t\n";
	    $str = iconv('utf-8','gb2312',$str);

	    $list_sql = "SELECT * FROM exposition ".$where." ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);

	    foreach ($list as $k => $key){
	        $name = iconv('utf-8','gb2312//IGNORE',$key['name']);
	        $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
	        $area = iconv('utf-8','gb2312//IGNORE',$key['area']);
	        $address = iconv('utf-8','gb2312//IGNORE',$key['address']);
	        $url_source = iconv('utf-8','gb2312//IGNORE',$key['url_source']);
	        $ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
	        $ip_address = iconv('utf-8','gb2312//IGNORE', empty($key['ip_address']) ? '未知' : $key['ip_address']);
	        $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
	        $state = iconv('utf-8','gb2312//IGNORE',empty($key['state']) ? '未验证' : '已验证');
	        $str .= $name."\t".$phone."\t".$area."\t".$address."\t".$url_source."\t".$ip."\t".$ip_address."\t".$verify_time."\t".$state."\t\n";
	    }
	    $filename = date('YmdHis').'.xls';
	    $this->funs_model->exportExcel($filename, $str);
	}

	/**
	 * 导出全部XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public function bmtable_allxlsAction(){

	    $str = "姓名\t手机号码\t区\t街道\t数据来源\tip地址\tip地址所属省市\t报名时间\t是否验证\t\n";
	    $str = iconv('utf-8','gb2312',$str);

	    $list_sql = "SELECT * FROM exposition ORDER BY add_time DESC";
	    $list = $this->group->fetchAll($list_sql);

	    foreach ($list as $k => $key){
	        $name = iconv('utf-8','gb2312//IGNORE',$key['name']);
	        $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
	        $area = iconv('utf-8','gb2312//IGNORE',$key['area']);
	        $address = iconv('utf-8','gb2312//IGNORE',$key['address']);
	        $url_source = iconv('utf-8','gb2312//IGNORE',$key['url_source']);
	        $ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
	        $ip_address = iconv('utf-8','gb2312//IGNORE', empty($key['ip_address']) ? '未知' : $key['ip_address']);
	        $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
	        $state = iconv('utf-8','gb2312//IGNORE',empty($key['state']) ? '未验证' : '已验证');
	        $str .= $name."\t".$phone."\t".$area."\t".$address."\t".$url_source."\t".$ip."\t".$ip_address."\t".$verify_time."\t".$state."\t\n";
	    }
	    $filename = date('YmdHis').'.xls';
	    $this->funs_model->exportExcel($filename, $str);
	}
	
    //搜索
    public function searchAction(){

        if($this->request->isPost() == true){
            $select = $this->request->getPost("select");
            if($select == 'time'){
                $select = 'add_time';
                $search = $this->request->getPost("time");
                if(empty($search)){
                    echo "请输入时间";exit;
                }
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $search = $this->request->getPost("search");
                $where = $select."='".$search."'";
            }
            $this->session->set('select', $select);
            $this->session->set('search', $search);
        } else {
            $select = $this->session->get('select');
            $search = $this->session->get('search');
            if($select == 'add_time'){
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $where = $select."='".$search."'";
            }
        }

        $sql = "SELECT COUNT(*) AS num FROM exposition WHERE ".$where;
        $count = $this->group->fetchOne($sql);


        $page = new \Library\Com\Page($count['num'], 10);
        $list_sql = "SELECT * FROM exposition WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);

        $this->view->setVar('select', $select);
        $this->view->setVar('search', $search);
        $this->view->pick("exposition/index");
    }
    
    //商品管理
    public function goods_listAction(){
        
        $sql = "SELECT COUNT(*) FROM exposition_goods_list";
        $count = $this->group->fetchOne($sql);
        $page = new \Library\Com\Page($count[0], 10);
         
        $sql = "SELECT * FROM exposition_goods_list ORDER BY add_time LIMIT ".$page->firstRow.','.$page->listRows;
        $data = $this->group->fetchAll($sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $data);
    }
    //添加/编辑
    public function goods_addAction(){
        
        if($this->request->isPost() == true){
            $id = $_POST['id'];
            $goods_name        = trim($_POST['goods_name']);
            $goods_img         = $_POST['goods_img'];
            $code_img          = $_POST['code_img'];
            $stock             = trim($_POST['stock']);
            $market_price      = trim($_POST['market_price']);
            $order_price       = trim($_POST['order_price']);
            $goods_info        = $_POST['goods_info'];
            $goods_type        = $_POST['goods_type'];
            $is_show           = $_POST['is_show'];
            
            if(empty($id)){
                $sql = "INSERT INTO exposition_goods_list (".
                    "goods_name, goods_img, stock,".
                    " market_price, order_price,".
                    " goods_info, code_img, goods_type, add_time, is_show".
                    ") VALUES('".$goods_name."','".$goods_img."','"
                    .$stock."','".$market_price."','".$order_price."','"
                    .$goods_info."','".$code_img."','".$goods_type."','".time()."','".$is_show."')";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId){
                    header("Location:/admin/exposition/goods_list");
                } else {
                    die('系统繁忙，请稍后重试！');
                }
            } else {
                $sql = "UPDATE exposition_goods_list SET goods_name='".$goods_name."',goods_img='".$goods_img.
                "',stock='".$stock."',market_price='".$market_price.
                "',order_price='".$order_price."',goods_info='".$goods_info."',code_img='".$code_img."',goods_type='".$goods_type.
                "',is_show='".$is_show.
                "' WHERE id='".$id."'";
                $result = $this->group->execute($sql);
                if($result){
                    header("Location:/admin/exposition/goods_list");
                } else {
                    die('系统繁忙，请稍后重试！');
                }
            }
        } else {
            $id = $this->dispatcher->getParam(0);
            if($id){
                $sql = "SELECT * FROM exposition_goods_list WHERE id='".$id."'";
                $data = $this->group->fetchOne($sql);
                $this->view->setVar("data", $data);
            }
        }
    }
    
    public function goods_deleteAction(){
        $id = $this->dispatcher->getParam(1);
        if($id){
            $sql = "DELETE FROM exposition_goods_list WHERE id='".$id."'";
            $data = $this->group->execute($sql);
            header("Location:/admin/exposition/goods_list");
        } else {
            die('非法操作');
        }
    }
}

?>