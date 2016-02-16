<?php
namespace Apps\Pc\Controllers;

use Library\Com\Funs;

class QxzjController extends ControllerBase {
	
    public function indexAction(){
        //活动直播
        $sql = "SELECT * FROM broadcast_live_list";
        $list = $this->group->fetchAll($sql);
        foreach ($list as $k => $key){
            $time = date('Y-m-d',$key['add_time']);
            if($time == '2015-08-22' || $time == '2015-08-23' || $time == '2015-08-29'){
                $key['time'] = date('m/d H:i',$key['add_time']);
                $live_list[$time][] = $key;
            }
        }
//         echo "<pre>";print_r($live_list);exit;
        
        $this->view->setVar("live_list1", $live_list['2015-08-22']);
        $this->view->setVar("live_list2", $live_list['2015-08-23']);
        $this->view->setVar("live_list3", $live_list['2015-08-29']);
        
        
        //最新快讯
        $news_sql = "SELECT * FROM broadcast_news_list ORDER BY add_time DESC";
        $news_list = $this->group->fetchAll($news_sql);
        $this->view->setVar("news_list", $news_list);
//                 echo "<pre>";print_r($news_list);exit;
        
        //精彩瞬间
        $jc_sql = "SELECT * FROM broadcast_img_list WHERE is_good=1 ORDER BY add_time DESC";
        $jc_list = $this->group->fetchAll($jc_sql);
        
//                 echo "<pre>";print_r($jc_list);exit;
        
        $this->view->setVar("jc_list", $jc_list);
        
    }
    
    public function get_imgAction(){
        $city = $_POST['type'];
        $sql = "SELECT * FROM broadcast_img_list WHERE city='".$city."' ORDER BY add_time DESC";
        $list = $this->group->fetchAll($sql);
        die(json_encode($list));
    }
}

?>