<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class BroadcastController extends ControllerBase {
    
    private $funs_model;
    private $point_model;
    private $location_model;
    
    public function initialize(){
        parent::initialize();
        $this->funs_model = new \Library\Com\Funs();
        $this->point_model = new \Library\Com\QxPoint();
        $this->location_model = new \Library\Com\Location();
    }
    
    public function indexAction(){
    }
    
    public function top_listAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM broadcast_top_list";
        $count = $this->group->fetchOne($sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM broadcast_top_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);

        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    }
    
    public function top_addAction(){
        if($this->request->isPost() == true){
           $content = trim($_POST['content']);
           
           $sql = "INSERT INTO broadcast_top_list (content, add_time) VALUES('".$content."','".time()."')";
           $this->group->execute($sql);
           $resultId = $this->group->lastInsertId();
           if($resultId){
               $ajax_result['errcode'] = 0;
               $ajax_result['errmsg'] = "添加成功！";
           } else {
               $ajax_result['errcode'] = 1003;
               $ajax_result['errmsg'] = "系统繁忙，请退出重试";
           }
           die(json_encode($ajax_result));
        }
    }
    
    public function top_delAction(){
        if($this->request->isPost() == true){
            $id = trim($_POST['id']);
            $sql = "DELETE FROM broadcast_top_list WHERE id=".$id;
            $this->group->execute($sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "删除成功！";
            die(json_encode($ajax_result));
        }
    }
    
    
    public function live_listAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM broadcast_live_list";
        $count = $this->group->fetchOne($sql);
    
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM broadcast_live_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
    
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    }
    
    public function live_addAction(){
        if($this->request->isPost() == true){
            $id = intval($_POST['id']);
            $keyword = trim($_POST['keyword']);
            $title = trim($_POST['title']);
            $desc = trim($_POST['desc']);
            $link = trim($_POST['link']);
            $add_time = strtotime(trim($_POST['add_time']));
            
            if(empty($id)){
                $sql = "INSERT INTO broadcast_live_list (`keyword`, `title`, `desc`, `link`, `add_time`) VALUES('".$keyword."','".$title."','".$desc."','".$link."','".$add_time."')";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "发布成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            } else {
                $sql = "UPDATE broadcast_live_list SET `keyword`='".$keyword."',`title`='".$title."',`desc`='".$desc."',`link`='".$link."',`add_time`='".$add_time."' WHERE id='".$id."'";
		        $result = $this->group->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "编辑成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            }
        }
    }
    public function live_editAction(){
        $id = $_GET['id'];
        $sql = "SELECT * FROM broadcast_live_list WHERE id=".$id;
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("data", $data);
        $this->view->pick("broadcast/live_add");
    }
    public function live_delAction(){
        if($this->request->isPost() == true){
            $id = trim($_POST['id']);
            $sql = "DELETE FROM broadcast_live_list WHERE id=".$id;
            $this->group->execute($sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "删除成功！";
            die(json_encode($ajax_result));
        }
    }
    
    
    public function news_listAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM broadcast_news_list";
        $count = $this->group->fetchOne($sql);
    
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM broadcast_news_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
    
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    }
    
    public function news_addAction(){
        if($this->request->isPost() == true){
            $id = intval($_POST['id']);
            $keyword = trim($_POST['keyword']);
            $title = trim($_POST['title']);
            $desc = trim($_POST['desc']);
            $link = trim($_POST['link']);
            $add_time = strtotime(trim($_POST['add_time']));
    
            if(empty($id)){
                $sql = "INSERT INTO broadcast_news_list (`keyword`, `title`, `desc`, `link`, `add_time`) VALUES('".$keyword."','".$title."','".$desc."','".$link."','".$add_time."')";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "发布成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            } else {
                $sql = "UPDATE broadcast_news_list SET `keyword`='".$keyword."',`title`='".$title."',`desc`='".$desc."',`link`='".$link."',`add_time`='".$add_time."' WHERE id='".$id."'";
                $result = $this->group->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "编辑成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            }
        }
    }
    public function news_editAction(){
        $id = $_GET['id'];
        $sql = "SELECT * FROM broadcast_news_list WHERE id=".$id;
        $data = $this->group->fetchOne($sql);
        $this->view->setVar("data", $data);
        $this->view->pick("broadcast/news_add");
    }
    public function news_delAction(){
        if($this->request->isPost() == true){
            $id = trim($_POST['id']);
            $sql = "DELETE FROM broadcast_news_list WHERE id=".$id;
            $this->group->execute($sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "删除成功！";
            die(json_encode($ajax_result));
        }
    }
    
    public function img_listAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM broadcast_img_list";
        $count = $this->group->fetchOne($sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM broadcast_img_list ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        
        $city_list = $this->city_listAction();
        $this->view->setVar("city_list", $city_list);
    }
    
    public function img_addAction(){
        if($this->request->isPost() == true){
            $id = intval($_POST['id']);
            $city = trim($_POST['city']);
            $img_url = trim($_POST['img_url']);
            $is_good = trim($_POST['is_good']);
            $add_time = time();
        
            if(empty($id)){
                $sql = "INSERT INTO broadcast_img_list (`city`, `img_url`, `is_good`, `add_time`) VALUES('".$city."','".$img_url."','".$is_good."','".$add_time."')";
                $this->group->execute($sql);
                $resultId = $this->group->lastInsertId();
                if($resultId){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "添加成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            } else {
                $sql = "UPDATE broadcast_img_list SET `city`='".$city."',`img_url`='".$img_url."',`is_good`='".$is_good."',`add_time`='".$add_time."' WHERE id='".$id."'";
                $result = $this->group->execute($sql);
                if($result){
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = "编辑成功！";
                } else {
                    $ajax_result['errcode'] = 1003;
                    $ajax_result['errmsg'] = "系统繁忙，请退出重试";
                }
                die(json_encode($ajax_result));
            }
        } else {
            $path = 'http://'.$_SERVER['HTTP_HOST'];
            $city_list = $this->city_listAction();
            //         echo "<pre>";print_r($city_list);exit;
            $this->view->setVar("city_list", $city_list);
            $this->view->setVar("path", $path);
        }
    }
    public function img_editAction(){
        $id = $_GET['id'];
        $sql = "SELECT * FROM broadcast_img_list WHERE id=".$id;
        $data = $this->group->fetchOne($sql);
        $city_list = $this->city_listAction();
        $this->view->setVar("city_list", $city_list);
        
        $this->view->setVar("data", $data);
        $this->view->pick("broadcast/img_add");
    }
    
    public function img_delAction(){
        if($this->request->isPost() == true){
            $id = trim($_POST['id']);
            $sql = "DELETE FROM broadcast_img_list WHERE id=".$id;
            $this->group->execute($sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "删除成功！";
            die(json_encode($ajax_result));
        }
    }
    
    public function city_listAction(){
        $city = array(
            0 => '天津',
            1 => '杭州',
            2 => '厦门',
            3 => '青岛',
            4 => '南昌',
            5 => '长沙',
            6 => '贵阳',
            7 => '武汉',
            8 => '西安',
            9 => '昆明',
            10 => '南京',
            11 => '哈尔滨',
            12 => '济南',
            13 => '太原',
            14 => '北京',
            15 => '东莞',
        );
        return $city;
    }
}

?>