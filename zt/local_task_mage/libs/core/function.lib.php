<?php
function  Directory( $dir ){    
     return   is_dir ( $dir )  or  (Directory(dirname( $dir ))  and   mkdir ( $dir , 0777));
} 

/**
 * 是否是AJAX提交的
 */
function isAjax(){
  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    return true;
  }else{
    return false;
  }
}

/**
 * 是否是GET提交的
 */
function isGet(){
  return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

/**
 * 是否是POST提交
 * @return int
 */
// && checkurlHash($GLOBALS['verify'])
function isPost() {
  return ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? 1 : 0;
}

function getmonsun(){
    $curtime=time();

    $curweekday = date('w');
    //为0是 就是 星期七
    $curweekday = $curweekday?$curweekday:7;
    $curmon = $curtime - ($curweekday-1)*86400;
    $cursun = $curtime + (7 - $curweekday)*86400;
    $cur['mon'] = $curmon;
    $cur['sun'] = $cursun;
    return $cur;
}

/**
 * 分页函数
 *
 * @param int $total 总条目
 * @param int $page	当前页码
 * @param int $pagesize 每页条数
 * @param int $offset 页码显示数量控制（n*2+1）
 * @param string $url 基础URL
 * @param bool $mode 是否转义
 * @return string
 */
function pages($total, $page = 1, $pagesize = 20, $offset = 2, $url = null, $mode = false)
{
    if($total <= $pagesize) return '';
    $page = max(intval($page), 1);
    $pages = ceil($total/$pagesize);
    $page = min($pages, $page);
    $prepage = max($page-1, 1);
    $nextpage = min($page+1, $pages);
    $from = max($page - $offset, 2);
    if ($pages - $page - $offset < 1) $from = max($pages - $offset*2 - 1, 2);
    $to = min($page + $offset, $pages-1);
    if ($page - $offset < 2) $to = min($offset*2+2, $pages-1);
    $more = 1;
    if ($pages <= ($offset*2+5))
    {
        $from = 2;
        $to = $pages - 1;
        $more = 0;
    }
    $str = '';
    $str .= '<li><a href="'.pages_url($url, $prepage, $mode).'">上一页</a></li>';
    $str .= $page == 1 ? '<li><a href="'.pages_url($url, 1, $mode).'" class="now">1</a></li>' : '<li><a href="'.pages_url($url, 1, $mode).'">1'.($from > 2 && $more ? '...' : '').'</a></li>';
    if ($to >= $from)
    {
        for($i = $from; $i <= $to; $i++)
        {
            $str .= $i == $page ? '<li><a href="'.pages_url($url, $i, $mode).'" class="now">'.$i.'</a></li>' : '<li><a href="'.pages_url($url, $i, $mode).'">'.$i.'</a></li>';
        }
    }
    $str .= $page == $pages ? '<li><a href="'.pages_url($url, $pages, $mode).'" class="now">'.$pages.'</a></li>' : '<li><a href="'.pages_url($url, $pages, $mode).'">'.($to < $pages-1 && $more ? '...' : '').$pages.'</a></li>';
    $str .= '<li><a href="'.pages_url($url, $nextpage, $mode).'">下一页</a></li>';
    return $str;
}

function pages3536($total, $page = 1, $pagesize = 20, $offset = 2, $url = null, $mode = false)
{
    if($total <= $pagesize) return '';
    $page = max(intval($page), 1);
    $pages = ceil($total/$pagesize);
    $page = min($pages, $page);
    $prepage = max($page-1, 1);
    $nextpage = min($page+1, $pages);
    $from = max($page - $offset, 2);
    if ($pages - $page - $offset < 1) $from = max($pages - $offset*2 - 1, 2);
    $to = min($page + $offset, $pages-1);
    if ($page - $offset < 2) $to = min($offset*2+2, $pages-1);
    $more = 1;
    if ($pages <= ($offset*2+5))
    {
        $from = 2;
        $to = $pages - 1;
        $more = 0;
    }
    $str = '';
    $str .= '<a href="'.pages_url($url, $prepage, $mode).'">上一页</a>';
    $str .= $page == 1 ? '<a href="'.pages_url($url, 1, $mode).'" class="cur">1</a>' : '<a href="'.pages_url($url, 1, $mode).'">1'.($from > 2 && $more ? '...' : '').'</a>';
    if ($to >= $from)
    {
        for($i = $from; $i <= $to; $i++)
        {
            $str .= $i == $page ? '<a href="'.pages_url($url, $i, $mode).'" class="cur">'.$i.'</a>' : '<a href="'.pages_url($url, $i, $mode).'">'.$i.'</a>';
        }
    }
    $str .= $page == $pages ? '<a href="'.pages_url($url, $pages, $mode).'" class="cur">'.$pages.'</a>' : '<a href="'.pages_url($url, $pages, $mode).'">'.($to < $pages-1 && $more ? '...' : '').$pages.'</a>';
    $str .= '<a href="'.pages_url($url, $nextpage, $mode).'">下一页</a>';
    return $str;
}

/**
 * 生成分页URL
 *
 * @param string $url 基础URL
 * @param int $page 分页页码
 * @param boolean $mode 是否转义
 * @return string
 */
function pages_url($url, $page, $mode = false)
{
    if (!$url) $url = URL;
    if (strpos($url, '$page') === false)
    {
        $url = url_query($url, array('page'=>$page), $mode);
    }
    else
    {
        eval("\$url = \"$url\";");
    }
    return $url;
}


/**
 * 生成带参数的URL
 *
 * @param string $url 基础url
 * @param array $query 参数
 * @param bool $mode 是否转义
 * @return string
 */
function url_query($url, $query = array(), $mode = false)
{
    if ($query)
    {
        $data = parse_url($url);
        if (!$data) return false;
        if (isset($data['query']))
        {
            parse_str($data['query'], $q);
            $query = array_merge($q, $query);
        }
        $data['query'] = http_build_query($query);
        $url = http_build_url($data, $mode);
    }
    return $url;
}

/**
 * 根据数组创建URL
 *
 * @param array $data
 * @param bool $mode 是否转义
 * @return string
 */
function http_build_url($data, $mode = false)
{
    if (!is_array($data)) return false;
    $url = isset($data['scheme']) ? $data['scheme'].'://' : '';
    if (isset($data['user'])) $url .= $data['user'];
    if (isset($data['pass'])) $url .= ':'.$data['pass'];
    if (isset($data['user'])) $url .= '@';
    if (isset($data['host'])) $url .= $data['host'];
    if (isset($data['port'])) $url .= ':'.$data['port'];
    if (isset($data['path'])) $url .= $data['path'];
    if (isset($data['query'])) $url .= '?'.($mode ? str_replace('&', '&amp;', $data['query']) : $data['query']);
    if (isset($data['fragment'])) $url .= '#'.$data['fragment'];
    return $url;
}

// 获取任务状态的小方法
function taskStatus()
{
	return $GLOBALS['db']->get("tc_task_statu");
}

// 获取任务状态的小方法
function getTask()
{
	return $GLOBALS['db']->get("tc_task",null,'id,task_name');
}

// 获取用户的小方法
function getAllUser()
{
	return $GLOBALS['db']->get("tc_user",null,'id,name');
}
// 解析URL参数
function convertUrlQuery($query)
{
    $pos1 = strpos($query, '?');
    if($pos1!==false) {
        $query = substr($query, $pos1+1);
    }

    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}