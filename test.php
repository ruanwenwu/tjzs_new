<?php
$cookie = getWebCookie('https://zhidao.baidu.com');
$url = 'https://zhidao.baidu.com/question/711848434416830725.html?fr=iks&word=%B5%E7%BB%B0%CB%A4%C1%CB%BA%DA%C6%C1%D4%F5%C3%B4%BB%D8%CA%C2&ie=gbk';
$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36';

$content = curlGet(array(
    'url'      => $url,
    'timeout'  => 10,
    'useragent'=> $userAgent,
    'cookie'   => $cookie,
));

echo $content;die;
//内容与浏览器访问的内容不一样，数据错乱，在最佳答案哪里



/**
     *  利用curl GET数据
     */
    function curlGet($paramArr){
        $options = array(
            'url'      => false, #要请求的URL数组
            'timeout'  => 5,#超时时间 s
            'cookie'   => '',//cookie
            'useragent'=> '',//用户代理信息
            'jump'     => false,//是否允许跳转抓取false：否，true：是
            'headBtn'  => false,//是否获取头信息false：否，true:是
            'proxy'    => '',//代理服务器
            'header'   => '',//伪造头信息
        );
        if (is_array($paramArr))$options = array_merge($options, $paramArr);
        extract($options);
        if (!$url || !$timeout) {
            return false;
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        if ($proxy) {
            curl_setopt ($ch, CURLOPT_PROXY, $proxy);
        }
        if ($headBtn) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($header) {
            curl_setopt ($ch, CURLOPT_HTTPHEADER , $header );
            curl_setopt( $ch, CURLOPT_HEADER, 1);
        }
        if ($jump) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($useragent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");//解决中文乱码
    
        $data = curl_exec($ch);
        curl_close($ch);
    
        return $data;
    }

/**
     * 获取页面的cookie
     * 
     * @param $url 链接地址
     */
    function getWebCookie($url)
    {
        if (!$url) {
            return false;
        }
        $ch =curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        preg_match('/^Set-Cookie: (.*?);/m',curl_exec($ch),$m);
        $rs = parse_url($m[1]);
        $cookie = $rs['path'];
    
        return $cookie;
    }
