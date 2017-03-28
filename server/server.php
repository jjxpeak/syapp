<?php
/**
 * Created by PhpStorm.
 * @User: jiajx
 * @Email:jjx01234@126.com
 * @Date: 2017/3/27
 * @Time: 14:05
 * @File: server.php
 */


class server
{
    public static $_server;
    private $app;
    private $serverip = '0.0.0.0';
    private $serverport = '80';
    private $serveConfigArr = array();
    private $serverObj;

    private function __construct($appIni, $serveIni = null)
    {
        if (!is_file($appIni) && pathinfo($appIni, 4) == 'ini'){
            //TODO:配置文件不存在的话返回错误和1001;
            throw new \Yaf_Exception_LoadFailed('app配置文件错误:'.$appIni, 1001);
        }
        if (is_file($serveIni)){
            switch (pathinfo($serveIni,4)){
                case 'ini':
                    $this->serveConfigArr = parse_ini_file($serveIni, true);
                    break;
                case 'php':
                    $this->serveConfigArr = include($serveIni);
                    break;
                default:
                    throw new Yaf_Exception('server配置文件加载错误');
            }
        }else{
            $ConfigArr = parse_ini_file($appIni, true);
            if(isset($ConfigArr['server']))
                $this->serveConfigArr = $ConfigArr['server'];
            else
                throw new Yaf_Exception('配置文件错误');
        }
        try {
            $this->parseConfig($this->serveConfigArr);
            $this->runApp();
        }catch (Yaf_Exception $exception){

        }
//        var_dump($this->serverip);
    }

    /**
     * 解析配置文件，过滤不需要的配置项
     * @param array $pares
     * @return bool
     */
    private function parseConfig(array $pares){
        foreach ($pares as $k => $v){
            $this->$k = $v;
        }
        return true;
    }


    private function runApp(){
        $this->serverObj = new swoole_http_server( $this->serverip, $this->serverport );
//        $this->serverObj->set($this->serverConfig['swoole']);
        $this->serverObj->on('Start', array($this, 'onStart'));
        $this->serverObj->on('ManagerStart', array($this, 'onManagerStart'));
        $this->serverObj->on('WorkerStart', array($this, 'onWorkerStart'));
        $this->serverObj->on('WorkerStop', array($this, 'onWorkerStop'));
        $this->serverObj->on('request', array($this, 'onRequest'));
        $this->serverObj->start();
    }

    private function onStart(){
        echo __FUNCTION__;
    }
    private function onManagerStart(){
        echo __FUNCTION__;
    }
    private function onWorkerStart(){
        echo __FUNCTION__;
    }
    private function onWorkerStop(){
        echo __FUNCTION__;
    }
    private function onRequest(swoole_http_request $request, swoole_http_response $response){
        $response -> end('123');
    }
    public function __call($name, $arguments)
    {
    }

    private function __clone()
    {
    }

    /**
     * 加载配置文件，运行http服务
     * @param $appIni 项目ini配置文件目录
     * @param null $serveIni http服务ini配置文件目录
     * @return server
     */
    public static function run($appIni, $serveIni = null)
    {
        if (!self::$_server) {
            self::$_server = new server($appIni, $serveIni);
            return self::$_server;
        } else {
            return self::$_server;
        }
    }

    public function __set($name, $value)
    {
    }

    public function __get($name)
    {
    }


}