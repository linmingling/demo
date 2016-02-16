<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class SignController extends ControllerBase {
    
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
        //数据列表
        $sql = "SELECT COUNT(*) FROM qx_sign";
        $count = $this->group->fetchOne($sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_sign ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        
        //已报名人数
        $bm_sql = "SELECT COUNT(*) FROM qx_sign WHERE is_bm = 1";
        $bm_count = $this->group->fetchOne($bm_sql);
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar('select', '');
        $this->view->setVar('search', '');
        $this->view->setVar('bm_count', $bm_count[0]);
    }
    
    public function xlsAction(){
    
        $str = "手机号码\t是否报名\t签到时间\n";
        $str = iconv('utf-8','gb2312',$str);
    
        //数据列表
        $list_sql = "SELECT * FROM qx_sign ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
            if($key['is_bm'] == 0){
                $is_bm = iconv('utf-8','gb2312//IGNORE','否');
            } else {
                $is_bm = iconv('utf-8','gb2312//IGNORE','是');
            }
            $add_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
    
            $str .= $phone."\t".$is_bm."\t".$add_time."\t\n";
        }
        $filename = date('Ymd').'.xls';
        $this->funs_model->exportExcel($filename, $str);
        exit;
    
    }
}

?>