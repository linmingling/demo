<?php
namespace Apps\Phone\Controllers;

class SignController extends ControllerBase {
	
	public function indexAction(){
	     
	}
	
	public function submitAction(){
	    
        $phone = trim($_POST['phone']);
        $sql = "SELECT id FROM qx_sign WHERE phone='".$phone."'";
        $data = $this->group->fetchOne($sql);
        if(!empty($data)){
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "你已经签过到了！";
            die(json_encode($ajax_result));
        } else {
            $isBM_sql = "SELECT id FROM qx_registration WHERE phone='".$phone."'";
            $result = $this->group->fetchOne($isBM_sql);
            if(empty($result)){
                $is_bm = 0;
            } else {
                $is_bm = 1;
            }
            $sql = "INSERT INTO qx_sign (phone, is_bm, add_time) VALUES('".$phone."','".$is_bm."','".time()."')";
            $this->group->execute($sql);
            $resultId = $this->group->lastInsertId();
            if($resultId){
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "签到成功！";
                $ajax_result['isbm'] = $is_bm;
            } else {
                $ajax_result['errcode'] = 1003;
                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
            }
            die(json_encode($ajax_result));
        }
	}
}

?>