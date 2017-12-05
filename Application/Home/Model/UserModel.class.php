<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model{
    //查询用户
    public function getUsers($param){
        $option = array(
            "page"      =>  1,
            "pageSize"  =>  10,
        );
        
        if (is_array($param)) $option = array_merge($option,$param);
        
        extract($option);
        $start = ($page - 1)*$pageSize;
        $users = M("user")->select();
        return $users;
    }

    //查看用户是否存在,如果存在获取用户信息
    public function userIfExists($openid){
        if (!$openid) return false;

        $res = M("user")->where(array("openid"=>$openid))->find();
        return $res;
    }

    public function addUser($data){
        if (!$data || !is_array($data)) return false;
        
        return M("user")->add($data);
    }
}