<?php
/**
 * 分页类
 */
namespace Library\Com;
class Page {
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter;
    // 分页URL地址
    public $url = '';
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow;
    // 分页总页面数
    protected $totalPages;
    // 总行数
    protected $totalRows;
    // 当前页数
    protected $nowPage;
    // 分页的栏的总页数
    protected $coolPages;
    // 分页显示定制
    protected $config = array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%','themes'=>'%totalRow% %header% %nowPage% %totalPage% %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
    // 默认分页变量名
    protected $varPage ;
	//自由选择每页显示记录数 页面显示
	public $page_lines = '【显示的行数】';

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows, $listRows='', $parameter='', $url='') {
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
		if(!empty($_GET['pagesize'])) {
            $this->listRows =   intval($_GET['pagesize']) < 1 ? 1 : (intval($_GET['pagesize']) > 500 ? 500 : intval($_GET['pagesize']));
        }
		
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if($this->nowPage<1){
            $this->nowPage  =   1;
        }elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        
        $pageStr = "";
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);

        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
//                 unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   '?p='.$parameter['p'];
			$parameter['pagesize']  =   '__PAGE_LINES__';
			$url2            =   '?p='.$parameter['p'];
        }
		if(!$this->url){
			//自由选择每页显示记录数 显示
			$page_line = array(10,20,50,100,200,500);
			foreach ($page_line as $val) {      
				if($this->listRows != $val){
					$this->page_lines .= "<a href='".str_replace('__PAGE_LINES__',$val,str_replace('__PAGE__',1,$url2))."'>".$val."</a>";               
				}else{               
					$this->page_lines .= "<span class='current'>".$val."</span>";              
				}
			}
		}
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $pageStr['upPage'] = str_replace('__PAGE__',$upRow,$url);//上一页
        }else{
            $pageStr['upPage'] = '';
        }

        if ($downRow <= $this->totalPages){
            $pageStr['downPage']   =   str_replace('__PAGE__',$downRow,$url);//下一页
        }else{
            $pageStr['downPage']   =   '';
        }
        // << < > >>
        if($nowCoolPage == 1){
            $pageStr['theFirst']   =   '';
            $pageStr['prePage']['url']   =   '';
            $pageStr['prePage']['rollPage']   =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
            $pageStr['prePage']['url']    =   str_replace('__PAGE__',$preRow,$url);//上？页
//             $pageStr['prePage']['rollPage']  =  '上 '.$this->rollPage.' 页';
            $pageStr['prePage']['rollPage']  =  '...';
            $pageStr['theFirst']   =   str_replace('__PAGE__',1,$url);//第一页
        }
        if($nowCoolPage == $this->coolPages){
            $pageStr['nextPage']['url']   =   '';
            $pageStr['nextPage']['rollPage']   =   '';
            $pageStr['theEnd']     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
            $pageStr['nextPage']['url']   =   str_replace('__PAGE__',$nextRow,$url);//下？页
//             $pageStr['nextPage']['rollPage']  =  '下 '.$this->rollPage.' 页';
            $pageStr['nextPage']['rollPage']  =  '...';
            $pageStr['theEnd']     =   str_replace('__PAGE__',$theEndRow,$url);//最后一页
        }
        // 1 2 3 4 5
        $pageStr['linkPage'] = '';
        for($i=1;$i<=$this->rollPage;$i++){
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $pageStr['linkPage'][$page]= str_replace('__PAGE__',$page,$url);
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $pageStr['linkPage'][$page]= '';
                }
            }
        }
        $pageStr['totalRows'] = $this->totalRows;
        return $pageStr;
    }
}
?>