<?php 
require_once "../../data/config.php";
require_once "wxpay/wxpay.php";
$wxpay = new wxpay();

$order_id = empty($_GET['id']) ? 0 : $_GET['id'];
if(empty($order_id)){
    echo "<script>alert('请求无效！')</script>";
    header("Location: http://zt.jia360.com/yyys_m/index.php");
}
$sql = "SELECT * FROM order_list WHERE id=".$order_id;
$res = mysqli_query($db, $sql);
$arr = array();
while($row = $res->fetch_array()){
    $arr = $row;
}
if(!$arr){
    echo "<script>alert('订单不存在！')</script>";exit;
} else {
    $order['order_amount'] = $arr['total_amount'];//订单金额
    $order['order_sn'] = $arr['goods_name'];//订单名称
    $order['out_trade_no'] = $arr['mch_billno'];//商户订单号
    //$order['openid'] = 'oghnDt7O_sWIel36VVufhrVdGDFA';
    $order['openid'] = $arr['openid'];//用户身份ID
}

$success_url = "http://zt.jia360.com/yyys_m/buy.php?id=".$order_id;//支付成功后要跳转的页面
$fail_url="http://zt.jia360.com/yyys_m/index.php";//支付失败、取消支付跳转的页面

$create_biz_package = $wxpay->get_code($order, $success_url, $fail_url);
echo $create_biz_package;exit;

?>