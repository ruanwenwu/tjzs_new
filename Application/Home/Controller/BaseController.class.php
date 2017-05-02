<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {

    public function __construct(){
        $userid = $_COOKIE['userid'];
        /*if (!$userid) {
            //调到授权页面
            echo '跳到授权页面';
            die;
        }*/
    }
}