<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class TianjinController extends ControllerBase {
    
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
        
        setcookie('select');
        setcookie('search');
        //数据列表
        $sql = "SELECT COUNT(*) FROM tianjin";
        $count = $this->group->fetchOne($sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM tianjin ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
//         echo '<pre>';print_r($list);exit;
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar('select', $_COOKIE['select']);
        $this->view->setVar('search', $_COOKIE['search']);
    }
    
	/**
	 * 导出XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public function bmtable_xlsAction(){
	    
	    $select = $_COOKIE['select'];
	    $search = $_COOKIE['search'];
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
	    
	    $list_sql = "SELECT * FROM tianjin ".$where." ORDER BY add_time DESC";
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
	    $filename = "tianjin-".date('Ymd').'.xls';
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
	     
	    $list_sql = "SELECT * FROM tianjin ORDER BY add_time DESC";
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
	    $filename = "tianjin-".date('Ymd').'.xls';
	    $this->funs_model->exportExcel($filename, $str);
	    
	}
    //搜索
    public function searchAction(){
        
        if($this->request->isPost() == true){
            $select = $this->request->getPost("select");
            if($select == 'time'){
                $select = 'add_time';
                $search = $this->request->getPost("time");
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $search = $this->request->getPost("search");
                $where = $select."='".$search."'";
            }
            setcookie('select',$select);
            setcookie('search',$search);
        } else {
            $select = $_COOKIE['select'];
            $search = $_COOKIE['search'];
            if($select == 'add_time'){
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $where = $select."='".$search."'";
            }
        }
        
        $sql = "SELECT COUNT(*) FROM tianjin WHERE ".$where;
        $count = $this->group->fetchOne($sql);
        
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM tianjin WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        
        $this->view->setVar('select', $select);
        $this->view->setVar('search', $search);
        $this->view->pick("tianjin/index");
    }
    
    
    //布点数据统计表
    public function budian_statisticsAction(){
        
        $bm_sql = "SELECT COUNT(*) FROM tianjin WHERE btn_id <> 0";
        $bm_count = $this->group->fetchOne($bm_sql);
    
        $sql = "SELECT COUNT(*) FROM tianjin_budian";
        $count = $this->group->fetchOne($sql);
    
        //总的转化率
        $total_zhl = sprintf("%.4f", $bm_count[0]/$count[0])*100;
        $this->view->setVar('click_num', $count[0]);
        $this->view->setVar('bm_count', $bm_count[0]);
        $this->view->setVar('total_zhl', $total_zhl);

        
        
        $start_time = '2015-09-25';
        $time = date('Y-m-d', time());
        $for_num = (strtotime($time) - strtotime($start_time))/86400;//活动进行天数
        $zuijin_time = strtotime($time) - 86400 * 5;//最近5天的数据
         
        //每天报名转化率
        $list_sql = "SELECT * FROM tianjin_budian WHERE add_time > ".$zuijin_time." ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            if($key['add_time']){
                $time_k = date('Y-m-d', $key['add_time']);
            } else {
                $time_k = '无时间记录';
            }
            $list_arr[$time_k][$key['btn_id']]['btn_id'] = $key['btn_id'];
            $list_arr[$time_k][$key['btn_id']]['btn_name'] = $this->budian_name($key['btn_id']);
            @$list_arr[$time_k][$key['btn_id']]['num'] += 1;
            $list_arr[$time_k][20]['btn_id'] = 0;
            @$list_arr[$time_k][20]['num'] += 1;
        }
//        echo '<pre>';print_r($list_arr);exit;
         
        $bm_sql = "SELECT * FROM tianjin WHERE btn_id <> 0 AND add_time > ".$zuijin_time;
        $bm_list = $this->group->fetchAll($bm_sql);
        foreach ($bm_list as $k => $key){
            if($key['add_time']){
                $time_k = date('Y-m-d', $key['add_time']);
            } else {
                $time_k = '无时间记录';
            }
            $bm_list_arr[$time_k][$key['btn_id']]['btn_id'] = $key['btn_id'];
            $bm_list_arr[$time_k][$key['btn_id']]['btn_name'] = $this->budian_name($key['btn_id']);
            @$bm_list_arr[$time_k][$key['btn_id']]['num'] += 1;
            $bm_list_arr[$time_k][20]['btn_id'] = 0;
            @$bm_list_arr[$time_k][20]['num'] += 1;
        }
//        echo '<pre>';print_r($bm_list_arr);exit;
    
        foreach ($list_arr as $k => $key){
            foreach ($key as $k_l => $key_l){
                $zhl_arr[$k][$k_l]['btn_id'] = $key_l['btn_id'];
                @$zhl_arr[$k][$k_l]['btn_name'] = $key_l['btn_name'];
                @$zhl_arr[$k][$k_l]['click_num'] = $key_l['num'];
                if(empty($bm_list_arr[$k][$k_l]['num'])){
                    @$zhl_arr[$k][$k_l]['bm_num'] = 0;
                    @$zhl_arr[$k][$k_l]['zhl'] = 0/$key_l['num'];
                } else {
                    @$zhl_arr[$k][$k_l]['bm_num'] = $bm_list_arr[$k][$k_l]['num'];
                    @$zhl_arr[$k][$k_l]['zhl'] = sprintf("%.4f", $bm_list_arr[$k][$k_l]['num']/$key_l['num'])*100;
                }
                 
            }
        }
        foreach ($zhl_arr as $k_sort => $key_sort){
            $zhr_sort[$k_sort] = $this->funs_model->array_sort($key_sort, 'btn_id', 'asc');
        }
        $budian_name = $this->budian_name();
        foreach($zhr_sort as $k => $key){
            foreach($budian_name as $k_k => $key_k){
                if(empty($key[$k_k])){
                    $arr[$k][$k_k] = array('zhl'=>0,'bm_num'=>0,'click_num'=>0);
                } else {
                    $arr[$k][$k_k] = $key[$k_k];
                }
                 
            }
        }
        $this->view->setVar('arr', $arr);
        $this->view->setVar('for_num', $for_num);
//        echo '<pre>';print_r($arr);exit;

        //产品图布点数据统计
        $sql = "SELECT * FROM tianjin_product_budian";
        $click_list = $this->group->fetchAll($sql);
        $this->view->setVar('click_list', $click_list);
        
    }
    
    //按钮名称
    public function budian_name($btn_id = ''){
        $btn_arr = array(
            1 => '首屏',
            2 => '2折家居建材大促',
            3 => '1元抢品牌好货',
            4 => '现在领票独享特供产品',
            5 => '下单还能返现',
            6 => '0购物到店就送礼',
            7 => '众多一线品牌',
            8 => '5大特权服务',
            9 => '尾页',
            20 => '总',
        );
        if($btn_id){
            return $btn_arr[$btn_id];
        } else {
            return $btn_arr;
        }
    
    }
    
}

?>