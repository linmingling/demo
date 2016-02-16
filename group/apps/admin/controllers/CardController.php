<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class CardController extends ControllerBase {
    
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
        setcookie('select');
        setcookie('search');
        $sql = "SELECT COUNT(*) FROM qx_membership_card";
        $count = $this->group->fetchOne($sql);
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_membership_card LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar('select', '');
        $this->view->setVar('search', '');
    }
    
    //搜索
    public function searchAction(){
    
        if($this->request->isPost() == true){
            $select = $this->request->getPost("select");
            $search = $this->request->getPost("search");
            $where = $select."='".$search."'";
            setcookie('select',$select);
            setcookie('search',$search);
        } else {
            $select = $_COOKIE['select'];
            $search = $_COOKIE['search'];
            $where = $select."='".$search."'";
        }
    
        $sql = "SELECT COUNT(*) FROM qx_membership_card WHERE ".$where;
        $count = $this->group->fetchOne($sql);
    
    
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_membership_card WHERE ".$where." LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
    
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
    
        $this->view->setVar('select', $select);
        $this->view->setVar('search', $search);
        $this->view->pick("card/index");
    }
    
    /**
     * 导出XLS
     * @param unknown $filename
     * @param unknown $content
     */
    public function bmtable_xlsAction(){
         
        $select = $_COOKIE['select'];
        $search = $_COOKIE['search'];
        if(!empty($search) && !empty($search)){
            $where = ' WHERE '.$select."='".$search."'";
        } else {
            $where = '';
        }
         
        $str = "城市\t卡号\t验证码\t\n";
        $str = iconv('utf-8','gb2312',$str);
         
        $list_sql = "SELECT * FROM qx_membership_card ".$where;
        $list = $this->group->fetchAll($list_sql);
         
        foreach ($list as $k => $key){
            $city = iconv('utf-8','gb2312//IGNORE',$key['city']);
            $card_number = iconv('utf-8','gb2312//IGNORE',$key['card_number']);
            $captcha = iconv('utf-8','gb2312//IGNORE',$key['captcha']);
            $str .= $city."\t".$card_number."\t".$captcha."\t\n";
        }
        $filename = 'card_'.date('Ymd').'.xls';
        $this->funs_model->exportExcel($filename, $str);
        exit;
    }
    
    
//     public function addAction(){
//             $a = 180000;
//             $b = 170001;
//             for($b;$b<=$a;$b++){
//                 if(strlen($b) == 1){
//                     $c = 'QQ00000';
//                 }
//                 if(strlen($b) == 2){
//                     $c = 'QQ0000';
//                 }
//                 if(strlen($b) == 3){
//                     $c = 'QQ000';
//                 }
//                 if(strlen($b) == 4){
//                     $c = 'QQ00';
//                 }
//                 if(strlen($b) == 5){
//                     $c = 'QQ0';
//                 }
//                 if(strlen($b) == 6){
//                     $c = 'QQ';
//                 }
//                 $card = $c.$b;
//                 $sn = rand(100,999);
//                 $city_code = 'dongguan';
//                 $city = '东莞';
//                 $sql = "INSERT INTO qx_membership_card (city, city_code, card_number, captcha) VALUES('".$city."','".$city_code."','".$card."','".$sn."')";
//                 $this->group->execute($sql);
//         }
//     }
   
}

?>