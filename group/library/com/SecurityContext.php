<?php
namespace Library\Com;

use phpCAS;
use Phalcon\DI;

/**
 * SSO登录后获取用户的相关信息。
 * 
 * @author evan
 *
 */
class SecurityContext {
	
	private static $_instance;
	
	/**
	 * 获取用户扩展的属性，如本系统相关的权限数据
	 * @return 
	 */
	public static function getExtUserAttributes() {
		$user = self::getCurrentUser();
		if (!$user)
			return false;
		
		$username = $user['username'];
		$di = DI::getDefault();
		$json = $di->getGroup()->fetchColumn("select privs from admin_priv_list where username = '$username'",\Phalcon\Db::FETCH_ASSOC);
		if (!$json)
			return false;
		
		$privs = json_decode($json, true);
		$list = array();
		foreach ($privs as $priv) {
			$detail = $di->getGroup()->fetchOne("select group_name, name, value from admin_priv_detail where id = $priv",\Phalcon\Db::FETCH_ASSOC);
			$list[$detail['group_name']][] = $detail['value'];
		}
		return $list;
	}
	
	/**
	 * 用户能访问的系统。
	 * @return array of object
	 * e.g.:
	 * [{"createTime":null,"createdBy":null,"isDeleted":null,"objVersion":null,"updateTime":null,"updatedBy":null,"id":1,"code":"SYS_SCHEDULER","title":"定时任务管理","type":0,"parentId":null,"orderNum":null,"iconClass":null,"url":"#","systemName":"SYS_SCHEDULER"},{"createTime":null,"createdBy":null,"isDeleted":null,"objVersion":null,"updateTime":null,"updatedBy":null,"id":15,"code":"SYS_BASE","title":"基础系统","type":0,"parentId":null,"orderNum":null,"iconClass":null,"url":"#","systemName":"SYS_BASE"},{"createTime":null,"createdBy":null,"isDeleted":null,"objVersion":null,"updateTime":null,"updatedBy":null,"id":40,"code":"SYS_SMS","title":"短信发送管理","type":0,"parentId":null,"orderNum":null,"iconClass":"","url":"#","systemName":"SYS_SMS"}]
	 */
	public static function getUserSystems() {
		$user = self::getCurrentUser();
		if (!$user)
			return false;
		
		return json_decode(phpCAS::getAttributes()['systems'], true);
	}
	
	/**
	 * 
	 * @param unknown $systemCode
	 * @return array
	 */
	public static function getSystemMenu($systemCode) {
		$user = self::getCurrentUser();
		if (!$user)
			return false;
		
		// system id
		$systems = self::getUserSystems();
		if (!$systems)
			return false;
		
		$sysId = false;
		foreach ($systems as $sys) {
			if ($sys['code'] == $systemCode)
				$sysId = $sys['id'];
		}
		if (!$sysId)
			return false;
		
		return json_decode(phpCAS::getAttribute('menu'), true)[$sysId];
	}
	/**
	 * 当前用户是否有某个按钮权限
	 * @param string $operationCode
	 * @return boolean
	 */
	public static function hasPermission($operationCode) {
		$user = self::getCurrentUser();
		if (!$user)
			return false;
		
		$ops = self::getUserOperations();
		foreach ($ops as $op) {
			if ($op == $operationCode)
				return true;
		}
		return false;
	}
	
	/**
	 * 用户可操作的按钮操作。
	 * @return array
	 */
	public static function getUserOperations() {
		$user = self::getCurrentUser();
		if (!isset($user))
			return;
		
		$ret = [];
		foreach (json_decode(phpCAS::getAttribute('operations'), true) as $value) {
			$ret[] = $value['code'];
		}
		return $ret;
	}
	
	/**
	 * Get current login user object as Array, e.g.:
	 * {"createTime":"2015-10-22 11:51:42","createdBy":null,"isDeleted":false,"objVersion":0,"updateTime":"2015-10-22 11:52:12","updatedBy":null,"id":1,"username":"admin","authenticator":"f6fdffe48c908deb0f4c3bd36c032e72","fullName":"Admin","firstName":"Admin","lastName":"Admin","email":null,"mobile":null,"telephone":null,"officeLocation":null,"loginFailedCount":null,"departmentId":1,"status":true}
	 * @return false|array
	 */
	public static function getCurrentUser() {
		try {
			$username = phpCAS::getUser();
		} catch (\CAS_OutOfSequenceBeforeClientException $e) {
			return false;
		}
		// login timeout
		if (!isset($username))
			return false;

		return json_decode(phpCAS::getAttribute('sysUser'), true);
	}
	
	/**
	 * Get current user's role ids in array. 
	 * e.g.: ["1", "2"]
	 * @return false|array
	 */
	public static function getCurrentRoles() {
		try {
			$username = phpCAS::getUser();
		} catch (\CAS_OutOfSequenceBeforeClientException $e) {
			return false;
		}
		// login timeout
		if (!isset($username))
			return false;
		
		$ret = [];
		foreach (json_decode(phpCAS::getAttribute('roles'), true) as $value) {
			$ret[] = $value['authority'];
		}
		return $ret;
	}
	
	/**
	 * Get current username.
	 * @return false|string
	 */
	public static function getCurrentUsername() {
		$user = self::getCurrentUser();
		if (!$user)
			return false;
		
		return $user['username'];
	}
	
	public static function getAuthorizationData() {
		$user = self::getCurrentUser();
		if (!isset($user))
			return;
		
		return json_decode(phpCAS::getAttribute('authorizationData'), true);
	}
}