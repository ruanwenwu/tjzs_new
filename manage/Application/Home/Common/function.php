<?php
function checkLogin($backurl){
    if(!session("hospital_login")){
        $baseUrl = C("BASE_URL");
        $backurl = urlencode($backurl);
        header("Location:{$baseUrl}manage/index.php?m=home&c=login&a=login&backurl=$backurl");
        die;
    }
}