<?php

header("Content-type: text/javascript");

require 'keys.php';

$path_info = explode('/', $_SERVER['PATH_INFO']); // calling through gists.php/id/rev, where id == [1], rev ==  [2]

$params = array();
foreach($path_info as $arg) {
        if(!empty($arg)) {
                $params[] = filter_var($arg, FILTER_SANITIZE_STRING);
        }
}

if(count($params) >= 1) {
        $url = 'https://api.github.com/gists/'.implode('/', $params);
        header('X-WebPlatform-Requested: '.$url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Dabblet/1.0.7 Code.WebPlatform.org Contact: renoir@w3.org');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Origin: http://code.webplatform.org',
                'Authorization: token '.$long_term_token
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
}
