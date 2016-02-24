<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/3
 * Time: 11:02
 */

class Role{
	    protected $permission;

	    public function __construct(){
            $this->permission = array();
	    }

	    // 返回一个综合权限的对象
	    public static function getRolePerms($role_id){
            $role = new Role();
	        $sql = "SELECT t2.perm_name FROM auth_role_perm as t1
	                LEFT JOIN auth_permissions as t2 ON t1.perm_id = t2.perm_id
                    AND t1.role_id = ?";

            $param = array($role_id);
            $resutls = $GLOBALS['db']->rawQuery ($sql, $param);
	        return $resutls;
	    }

	    // 检查是否具有权限
	    public function hasPerm($permission){
             return isset($this->permission[$permission]);
	    }

        // 添加权限
        public static function insertRole($role_name){
            $inputData = array('role_name'=> $role_name);
            $id = $GLOBALS['db']->insert('auth_roles', $inputData);
            return $id;
        }

        // 为用户添加角色
        public static function insertUserRoles($user_id, $roles){
            $status = array();
            if(is_array($roles)) {
                foreach($roles as $roleId) {
                    $inputData = array('user_id'=>$user_id,'role_id'=> $roleId);
                    $status[] = $GLOBALS['db']->insert('auth_roles', $inputData);
                }
            }
            else {
                $inputData = array('user_id'=>$user_id,'role_id'=> $roles);
                $status [] = $GLOBALS['db']->insert('auth_roles', $inputData);
            }
            return $status;
        }

        // 删除角色和相关权限
        public static function deleteRoles($roles) {
            $rsStatus = array();
            if(is_array($roles)) {
                foreach ($roles as $role_id) {
                    $countParams = array($role_id);
                    $sql = "DELETE t1, t2, t3 FROM auth_roles as t1
                    JOIN auth_user_role as t2 on t1.role_id = t2.role_id
                    JOIN auth_role_perm as t3 on t1.role_id = t3.role_id
                    WHERE t1.role_id = ?";

                    $rsStatus[] = $GLOBALS['db']->rawQuery ($sql, $countParams);
                }
            }
            else {
                $countParams = array($roles);
                $sql = "DELETE t1, t2, t3 FROM auth_roles as t1
                    JOIN auth_user_role as t2 on t1.role_id = t2.role_id
                    JOIN auth_role_perm as t3 on t1.role_id = t3.role_id
                    WHERE t1.role_id = ?";

                    $rsStatus[] = $GLOBALS['db']->rawQuery ($sql, $countParams);
            }
        }

        // 删除用户的角色
        public static function deleteUserRoles($user_id) {
            $GLOBALS['db']->where('user_id', $user_id);
            return  $GLOBALS['db']->delete('auth_user_role');
        }
	}