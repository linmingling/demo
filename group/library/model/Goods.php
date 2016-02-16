<?php
namespace Library\Model;

class Goods extends Base{
	
    public function initialize(){
        parent::initialize();
    }
	
	
	//获取商品信息
	public function info($params){
		$goodsId = isset($params['goodsId']) ? (int)$params['goodsId'] : 0;
		$descShow = isset($params['descShow']) ? (int)$params['descShow'] : 0;
		
		$info = $this->api("Goods.info",array('goodsId'=>$goodsId,'descShow'=>$descShow));
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function idList($params){
		$idList = isset($params['idList']) ? $params['idList'] : 0;
		$descShow = isset($params['descShow']) ? (int)$params['descShow'] : 0;
		
		$info = $this->api("Goods.info",array('idList'=>$idList,'descShow'=>$descShow));
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function category($params){
		$info = $this->api("Goods.category",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function CatStr(){
		$space12 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$category = $this->category(array('catId'=>0,'type'=>1));
		foreach($category['list'] as $k){
			$catStr[] = array('id'=>$k['id'],'name'=>$k['name']);
			if(isset($k['list'])){
				foreach($k['list'] as $m){
					$catStr[] = array('id'=>$m['id'],'name'=>$space12.$m['name']);
					if(isset($m['list'])){
						foreach($m['list'] as $n){
							$catStr[] = array('id'=>$n['id'],'name'=>$space12.$space12.$n['name']);
						}
					}
				}
			}
		}
		return empty($catStr) ? false : $catStr;
	}
	
	public function lists($params){
		
		$info = $this->api("Goods.lists",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}

}


