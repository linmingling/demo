<?php 
namespace Apps\Admin\Controllers;

use Library\Com\SecurityContext;

class AppController extends ControllerBase 
{
	public function indexAction()
	{
		$db = $this->group;
		
		//是否已有首页信息
		$sql = "select * from app_index_info";
		$checkInfo = $db->fetchOne($sql,\Phalcon\Db::FETCH_ASSOC);
		$tag = true;
		if(empty($checkInfo)) $tag = false;
		
		//修改or添加
		if($this->request->isPost() == true)
		{
			$post = $this->request->getPost();
			
// 			var_dump($post);die;
			
			foreach ($post['index_img'] as $k=>$key){
				if($key != ''){
					$imgArr[] = $key;
				}
			}
			foreach ($post['index_url'] as $k=>$key){
				if($key != ''){
					$urlArr[] = $key;
				}
			}
			
			$indexImg = implode(',', $imgArr);
			$indexUrl = implode(',', $urlArr);
			
			$yyqImg = $post['yyq_img'];
			$yyqUrl = $post['yyq_url'];
			
			if($tag)
			{
				$sql = "update app_index_info set index_img = '{$indexImg}',index_url = '{$indexUrl}',yyq_img = '{$yyqImg}',yyq_url = '{$yyqUrl}' ";
			}
			else 
			{
				$sql = "insert into app_index_info (index_img,index_url,yyq_img,yyq_url) values ('{$indexImg}','{$indexUrl}','{$yyqImg}','{$yyqUrl}')";
			}
			
			$result = $db->execute($sql);
			if($result)
			{
				$this->_message('操作成功', "app/index", true);
			} 
			else 
			{
				$this->_message('系统繁忙，请稍后重试', "app/index", false);
			}
			
		}
		else //显示
		{
			if($tag)
			{
				$indexImgList = explode(',', $checkInfo['index_img']);
				$indexUrlList = explode(',', $checkInfo['index_url']);
				
				for ($i = 0; $i<count($indexImgList);)
				{
					$indexInfo[$i]['img'] = $indexImgList[$i];
					$indexInfo[$i]['url'] = $indexUrlList[$i];
					$i++;
				}
				
				$indexData['info'] = $indexInfo;
				$indexData['yyq_img'] = $checkInfo['yyq_img'];
				$indexData['yyq_url'] = $checkInfo['yyq_url'];
				
				$this->view->setVar('indexData',$indexData);
			}
			
		}
// 		var_dump($tag);die;
		$this->view->setVar('tag',$tag);
		
		$this->view->pick("app/index_edit");
	}
	
	
	
}



?>