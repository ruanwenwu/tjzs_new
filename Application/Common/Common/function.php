<?php
/*
 * 将数组转化成字符串
 */
function changeArrToStr($docs){
    $docstr = "";
    
    foreach ($docs as $doc) {
        $docstr .= "'$doc',";
    }
    $docstr = rtrim($docstr,",");
    return $docstr;
}

/**
 * 查询in类查询，并转换成响应的键
 */
function getResByKey($docsInfos,$key){
    foreach ($docsInfos as $docsInfo) {
        $resdocsInfos[$docsInfo[$key]] = $docsInfo;
    }
    unset($docsInfos);
    return $resdocsInfos;
}

/**
 * 根据键值排序
 * @author rww
 */
function sortbyorder($a,$b){
    if ($a['ordernum'] < $b['ordernum']){
        return -1;
    } else if ($a['ordernum'] > $b['ordernum']){
        return 1;
    } else{      
        return 0;
    }
}