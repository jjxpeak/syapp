<?php
include_once './server/server.php';
define('APPLICATION_PATH', dirname(__FILE__));
server::run(APPLICATION_PATH . '/conf/application.ini', APPLICATION_PATH . '/conf/server.ini');
//$http = new swoole_http_server('0.0.0.0',80);
//$http -> on('request', function($request, $response){
//    $app = new Yaf_Application(APPLICATION_PATH . '/conf/application.ini');
//    $response->end($app-> bootstrap()->run());
//});
//
//$http -> on('close' ,function(){
//
//});
//
//$http ->start();
//$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
//
//$application->bootstrap()->run();