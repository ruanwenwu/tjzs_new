<?php
include_once 'aliyun-php-sdk-core/Config.php';
use vod\Request\V20170321 as vod;
$regionId = 'cn-shanghai';
$access_key_id = "LTAInydAA57dVOCE";
$access_key_secret="WE8cAr64vsUziEwmwXjOs8Qi74cylx";
$videoId = '92f6aebef9784b9bb23c745dfe0cb74f';
$client = init_vod_client($access_key_id,$access_key_secret);
$res = get_play_info($client,$videoId);
var_dump($res);die;
function init_vod_client($accessKeyId, $accessKeySecret) {
  $regionId = 'cn-shanghai';  // 点播服务所在的Region，国内请填cn-shanghai，不要填写别的区域
  $profile = DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);
  return new DefaultAcsClient($profile);
}
function get_play_info($client, $videoId) {
  $request = new vod\GetPlayInfoRequest();
  $request->setVideoId($videoId);
  $request->setAcceptFormat('JSON');
  return $client->getAcsResponse($request);
}
