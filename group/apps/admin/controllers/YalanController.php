<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class YalanController extends ControllerBase {
    
    private $funs_model;
    private $location_model;
    
    public function initialize(){
        parent::initialize();
        $this->funs_model = new \Library\Com\Funs();
        $this->location_model = new \Library\Com\Location();
    }
    
    //报名数据列表
    public function indexAction(){
        
        $this->session->set('select', '');
        $this->session->set('search', '');
        
        //数据列表
        $sql = "SELECT COUNT(*) FROM yalan_registration";
        $count = $this->group->fetchOne($sql);
        
        $mb_sql = "SELECT COUNT(*) FROM yalan_registration WHERE btn_id <> ''";
        $mb_count = $this->group->fetchOne($mb_sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM yalan_registration ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar("mb_count", $mb_count[0]);
        $this->view->setVar("pc_count", $count[0] - $mb_count[0]);
        $this->view->setVar('select', $this->session->get('select'));
        $this->view->setVar('search', $this->session->get('search'));
    }
    

    //布点数据统计表
    public function budian_statisticsAction(){
        
        $bm_sql = "SELECT COUNT(*) FROM yalan_registration WHERE btn_id <> ''";
        $bm_count = $this->group->fetchOne($bm_sql);
        
        $sql = "SELECT COUNT(*) FROM yalan_budian";
        $count = $this->group->fetchOne($sql);
        
        //总的转化率
        $total_zhl = sprintf("%.4f", $bm_count[0]/$count[0])*100;
        $this->view->setVar('click_num', $count[0]);
        $this->view->setVar('bm_count', $bm_count[0]);
        $this->view->setVar('total_zhl', $total_zhl);
        
        //各屏布点数据统计
        $group_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM yalan_budian GROUP BY btn_id";
        $group_list = $this->group->fetchAll($group_sql);
        
        $city_zhl_sql = "SELECT btn_id, COUNT(btn_id) AS num FROM yalan_registration WHERE btn_id <> '' GROUP BY btn_id";
        $zhl_list = $this->group->fetchAll($city_zhl_sql);
        foreach ($zhl_list as $k => $key){
            $bdzhl_arr[$key['btn_id']] = $key;
        }
        foreach ($group_list as $k => $key){
            if($key['btn_id']){
                $group_arr[$k]['name'] = $this->budian_name($key['btn_id']);
                $group_arr[$k]['proportion'] = sprintf("%.4f", $key['num']/$count[0])*100;
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
//         echo '<pre>';print_r($bdzhl_arr);exit;
        
       $start_time = '2015-10-16';
       $time = date('Y-m-d', time());
       $for_num = (strtotime($time) - strtotime($start_time))/86400;//活动进行天数
       $zuijin_time = strtotime($time) - 86400 * 3;//最近10天的数据
       
       //每天报名转化率
       $list_sql = "SELECT * FROM yalan_budian WHERE add_time > ".$zuijin_time." ORDER BY add_time DESC";
       $list = $this->group->fetchAll($list_sql);
       foreach ($list as $k => $key){
           if($key['add_time']){
               $time_k = date('m月d日', $key['add_time']);
           } else {
               $time_k = '无时间记录';
           }
           $list_arr[$time_k][$key['btn_id']]['btn_id'] = $key['btn_id'];
           $list_arr[$time_k][$key['btn_id']]['btn_name'] = $this->budian_name($key['btn_id']);
           @$list_arr[$time_k][$key['btn_id']]['num'] += 1;
           $list_arr[$time_k][100]['btn_id'] = 0;
           @$list_arr[$time_k][100]['num'] += 1;
       }
//        echo '<pre>';print_r($list_arr);exit;
       
       $bm_sql = "SELECT * FROM yalan_registration WHERE btn_id <> '' AND add_time > ".$zuijin_time;
       $bm_list = $this->group->fetchAll($bm_sql);
       foreach ($bm_list as $k => $key){
           if($key['add_time']){
               $time_k = date('m月d日', $key['add_time']);
           } else {
               $time_k = '无时间记录';
           }
           $bm_list_arr[$time_k][$key['btn_id']]['btn_id'] = $key['btn_id'];
           $bm_list_arr[$time_k][$key['btn_id']]['btn_name'] = $this->budian_name($key['btn_id']);
           @$bm_list_arr[$time_k][$key['btn_id']]['num'] += 1;
           $bm_list_arr[$time_k][100]['btn_id'] = 0;
           @$bm_list_arr[$time_k][100]['num'] += 1;
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
       $this->view->setVar('budian_name', $budian_name);
//        echo '<pre>';print_r($arr);exit;
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
	    
	    $str = "姓名\t手机号码\t区\t地址\t数据来源\tip地址\tip地址所属省市\t报名次数\t报名时间\t是否验证\t\n";
	    $str = iconv('utf-8','gb2312',$str);
	    
	    $list_sql = "SELECT * FROM yalan_registration ".$where." ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
	    
	    foreach ($list as $k => $key){
	        $name = iconv('utf-8','gb2312//IGNORE',$key['name']);
	        $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
	        $area = iconv('utf-8','gb2312//IGNORE',$key['area']);
	        $address = iconv('utf-8','gb2312//IGNORE',$key['address']);
	        $url_source = iconv('utf-8','gb2312//IGNORE',$key['url_source']);
	        $ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
	        $ip_address = iconv('utf-8','gb2312//IGNORE', empty($key['ip_city']) ? '未知' : $key['ip_city']);
	        $num = iconv('utf-8','gb2312//IGNORE', $key['num']);
	        $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
	        $state = iconv('utf-8','gb2312//IGNORE',empty($key['state']) ? '未验证' : '已验证');
	        $str .= $name."\t".$phone."\t".$area."\t".$address."\t".$url_source."\t".$ip."\t".$ip_address."\t".$num."\t".$verify_time."\t".$state."\t\n";
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
	    
	    $str = "姓名\t手机号码\t区\t地址\t数据来源\tip地址\tip地址所属省市\t报名次数\t报名时间\t是否验证\t\n";
	    $str = iconv('utf-8','gb2312',$str);
	     
	    $list_sql = "SELECT * FROM yalan_registration ORDER BY add_time DESC";
	    $list = $this->group->fetchAll($list_sql);
	     
	    foreach ($list as $k => $key){
	        $name = iconv('utf-8','gb2312//IGNORE',$key['name']);
	        $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
	        $area = iconv('utf-8','gb2312//IGNORE',$key['area']);
	        $address = iconv('utf-8','gb2312//IGNORE',$key['address']);
	        $url_source = iconv('utf-8','gb2312//IGNORE',$key['url_source']);
	        $ip = iconv('utf-8','gb2312//IGNORE',$key['ip']);
	        $ip_address = iconv('utf-8','gb2312//IGNORE', empty($key['ip_city']) ? '未知' : $key['ip_city']);
	        $num = iconv('utf-8','gb2312//IGNORE', $key['num']);
	        $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
	        $state = iconv('utf-8','gb2312//IGNORE',empty($key['state']) ? '未验证' : '已验证');
	        $str .= $name."\t".$phone."\t".$area."\t".$address."\t".$url_source."\t".$ip."\t".$ip_address."\t".$num."\t".$verify_time."\t".$state."\t\n";
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
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $search = $this->request->getPost("search");
                $where = $select."='".$search."'";
            }
            $this->session->set('select',$select);
            $this->session->set('search',$search);
        } else {
            $select = $this->session->get('select');
            $search = $this->session->get('search');
            if($select == 'add_time'){
                $where = $select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $where = $select."='".$search."'";
            }
        }
        
        $sql = "SELECT COUNT(*) FROM yalan_registration WHERE ".$where;
        $count = $this->group->fetchOne($sql);
        
        $mb_sql = "SELECT COUNT(*) FROM yalan_registration WHERE btn_id <> '' AND ".$where;
        $mb_count = $this->group->fetchOne($mb_sql);
        
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM yalan_registration WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar("mb_count", $mb_count[0]);
        $this->view->setVar("pc_count", $count[0] - $mb_count[0]);
        
        $this->view->setVar('select', $select);
        $this->view->setVar('search', $search);
        $this->view->pick("yalan/index");
    }
    
    //比例图颜色
    public function color_class($color){
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
    
    //按钮名称
    public function budian_name($btn_id = ''){
        $btn_arr = array(
            1 => '首屏',
            2 => '全场1.8折起',
            3 => '联单再享9.5折',
            4 => '雅兰精品1元抢',
            5 => '4999元免单大奖',
            6 => '31121元家具大礼包',
            7 => '限量特供2599元主动充能床垫',
            8 => '限量床垫买再送6635元',
            9 => '50部iphone6s准点送',
            10 => '限量送100张门票',
            11 =>'尾页',
            100 => '当天总转化率',
        );
        if($btn_id){
            return $btn_arr[$btn_id];
        } else {
            return $btn_arr;
        }
    }
}
?>