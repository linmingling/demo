<?php 
namespace Apps\Phone\Controllers;

use \Library\Com\LibSms;

class IndexController extends ControllerBase {
	
	private $point_model;
	
	public function initialize()
	{
		$this->point_model = new \Library\Com\GroupPoint($this->group);
	}
	
	/**
	 * 		首页
	 * 
	 * 
	 */
	public function indexAction()
	{
		$from = empty($_GET['from']) ? '' : $_GET['from'];
        $this->session->set('url_source', $from);
		$db = $this->group;
        
        $city_code = $this->dispatcher->getParam(0);
        //开放城市列表
        $sql = "SELECT * FROM group_list WHERE is_open=1";
        $city_list = $db->fetchAll($sql);
        $this->view->setVar("city_list", $city_list);
        
        //定位城市信息
        $location = $this->point_model->getCity($city_code, $city_list);
        $this->session->set('city_code', $location['city_code']);
        $this->view->setVar("location", $location);

        //当前所选的城市站信息
        $sql = "SELECT * FROM group_list WHERE city_code='".$location['city_code']."'";
        $info = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        $this->view->setVar("info", $info);
        
        //轮播图和一元抢入口
        $sql = "select * from app_index_info";
        $appIndexInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
        $indexImgList = explode(',', $appIndexInfo['index_img']);
		$indexUrlList = explode(',', $appIndexInfo['index_url']);
		
		for ($i = 0; $i<count($indexImgList);)
		{
			$indexInfo[$i]['img'] = $indexImgList[$i];
			$indexInfo[$i]['url'] = $indexUrlList[$i];
			$i++;
		}
		
		$indexData['info'] = $indexInfo;
		$indexData['yyq_img'] = $appIndexInfo['yyq_img'];
		$indexData['yyq_url'] = $appIndexInfo['yyq_url'];
// 		var_dump($indexData);die;
		$this->view->setVar('indexData',$indexData);
		
        //优品团商品列表
		$sql = "SELECT * FROM group_goods_list WHERE action_id='".$info['id']."' AND start_time<".time()." AND end_time>".time()." AND (is_show=1 OR is_site=1) order by view_num desc limit 5";
		$goodsList = $db->fetchAll($sql);
		
		//优品团品牌列表
		$sql = "SELECT id,name FROM group_brand_list";
		$brandResutl = $db->fetchAll($sql);
		foreach ($brandResutl as $k=>$v)
		{
			$brandList[$v['id']]['name'] = $v['name'];
		}
		
		foreach ($goodsList as $k=>$v)
		{
			$goodsList[$k]['discount'] = round(intval($v['exclusive_price']) / intval($v['market_price']) * 10, 1);
			$goodsList[$k]['title'] = "【" . $brandList[$v['brand_id']]['name'] . "】" . $goodsList[$k]['goods_name'];
			$goodsList[$k]['title'] = mb_strlen($goodsList[$k]['title'],'utf-8') > 23? mb_substr($goodsList[$k]['title'], 0, 19,'utf-8') . "...":$goodsList[$k]['title'];
			
		}
		
		$this->view->setVar("goodsList", $goodsList);
// 		var_dump($goodsList);die;
	}
	
	/**
	 * 		瀑布流加载请求
	 * 		
	 * 
	 */
	public function scrollViewAction()
	{
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			$db = $this->group;
			
			$type = $post['type'];
			$page = $post['page'] * 5;
			
			$cityCode = $this->session->get("city_code");
			
			$sql = "SELECT * FROM group_list WHERE city_code='".$cityCode."'";
			$info = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
			
			$order = "";
			switch ($type)
			{
				case '人气最高':
					$order = " order by view_num desc";
					break;
				case '价格最优':
					$order = " order by exclusive_price/market_price asc";
					break;
				case '卖的最多':
					$order = " order by sold_num+real_num desc";
					break;
				case '最新上架':
					$order = " order by start_time desc";
					break;
				default:break;
			}
			
			//优品团商品列表
			$sql = "SELECT * FROM group_goods_list WHERE action_id='".$info['id']."' AND start_time<".time()." AND end_time>".time()." AND (is_show=1 OR is_site=1) $order limit $page,5";
			$goodsList = $db->fetchAll($sql);
			
			if(empty($goodsList))
			{
				die(json_encode(array(
						'code'=>999,
						'msg'=>'empty',
				)));
			}
			
			//优品团品牌列表
			$sql = "SELECT id,name FROM group_brand_list";
			$brandResutl = $db->fetchAll($sql);
			foreach ($brandResutl as $k=>$v)
			{
				$brandList[$v['id']]['name'] = $v['name'];
			}
			foreach ($goodsList as $k=>$v)
			{
				$goodsList[$k]['discount'] = round(intval($v['exclusive_price']) / intval($v['market_price']) * 10, 1);
				$goodsList[$k]['title'] = "【" . $brandList[$v['brand_id']]['name'] . "】" . $goodsList[$k]['goods_name'];
				$goodsList[$k]['title'] = mb_strlen($goodsList[$k]['title'],'utf-8') > 23? mb_substr($goodsList[$k]['title'], 0, 19,'utf-8') . "...":$goodsList[$k]['title'];
				unset($goodsList[$k]['notice']);
				unset($goodsList[$k]['goods_desc']);
				unset($goodsList[$k]['guarantee']);
			}
			
			die(json_encode(array(
					'code'=>0,
					'msg'=>$goodsList,
			)));
			
		}
	}
	
	
}



?>


