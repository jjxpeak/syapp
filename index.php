<?php
include_once './server/server.php';
define('APPLICATION_PATH', dirname(__FILE__));
server::run(APPLICATION_PATH . '/conf/application.ini', APPLICATION_PATH . '/conf/server.ini');