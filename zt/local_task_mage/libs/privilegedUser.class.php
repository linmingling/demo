<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/3
 * Time: 11:50
 */

class PrivilegedUser extends  User{
    private $roles;

    public function __construct(){
        parent::__construct();
    }

    public static function getByUsername($username){
        $GLOBALS['db']->where ("name", $username);
        $result = $GLOBALS['db']->getOne ("tc_user");

        if(!empty($result)){
            $privUser = new PrivilegedUser();
            $privUser->user_id = $result["id"];
            $privUser->username = $username;
            //$privUser->password = $result["password"];
            $privUser->email = $result["email"];
            $privUser->initRoles();
            return $privUser;
        }else {
            return FALSE;
        }
    }


    // 获取角色，并得到相关权限
    protected function initRoles(){
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM auth_user_role AS t1
	                JOIN auth_roles AS t2 ON t1.role_id = t2.role_id
	                AND t1.user_id = ? ";

        $param = array($this->user_id);
        $resutls = $GLOBALS['db']->rawQuery ($sql, $param);

        foreach($resutls as $row) {
            $this->roles[$row['role_name']] = Role::getRolePerms($row["role_id"]);
        }
    }

    // 检查用户是否具有特殊角色
    public function hasRole($role_name) {
        return isset($this->roles[$role_name]);
    }

    // 添加一个权限
    public static function insertPerm($role_id, $perm_id) {
        $inputData = array('perm_id'=> $perm_id);
        $id = $GLOBALS['db']->insert('auth_role_perm', $inputData);
        return $id;
    }

    // 删除所有权限角色
    public static function deletePerms() {
        $sql = "TRUNCATE role_perm";
        return $GLOBALS['db']->rawQuery ($sql);
    }
}

class User{
    protected $user_id;
    protected $username;
    protected $password;
    protected $email;

    public function __construct()
    {

    }

}