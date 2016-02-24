<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
<?php
/**
* 红包预下单接口
* 
*/
 require('yaoyiyao.php');
   if( isset($_GET['d']) ) {
	 echo dirname(__FILE__);
 }
 
 $Redpack = new \Yhb_pub(); 
 $Redpack->setParameter('mch_billno', WxPayConf_pub::MCHID.date('YmdHis').rand(1000, 9999));
 //商户名称
 $Redpack->setParameter('send_name', "商户名称");
 //付款金额
 $Redpack->setParameter('total_amount', 100); //单位分
 //红包发放总人数
 $Redpack->setParameter('amt_type', "ALL_RAND");
 $Redpack->setParameter('total_num', 1);
 //红包祝福语
 $Redpack->setParameter('wishing', "摇一摇送红包");
 //活动名称
 $Redpack->setParameter('act_name', "摇一摇送红包");
 //备注
 $Redpack->setParameter('remark', "摇一摇送红包 备注");
 $result = $Redpack->hbpreorder();
 var_dump( $result);