 <?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$table = 'weather_info';

$sql = "insert into $table (city_id,upd_time) values ('1','" . date('Y-m-d H:i:s') . "')";
mysqli_query($db, $sql);
echo $sql;
 ?>