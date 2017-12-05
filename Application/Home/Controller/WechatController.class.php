<?php 
//此文件作为与微信交互的前端控制器
namespace Home\Controller;
use Think\Controller;

class WechatController extends Controller{
    private $userObj;
    public function __construct(){
        parent::__construct();
        $this->appid = C("APPID");
        $this->appsecrete = C("APP_SECRETE");
        $this->userObj    = D("User");
    }
    
    //微信消息入口
    public function index(){
        
    }
    
    //得到菜单
    public function getmenu(){
        $accesstoken = $this->getAccesstoken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$accesstoken";
        $res = file_get_contents($url);
        var_dump($res);die;   
    }
    
    //授权回调页面
    public function authorize(){
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
        } else {
            echo 'NO CODE';
            die;
        }

        if ($code) {
            $accessTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecrete."&code={$code}&grant_type=authorization_code";
            $accessTokenRes = file_get_contents($accessTokenUrl);

            if ($accessTokenRes) {
                $accessTokenArr = json_decode($accessTokenRes,true);
                if (!$accessTokenArr['errorcode']){
                    $openid = $accessTokenArr['openid'];
                    $accessToken = $accessTokenArr['access_token'];
                    $userInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang=zh_CN";
                    $userInfo = json_decode(file_get_contents($userInfoUrl),true);
                    if ($userInfo){
                        $userIfExists = $this->userObj->userIfExists($openid);
                        if (!$userIfExists){
                            unset($userInfo['privilege']);
                            $this->userObj->addUser($userInfo);
                        }
                        cookie("userid",$openid,86400*30);
                        $backurl = cookie("auth_back_url");
                        cookie("auth_back_url",null);
                        //如果没有  
                        header("Location:http://$backurl");
                        die;
                    }
                } else {
                    echo $accessTokenArr['errorcode'];
                    die;
                }
            } else {
                echo '网络错误';
                die;
            }    
        } else {
            echo '系统错误';
            die;
        }
    }
    
    //获取accesstoken
    public function getAccesstoken(){
        if (S("wechat_accesstoken") && false){
            return S("wechat_accesstoken");
        }else{
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecrete;
            $res = json_decode(file_get_contents($url),true);
            if ($res){
                $token = $res['access_token'];
                $expire = time() + $res['expire_in'] - 1000;
                S("wechat_accesstoken",$token,$expire);
                return $token;
            }else{
                var_dump($res);die; 
            }
        }
    }
    
    //发送客服消息
    public function sendCustomerMsg(){
        if (!$touserid) $touserid = "o4d8FwnnbIQoZlzdkmdqwJbl9J38";
        $accessToken = $this->getAccesstoken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
        $data = array(  
           "touser"=>"{$touserid}",
           "template_id"=>'Tc8eUlas1mpqfbjOtCxbVpUaFXg0l6gaydUi3hSfiLw',
           "url"=>"http://www.tjzsyl.com",  
           "topcolor"=>"#FF0000",
           "data"=> array(
                   "first"=> array(
                       "value"=>"您的预约被取消了！",
                       "color"=>"#173177"
                   ),
                   "keyword1"=>array(
                       "value"=>"巧克力",
                       "color"=>"#173177"
                   ),
                   "keyword2"=> array(
                       "value"=>"39.8元",
                       "color"=>"#173177"
                   ),
                   "keyword3"=>array(
                       "value"=>"2014年9月22日",
                       "color"=>"#173177"
                   ),
               "keyword4"=>array(
                   "value"=>"2014年9月22日",
                   "color"=>"#173177"
               ),
               "keyword5"=>array(
                   "value"=>"2014年9月22日",
                   "color"=>"#173177"
               ),
                   "remark"=>array(
                       "value"=>"欢迎再次购买！",
                       "color"=>"#173177"
                   )
           )
       );
       
        $header = array("Content-type: application/json");// 注意header头，格式k:v
        $arrParams = json_encode($data);
        $ret = json_decode(httpPostRequest($url,$arrParams,$header),true);
        if ($ret['errorcode'] == 0){
            echo 'success';
        }
    }
}
?>