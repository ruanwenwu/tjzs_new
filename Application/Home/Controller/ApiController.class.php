<?php 
namespace Home\Controller;
use Think\Controller;

class ApiController extends Controller{
    const AUTHCODE = "D1B2CDC4";
    const API_HOST = "http://60.205.187.164/";    //去掉8080即使线上环境

    /*public function __construct(){
        $username = $_GET['username'];
        $passwd   = $_GET['password'];
        
        if ($username != "ruanwenwu" || $passwd != "chillylips88") exit("no rights");
    }*/

    //获取权限
    public function getPermitionParams($force=false){
        $accessInfo = S("accessInfo");
   
        if ($accessInfo && !$force) {   
            return $accessInfo;
        }   

        $url = self::API_HOST."api/account/login";
        $data = array(
            'AuthCode'  =>  self::AUTHCODE,
        );  
        $data = http_build_query($data);

        $header = array(
            'Content-type:application/x-www-form-urlencoded',
        );
        $res = httpPostRequest($url,$data,$header);
        $res = json_decode($res,true);
        if ($res['result'] == "00000000"){
            $expireTime = $_SERVER['REQUEST_TIME'] + $res['data']['expires_in'] - 300;
            $cacheTime  = $res['data']['expires_in'] - 300;
            $token = $res['data']['access_token'];
            S("accessInfo",$res['data'],$cacheTime);
        } else { 
            var_dump($res);
            die;
        }
          
        return $res['data'];
    }

    //获取医院信息
    public function syncHospitalInfo(){
        //清空原来的数据
        $sql = "truncate zs_hospital";
        M("hospital")->execute($sql);   
        /*ini_set("display_errors","on");
        error_reporting(E_ALL);
        */
        $accessTokenInfo = $this->getPermitionParams(true);
        $url = self::API_HOST."api/sync/hospital";
        $data = array(
            'TPID'  =>  $accessTokenInfo['TPID'],
        );

        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);

        if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,

            foreach ($res['data']['rows'] as $key => $val){
                $data = array(
                    "tpid"  => $accessTokenInfo['TPID'],
                    "mtime" => $_SERVER['REQUEST_TIME'],
                    'hid'   => $val['HID'],
                    'hospitalname' => $val['HospitalName'],
                );
                //添加数据
                M("hospital")->add($data);
            }   
        } else {
            echo 33;die;
            var_dump($res);
            die;
        }
    }
    
    //同步科室信息
    public function syncDepartmentInfo(){
        //清空原来的数据     
        $sql = "truncate zs_department";
        M("department")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/dept";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_department (tpid,hid,deptid,deptname,isenabled,mtime,branchname,ordernum,branchtype) values ";
        foreach ($hospitalInfo as $hk => $hv){          
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    //echo '<pre>';
                    //var_dump($val);die; 
                    if(preg_match("/北院/",$val['BranchName'])){
                        $branchType = 1;
                    }else if(preg_match("/南院/",$val['BranchName'])){
                        $branchType = 2;
                    }else{
                        $branchType = 0;
                    }
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DeptID']}','{$val['DeptName']}',{$val['IsEnabled']},{$_SERVER['REQUEST_TIME']},'{$val['BranchName']}','{$val['OrderNum']}','{$branchType}'),";
                }
            } else {
                //var_dump($res);
                //die;
            }
        }
        $insertSql = rtrim($insertSql,",");       
        return M("department")->execute($insertSql);
    }
    
    //同步医生信息
    public function syncDoctorsInfo(){
        //清空原来的数据       
        $sql = "truncate zs_doctor";
        M("doctor")->execute($sql);  
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/doctor";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_doctor (tpid,hid,docid,doctorname,doctorlevel,photourl,isenabled) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );       
            $res = json_decode(httpPostRequest($url,$data,$header),true);           
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DocID']}','{$val['DoctorName']}','{$val['DoctorLevel']}','{$val['PhotoUrl']}','{$val['IsEnabled']}'),";
                }
            } else {
                //var_dump($res);
                //die;
            }
        }
        $insertSql = rtrim($insertSql,",");
        //echo $insertSql;die;
        return M("department")->execute($insertSql);
    }
    
    //同步医生科室关系
    public function syncDocDepRelation(){
        //清空原来的数据     
        /*$sql = "truncate zs_docanddep";
        M("docanddep")->execute($sql);*/
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/doctoranddept";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_docanddep (tpid,hid,deptid,docid,isenabled,ctime,specialty,ordernum,introduction) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DeptID']}','{$val['DocID']}',{$val['IsEnabled']},{$_SERVER['REQUEST_TIME']},'{$val['Specialty']}','{$val['OrderNum']}','{$val['Introduction']}'),";
                }
            } else {
                var_dump($res);
                die;
            }  
        }
        $insertSql = rtrim($insertSql,",");
        return M("department")->execute($insertSql);
    }

    //同步号别信息
    public function syncVisitType(){
        //清空原来的数据     
        $sql = "truncate zs_visittype";
        M("visittype")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/visittype";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
    
        $insertSql = "insert into zs_visittype (tpid,hid,visittypeid,visitname,regfee,inspectfee,ctime,cost) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );

            $res = json_decode(httpPostRequest($url,$data,$header),true);
       
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['VisitTypeID']}','{$val['VisitName']}',{$val['RegFee']},'{$val['InspectFee']}',{$_SERVER['REQUEST_TIME']},'{$val['Cost']}'),";
                }
            } else {
                var_dump($res);
                die;   
            }
        }
        $insertSql = rtrim($insertSql,",");
        return M("department")->execute($insertSql);
    }
    
    //同步出诊信息
    public function syncVisitReal(){
        //清空原来的数据     
        //$sql = "truncate zs_visitreal";
        //M("visitreal")->execute($sql);  
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/visitreal";               
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        $insertSql = "insert into zs_visitreal (tpid,hid,realid,visitdate,week,apw,docid,deptid,visittypeid,isenabled) values ";
        foreach ($hospitalInfo as $hk => $hv){
            //获得需要同步的日期
            $days = $this->getNeedSyncVisitTypeDays();
            if (!$days) {
                return false;
            }
            foreach($days as $day){
                $data = array(
                    'TPID'  =>  $hv['tpid'],
                    'Hid'   =>  $hv['hid'],
                    'VisitDate'=>$day,
                );  
                $data = http_build_query($data);
                $header = array(
                    'Content-type:application/x-www-form-urlencoded',
                    'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
                );
                $res = json_decode(httpPostRequest($url,$data,$header),true);
                if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                    $goon = true;
                    foreach ($res['data']['rows'] as $key => $val){
                        $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['RealID']}','$day',{$val['Week']},'{$val['APW']}','{$val['DocID']}','{$val['DeptID']}','{$val['VisitTypeID']}','{$val['IsEnabled']}'),";
                    }
                } else {
                    //var_dump($res);   
                    //die;  
                }     
            }
        }
        if ($goon) {
            $insertSql = rtrim($insertSql,",");
            //echo $insertSql;die;  
            M("department")->execute($insertSql);
            //记录日志
            M("visittype_sync_log")->add(array("date"=>array_pop($days)));
        } else {  
            echo 'no data';
            var_dump($res);die;
        }
        //die;
    }
    
    //获得需要同步的日期
    public function getNeedSyncVisitTypeDays(){
        $today = date("Y-m-d");
        $sevenDaysLater = date("Y-m-d",strtotime("+7 days"));
        //获得日志表里最后一条记录
        $res = M("visittype_sync_log")->order("id desc")->find();
        if ($res) {
            $lastDate = $res['date'];
        } else {
            $lastDate = $today;
        }
        $return = array();

        while ($lastDate < $sevenDaysLater){
            $return[] = $lastDate = date("Y-m-d",strtotime($lastDate)+86400);
        }
        return $return;
    }
    
    //获得时段的剩余号数
    public function getRealTypeRemainNum($tpid,$hid,$realid){
        header("Content-type:text/html;charset=utf-8");
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/period";

        //获得医院信息
        $hospitalInfo = M("hospital")->where(array("hid"=>$hid))->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        $data = array(
            'TPID'  =>  $tpid,
            'Hid'   =>  $hid,
            'RealID'=>  $realid,//'7c23e6a8-3dfa-44e8-ba1c-843e7fa97ddf',
        );       
        $data = http_build_query($data);  
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );         

        $res = json_decode(httpPostRequest($url,$data,$header),true);
        /*if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
            return $res['data']['rows'];
        } else {
            var_dump($res);die;
            return false;
        }*/
        return $res;
    }

    //获取图片验证码
    public function getVerifyCode($tpid,$phone){
        if (!$tpid || !$phone) return false;
        
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/GetImageCode";
        $data = array(
            'TPID'  =>  $tpid,
            'PhoneNo'   =>  $phone,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000") {     //如果数据正常,
            return $res['data'];
        } else {
            return false;
        }
    }
    
    //获取短信验证码      
    public function getPhoneTextVerifyCode(){
        $tpid = I("post.tpid");
        $phone = I("post.phone");
        $picCode = I("post.picCode");
        if (!$tpid || !$phone || !$picCode) return false;
        
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/GetPhoneCode";
        $data = array(
            'TPID'  =>  $tpid,
            'PhoneNo'   =>  $phone,
            'PicCode'   =>  $picCode,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        $this->ajaxReturn($res);
    }

    //预约挂号接口
    public function appoint(){
        $tpid        = I("post.tpid");
        $hid         = I("post.hid");
        $phoneno     = I("post.phoneno");
        $idcard      = I("post.idcard");
        $uid         = I("post.uid");
        $periodname  = I("post.periodname");
        //$gidcard     = I("post.gidcard");
        $patientName = I("post.patientname");
        $patientSex  = I("post.patientsex");
        $realid      = I("post.realid");
        $periodid    = I("post.periodid");
        $verifyCode    = I("post.verifycode");
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/appoint";
        $data = array(
            'TPID'        =>  $tpid,
            'HID'         =>  $hid,
            'PhoneNo'     =>  $phoneno,
            'IDCard'      =>  $idcard,
            'PatientName' =>  $patientName,
            'PatientSex'  =>  $patientSex,
            'RealID'      =>  $realid,
            'PeriodID'    =>  $periodid,
            'VerifyCode'  =>  $verifyCode,
        );
        //echo '<pre>';
        //var_dump($data);die;
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000") {     //如果数据正常,
            $status = 1;
            $appointCode = $res['data']['AppointCode'];
        }else{
            $status = 2;
            $appointCode = "";
            //如果失败，记录失败原因
        }
        //写入挂号记录
        $logSql = "insert into `zs`.`zs_appointlog` ( `hid`, `realid`, `uid`, `tpid`, `ctime`,`period`,`status`,`appointcode`) values ( '$hid', '$realid', '$uid', '$tpid', '{$_SERVER['REQUEST_TIME']}','$periodname',$status,'$appointCode')";
        M("appointlog")->execute($logSql); 
        $id = M("appointlog")->getLastInsID();
        M("appointdetail")->add(array("appointid"=>$id,"message"=>$res['message'],"data"=>serialize($data)));
        $res['id'] = $id;
        //返回成功提醒
        $this->ajaxReturn($res);
    }
    
    //退预约
    public function cancelAppointment(){
        $tpid = I("post.tpid");
        $hid = I("post.hid");
        $appointCode = I("post.appointCode");
        if (!$tpid || !$hid || !$appointCode) return false;
    
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/backappoint";
        $data = array(
            'TPID'  =>  $tpid,
            'HID'   =>  $hid,
            'AppointCode'   =>  $appointCode,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000"){
            //更改预约状态为3
            M("appointlog")->where("appointcode='$appointCode'")->save(array("status"=>3));
        }
        $this->ajaxReturn($res);
    }  
    
    //获取出诊信息变更
    public function visitrealchange(){
             $hospitalInfo = M("hospital")->find();
             if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
            $accessTokenInfo = $this->getPermitionParams();
            $url = self::API_HOST."api/sync/visitrealchange";
            $data = array(
                'TPID'  =>  $hospitalInfo['tpid'],
                'HID'   =>  $hospitalInfo['hid'],
                'SearchTime'   =>  date("Y-m-d H:i:s",strtotime("-3 days")),
            );
            $data = http_build_query($data);
            //var_dump($data);die;
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){
                foreach ($res['data']['rows'] as $re) {
                    if ($re['ChangeType'] == 0 || $re['ChangeType'] == 1) {
                        //如果是开或者关，直接更新状态
                        M("visitreal")->where(array("realid"=>$re['RealID']))->save(array('isenabled'=>$re['ChangeType']));
                        if ($re['ChangeType'] == 0){
                            //如果是停诊，那么对预约了这些号的要发送消息
                        }
                    } else if ($re['ChangeType'] == 2) {
                        //如果是新增，添加到visitreal表中
                        //看realchange表中是否存在
                        if(!M("realchange")->find(array("realid"=>$re['RealID']))){
                            $data = array(
                                "tpid"     =>  $hospitalInfo['tpid'],
                                "hid"      =>  $hospitalInfo['hid'],
                                "realid"   =>  $re['RealID'],
                                "visitdate"=>  strstr($re['VisitDate'],"T",true),
                                "week"     =>  $re['Week'],
                                "apw"      =>  $re['APW'],
                                "docid"    =>  $re['DocID'],
                                "deptid"   =>  $re['DeptID'],
                                "visittypeid"=> $re['VisitTypeID'],
                                "isenabled"=>   $re['IsEnabled'],
                            );
                            M("visitreal")->add($data);
                            $sql = "insert into zs_realchange (`realid`,`changetype`,`date`) values ('{$re['RealID']}','{$re['ChangeType']}','{$data['visitdate']}') ";
                            M("realchange")->query($sql);
                       }
                    }      
                }
            }else{
                die();
            }
            //die;
    }
    
    //停改诊计划任务操作,每1个小时
    public function realchangeCrontab(){
        //执行时间延长
        set_time_limit(0); 
        $this->visitrealchange();
        $this->syncSevendaysAvailable();
        $this->syncEverydayAvailable();
    }
    
    //同步近7天内的科室的排班信息
    public function syncSevendaysAvailable(){
        //从明天开始的，7天内的排班信息
        //选出所有enabled的科室
        //遍历科室，统计7天内的科室，如果没有的话，update为0（从列表中去除）
        $depts = M("department")->where(array("isenabled"=>1))->select();
        $startDay = date("Y-m-d");
        $endDay   = date("Y-m-d",strtotime("+7 days"));
        foreach ($depts as $dep){
            $avl = M("visitreal")->where(array("deptid"=>$dep['deptid']))->where("visitdate > '$startDay' and visitdate <= '$endDay'")->count();
            //echo M("visitreal")->getLastSql();die;
            if (!$avl){
                //echo M("visitreal")->getLastSql();die;
                M("department")->where(array(array("deptid"=>$dep['deptid'])))->save(array("servendays"=>0));                
            }
        }  
    }
    
    //同步每天的排班情况
    public function syncEverydayAvailable(){
        $sql = "truncate zs_deptdayavl";
         M("visitreal")->execute($sql);
        
        $beginTime = strtotime("+1 day");
        $days = array();
        $depts = M("department")->where(array("isenabled"=>1))->select(); 
        $sql = "insert into zs_deptdayavl (deptid,status,date) values ";
        for ($i = 0; $i <= 6; $i++) {
            $nowDate = date("Y-m-d",$beginTime + 86400*$i);
            foreach ($depts as $dep) {
                $nowNum = M("visitreal")->where(array("visitdate"=>$nowDate,"isenabled"=>1,'deptid'=>$dep['deptid']))->count();
                //die(M()->getLastSql());
                $status = $nowNum > 0 ? 1 : 0;
                $sql .= "('{$dep['deptid']}',{$status},'{$nowDate}'),";
            }
        } 
        $sql = rtrim($sql,",");
        M("deptdayavl")->execute($sql);
    }
    
    //同步医生头像信息
    public function syncDocPicInfo(){
        $imgs = M("docimg")->select();
        if ($imgs && is_array($imgs)) {
            foreach ($imgs as $img) {
                M("doctor")->where(array("docid"=>$img['docid']))->save(array("photourl"=>$img['pic']));
                //echo M()->getLastSql();
                //die;
            }
        }
    }
    
    //每日同步
    public function syncEveryDay(){
        //执行时间延长
        set_time_limit(0); 
        //同步科室
        $this->syncDepartmentInfo();   
        //同步医生
        $this->syncDoctorsInfo();
        //同步医生和科室关系
        $this->syncDocDepRelation();
        //同步医生图片
        $this->syncDocPicInfo();
        //同步排班信息
        $this->syncVisitReal();
        //停掉停了的医生的出诊
        $this->disableDisabledDoctorVisit();
        //同步七天排班信息
        $this->syncSevendaysAvailable();
        //同步每天排班信息
        $this->syncEverydayAvailable();
    }
    
    public function tt(){
        echo 3;die;
    }

    //已经停诊的医生，他的所有排版信息要disenabled掉
    public function disableDisabledDoctorVisit(){
        //遍历医生表，查出disabled了的医生，把他们的排版停掉
        $disabledDoctors = M("doctor")->where(array("isenabled"=>0))->select();
        $docStr = "";
        foreach ($disabledDoctors as $doc){
            $docStr .= "'{$doc['docid']}',";
        }
        
        $docStr = rtrim($docStr, ",");
        $sql = "update zs_visitreal set isenabled = 0 where docid in ($docStr)";
        M("visitreal")->execute($sql);
    }

    //插入普通医生图片
    public function addPutongDocImg(){
        $doctors = M("doctor")->where("doctorname like '%科普通号'")->select();
        $insertSql = "insert into zs_docimg (docid,pic) values ";
        foreach ($doctors as $doc){
            $insertSql .= "('{$doc['docid']}','kouqiangputong.jpg'),";
        }
        echo $insertSql;die;
    }
}
?>