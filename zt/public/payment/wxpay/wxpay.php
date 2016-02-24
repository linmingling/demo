<?php 
/*
 * 微信支付类
 */
require_once "WxPayPubHelper.php";

class wxpay
{
    /**
     * 
     * @param unknown $order        订单信息
     * @param unknown $success_url  支付成功后要跳转的页面
     * @param unknown $fail_url     支付失败、取消支付跳转的页面
     * @return string
     */
    function get_code($order, $success_url, $fail_url){
        
        if(!$order['order_amount'] || !$order['order_sn'] || !$order['out_trade_no'] || !$order['openid']){
            echo "参数错误，请退出重试";exit;
        }
        
        $openid = $order['openid'];//用户身份ID
        $order_sn = $order['order_sn'];//商品描述
        $price = intval($order['order_amount'] * 100); //订单金额，单位分，不能带小数点
        $out_trade_no = $order['out_trade_no'];//商户订单号
        
        //使用jsapi接口
        $jsApi = new JsApi_pub();
        
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        //自定义订单号，此处仅作举例
//         $timeStamp = date('Ymdhis');
//         $out_trade_no = WxPayConf_pub::MCHID.$timeStamp.$order['order_id'];

        $unifiedOrder->setParameter("openid","$openid");//用户身份ID
        $unifiedOrder->setParameter("body","$order_sn");//商品描述
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
        $unifiedOrder->setParameter("total_fee","$price");//总金额
        $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();
//         		var_dump($jsApiParameters);exit;

        $getbutton = $jsApi->getbutton($jsApiParameters, $success_url, $fail_url);
//         		var_dump( $getbutton);exit;
        return $getbutton;
    }
}


?>