<?php
namespace Apps\Admin\Controllers;


use Library\Com\Page;

class HongbaoController extends ControllerBase {
    
    private $funs_model;
    private $weixinapi;
    private $token;
    private $appId;
    private $appSecret;
    
    public function initialize(){
        parent::initialize();
        $this->funs_model = new \Library\Com\Funs();
        //微信服务由优居生活提供
		$this->token = "ubtaeo1422330200";
		$this->appId = "wxd43f7b5d8539e718";
		$this->appSecret = "a42b85c54c3e79b709023df894f42778";
		$this->weixinapi = new \Library\Com\WeiXinApi($this->session,$this->token,$this->appId,$this->appSecret);
    }
    
    //数据列表
    public function indexAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM qx_hongbao";
        $count = $this->group->fetchOne($sql);
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_hongbao ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $phone[] = $key['phone'];
            $sql = "SELECT COUNT(*) FROM qx_hongbao_record WHERE from_phone='".$key['phone']."'";
            $list[$k]['count'] = $this->group->fetchOne($sql)[0];
        }
//         echo '<pre>';print_r($list);exit;
        if(!empty($phone)){
            $blq_sql = "SELECT * FROM qx_hongbao_record WHERE from_phone IN(".implode(',', $phone).")"." ORDER BY add_time DESC";
            $blq_list = $this->group->fetchAll($blq_sql);
    //         echo '<pre>';print_r($lq_list);exit;
            foreach ($blq_list as $k => $key){
                if($key['from_phone'] != $key['phone']){
                    $blq_arr[$key['from_phone']][$k]['phone'] = $key['phone'];
                    $blq_arr[$key['from_phone']][$k]['total'] = $key['total'];
                    $blq_arr[$key['from_phone']][$k]['add_time'] = date('Y-m-d H:i:s', $key['add_time']);
                    @$lingqu_list[$key['from_phone']]['blq_money'] += $key['total'];
                }
            }
    //         echo '<pre>';print_r($blq_arr);exit;
            $lq_sql = "SELECT * FROM qx_hongbao_record WHERE phone IN(".implode(',', $phone).")"." ORDER BY add_time DESC";
            $lq_list = $this->group->fetchAll($lq_sql);
            foreach ($lq_list as $k => $key){
                if($key['phone'] == $key['from_phone']){
                    $lq_arr[$key['phone']][$k]['from_phone'] = "自己";
                } else {
                    $lq_arr[$key['phone']][$k]['from_phone'] = $key['from_phone'];
                }
                $lq_arr[$key['phone']][$k]['total'] = $key['total'];
                $lq_arr[$key['phone']][$k]['add_time'] = date('Y-m-d H:i:s', $key['add_time']);
                @$lingqu_list[$key['phone']]['lq_money'] += $key['total'];
            }
            
            foreach ($list as $kk => $kkey){
                @$lingqu_list[$kkey['phone']]['blq'] = $blq_arr[$kkey['phone']];
                @$lingqu_list[$kkey['phone']]['lq'] = $lq_arr[$kkey['phone']];
            }
        }
//         echo '<pre>';print_r($lingqu_list);exit;
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar('lingqu_list',$lingqu_list);
        $this->view->setVar("lq_arr", $lq_arr);
        $this->view->setVar("count", $count[0]);
        
    }
    
    //数据列表
    public function recordAction(){
        
        setcookie('select');
        setcookie('search');
        //数据列表
        $sql = "SELECT COUNT(*) FROM qx_hongbao_record";
        $count = $this->group->fetchOne($sql);
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_hongbao_record ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $list[$k]['is_bm'] = $this->get_isBM($key['phone']);
        }
//         echo '<pre>';print_r($list);exit;
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar("count", $count[0]);
        
        $this->view->setVar('select', '');
        $this->view->setVar('search', '');
    }
    
    //红包使用情况
    public function useAction(){
        //数据列表
        $sql = "SELECT COUNT(*) FROM qx_hongbao_record WHERE state <> 1";
        $count = $this->group->fetchOne($sql);
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_hongbao_record WHERE state <> 1 ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $list[$k]['openid'] = $this->get_opneid($key['phone']);
            $list[$k]['is_bm'] = $this->get_isBM($key['phone']);
        }
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        
//         echo '<pre>';print_r($list);exit;
    }
    
    public function budianAction(){
        $sql = "SELECT btn_id, COUNT(btn_id) AS num FROM qx_hongbao_budian GROUP BY btn_id";
        $count = $this->group->fetchAll($sql);
        $this->view->setVar("count", $count);
//         echo '<pre>';print_r($count);exit;
    }
    
    
    //获取用户openid
    public function get_opneid($phone){
        $sql = "SELECT openid FROM qx_hongbao_binding WHERE phone='".$phone."'";
        $result = $this->group->fetchOne($sql);
        return $result['openid'];
    }
    
    //获取用户是否已报名
    public function get_isBM($phone){
        $sql = "SELECT id FROM qx_registration WHERE phone='".$phone."'";
        $result = $this->group->fetchOne($sql);
        if(empty($result)){
            return 0;
        } else {
            return 1;
        }
    }
    
    
    //红包验证
    public function operationAction(){
        $account = $_POST['account'];
        $data['openid'] = $_POST['openid'];
        $total = $_POST['total'];
        $send_id = $_POST['send_id'];
        
        if(!empty($send_id)){
            $sql = "UPDATE qx_hongbao_record SET state='".$account."',operation_time='".time()."' WHERE id='".$send_id."'";
            $up_result = $this->group->execute($sql);
            
            if($up_result){
                if($account == 3){
                    $data['first'] = "您好， 您的七夕家装节返现红包验证成功";
                    $data['template_id'] = "GoXq3aZNc4mU3bslhwV7A-x6dGNzd0A2OjksIsZ2m3k";
                    $data['keyword1'] = "七夕家装节返现红包";
                    $data['keyword2'] = "金额".$total."元";
                    $data['keyword3'] = date('Y-m-d H:i',time());
                    $data['content'] = "红包对应金额已充值到您的微信钱包中，请注意查收。";
                    $this->send($data);
                } else {
                    $data['first'] = "您好， 您的七夕家装节返现红包未能通过验证";
                    $data['template_id'] = "VBf3HuxOhsg2WuCPSRKHd14VQUtdkE2tS9veuYYOUZk";
                    $data['keyword1'] = "未通过";
                    $data['keyword2'] = "七夕家装节返现红包（".$total."元）";
                    $data['keyword3'] = "品牌|订单号|订单金额|订单照片";
                    $data['content'] = trim($_POST['err_content'])."。 如有疑问，请拨打服务电话xxxx";
                    $this->send($data);
                }
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = '操作成功，信息已发送';
                die(json_encode($ajax_result));
            } else {
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = '操作失败！';
                die(json_encode($ajax_result));
            }
        } else {
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = '系统繁忙，请稍后重试！';
            die(json_encode($ajax_result));
        }
    }
    
    //搜索
    public function record_searchAction(){
    
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
    
        $sql = "SELECT COUNT(*) FROM qx_hongbao_record WHERE ".$where;
        $count = $this->group->fetchOne($sql);
    
    
        $page = new \Library\Com\Page($count[0], 10);
        $list_sql = "SELECT * FROM qx_hongbao_record WHERE ".$where." ORDER BY add_time DESC LIMIT ".$page->firstRow.','.$page->listRows;
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $list[$k]['is_bm'] = $this->get_isBM($key['phone']);
        }
        
        
        $this->view->setVar('page',$page->show());
        $this->view->setVar("list", $list);
        $this->view->setVar('count', $count[0]);
        
        $this->view->setVar('select', $select);
        $this->view->setVar('search', $search);
        $this->view->pick("hongbao/record");
    }
    
    public function xlsAction(){
    
        $str = "手机号码\t被领取红包数\t领取红包数\t来源\t添加时间\n";
        $str = iconv('utf-8','gb2312',$str);
    
        //数据列表
        $list_sql = "SELECT * FROM qx_hongbao ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $sql = "SELECT COUNT(*) FROM qx_hongbao_record WHERE from_phone='".$key['phone']."'";
            $list[$k]['count'] = $this->group->fetchOne($sql)[0];
        }
    
        foreach ($list as $k => $key){
            $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
            if($key['phone'] == "20150806000"){
                $num = iconv('utf-8','gb2312//IGNORE',100000 - $key['num']);
            } else {
                $num = iconv('utf-8','gb2312//IGNORE',25 - $key['num']);
            }
            $collect_num = iconv('utf-8','gb2312//IGNORE',$key['collect_num']);
            $url_source = iconv('utf-8','gb2312//IGNORE',$key['url_source']);
            $add_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
            
            $str .= $phone."\t".$num."\t".$collect_num."\t".$url_source."\t".$add_time."\t\n";
        }
        $filename = "hongbao-".date('Ymd').'.xls';
        $this->funs_model->exportExcel($filename, $str);
        exit;
    
    }
    
    /**
     * 导出XLS
     * @param unknown $filename
     * @param unknown $content
     */
    public function record_bmtable_xlsAction(){
         
        $select = $_COOKIE['select'];
        $search = $_COOKIE['search'];
        if(!empty($search) && !empty($search)){
            if($select == 'add_time'){
                $where = ' WHERE '.$select.'>='.strtotime($search).' AND '.$select. '<'.(strtotime($search)+86400);
            } else {
                $where = ' WHERE '.$select."='".$search."'";
            }
        } else {
            $where = '';
        }
         
        $str = "红包发起人\t红包领取人\t领取人是否报名\t金额\t券号\t领取时间\t验证时间\t状态\n";
        $str = iconv('utf-8','gb2312',$str);
         
        $list_sql = "SELECT * FROM qx_hongbao_record ".$where." ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $list[$k]['is_bm'] = $this->get_isBM($key['phone']);
        }
        
        foreach ($list as $k => $key){
            $from_phone = iconv('utf-8','gb2312//IGNORE',$key['from_phone']);
            $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
            $isBM = iconv('utf-8','gb2312//IGNORE',empty($key['is_bm']) ? "否" : "是");
            $total = iconv('utf-8','gb2312//IGNORE',$key['total']);
            $sn = iconv('utf-8','gb2312//IGNORE',$key['sn']);
            $add_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
            $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['verify_time']) ? '' : date('Y-m-d H:i:s', $key['verify_time']));
            if($key['state'] == 1){
                $state = iconv('utf-8','gb2312//IGNORE','未验证');
            } else {
                $state = iconv('utf-8','gb2312//IGNORE','已验证');
            }
           
            $str .= $from_phone."\t".$phone."\t".$isBM."\t".$total."\t".$sn."\t".$add_time."\t".$verify_time."\t".$state."\t\n";
        }
        $filename = "hongbao-".date('Ymd').'.xls';
        $this->funs_model->exportExcel($filename, $str);
        exit;
    }
    
    //导出红包使用情况数据表
    public function use_bmtable_xlsAction(){
        
        $str = "微信openid\t手机号码\t是否报名\t金额\t券号\t领取时间\t验证时间\t状态\n";
        $str = iconv('utf-8','gb2312',$str);
        
        //数据列表
        $list_sql = "SELECT * FROM qx_hongbao_record WHERE state <> 1 ORDER BY add_time DESC";
        $list = $this->group->fetchAll($list_sql);
        foreach ($list as $k => $key){
            $list[$k]['openid'] = $this->get_opneid($key['phone']);
            $list[$k]['is_bm'] = $this->get_isBM($key['phone']);
        }
        
        foreach ($list as $k => $key){
            $openid = iconv('utf-8','gb2312//IGNORE',$key['openid']);
            $phone = iconv('utf-8','gb2312//IGNORE',$key['phone']);
            $isBM = iconv('utf-8','gb2312//IGNORE',empty($key['is_bm']) ? "否" : "是");
            $total = iconv('utf-8','gb2312//IGNORE',$key['total']);
            $sn = iconv('utf-8','gb2312//IGNORE',$key['sn']);
            $add_time = iconv('utf-8','gb2312//IGNORE',empty($key['add_time']) ? '' : date('Y-m-d H:i:s', $key['add_time']));
            $verify_time = iconv('utf-8','gb2312//IGNORE',empty($key['verify_time']) ? '' : date('Y-m-d H:i:s', $key['verify_time']));
            if($key['state'] == 1){
                $state = iconv('utf-8','gb2312//IGNORE','未验证');
            } else {
                $state = iconv('utf-8','gb2312//IGNORE','已验证');
            }
            $str .= $openid."\t".$phone."\t".$isBM."\t".$total."\t".$sn."\t".$add_time."\t".$verify_time."\t".$state."\t\n";
        }
        $filename = "hongbao-".date('Ymd').'.xls';
        $this->funs_model->exportExcel($filename, $str);
        exit;
    
    }
    
    //发送验证通知
    public function send($data){
        if(!empty($data['openid'])){
            $access_token = $this->weixinapi->get_access_token();
            $send_data =  '{
                           "touser":"'.$data['openid'].'",
                           "template_id":"'.$data['template_id'].'",
                           "url":"http://mp.weixin.qq.com/s?__biz=MzA4MzAxNjU3OA==&mid=203455940&idx=1&sn=bf66b1d408383fcde4a2a6494f8d8b88#rd",
                           "topcolor":"#FF0000",
                           "data":{
                                   "first": {
                                       "value":"'.$data['first'].'",
                                       "color":"#173177"
                                   },
                                   "keyword1":{
                                       "value":"'.$data['keyword1'].'",
                                       "color":"#173177"
                                   },
                                   "keyword2": {
                                       "value":"'.$data['keyword2'].'",
                                       "color":"#173177"
                                   },
                                   "keyword3": {
                                       "value":"'.$data['keyword3'].'",
                                       "color":"#173177"
                                   },
                                   "remark":{
                                       "value":"'.$data['content'].'",
                                       "color":"#173177"
                                   }
                           }
                        }';
            $template_send = $this->weixinapi->template_send($access_token, $send_data);
        }
    }
}

?>