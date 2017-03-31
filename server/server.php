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
    private $appObjg;
    private $appIni;
    private $serverip = '0.0.0.0';
    private $serverport = '80';
    private $serverConfigArr = array();
    private $serverObj;
//    private $serverHeader;

    private function __construct($appIni, $serveIni = null)
    {
        if (!is_file($appIni) && pathinfo($appIni, 4) == 'ini'){
            //TODO:配置文件不存在的话返回错误和1001;
            throw new \Yaf_Exception_LoadFailed('app配置文件错误:'.$appIni, 1001);
        }else{
            $this->appIni = $appIni;
        }
        if (is_file($serveIni)){
            switch (pathinfo($serveIni,4)){
                case 'ini':
                    $this->serverConfigArr = parse_ini_file($serveIni, true);
                    break;
                case 'php':
                    $this->serverConfigArr = include($serveIni);
                    break;
                default:
                    throw new Yaf_Exception('server配置文件加载错误');
            }
        }else{
            $ConfigArr = parse_ini_file($appIni, true);
            if(isset($ConfigArr['server']))
                $this->serverConfigArr = $ConfigArr['server'];
            else
                throw new Yaf_Exception('配置文件错误');
        }
        if (!$this->serverConfigArr){ throw new Yaf_Exception('server配置解析失败');}
        try {
            $this->parseConfig($this->serverConfigArr);
            $this->runApp();
        }catch (Yaf_Exception $exception){
            echo $exception->getMessage();
        }

        return;
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
        return;
    }


    private function runApp(){
        $this->serverObj = new swoole_http_server( $this->serverip, $this->serverport );
        $this->serverObj->set($this->serverConfigArr);
        $this->serverObj->on('Start', function (){
            $this->onStart($this->serverObj);
        });
        $this->serverObj->on('WorkerStart', function (){
            $this->onWorkerStart();
        });
        $this->serverObj->on('WorkerStop', function (){
            $this->onWorkerStop($this->serverObj,$this->serverObj->worker_id);
        });
        $this->serverObj->on('request', function($request,$response){
            $this->onRequest($request,$response);
        });
        $this->serverObj->start();
    }

    private function onStart(){
       swoole_set_process_name($this->serverConfigArr['server']['appname']);
        return;
    }
    private function onWorkerStart(){
        global $argv;

        if ($this->serverObj->worker_id >= $this->serverObj->setting['server']['worker_num']){
            swoole_set_process_name('php ' .$argv[0]. 'task worker');
        }else {
            swoole_set_process_name('php ' .$argv[0]. 'event worker');
        }

        $this->appObjg = new Yaf_Application($this->appIni);
        return;
    }
    private function onWorkerStop(swoole_http_server $server, int $worker_id){
        return;
    }


    private function onRequest(swoole_http_request $request, swoole_http_response $response){
        $this->initRequestParams($request);
        Yaf_Registry::set('SWOOLE_HTTP_REQUEST', $request);
        Yaf_Registry::set('SWOOLE_HTTP_RESPONSE', $response);
        Yaf_Registry::set('SWOOLE_HTTP_SERVER', $this->serverObj);
        $a = 1;
        echo $a;
        $a++;

        $response ->header('Content-type','text/html');
        $response ->header('charset','utf-8');
//        $response -> write('测试');
        $response ->end('测试');

//        echo swoole_strerror(swoole_errno());
//        ob_start();
//        try{
//            $yafHttp = new Yaf_Request_Http($request->server['request_uri']);
//            $this->appObjg->bootstrap()->getDispatcher()->disPatcher($yafHttp);
//        }catch (Yaf_Exception $e){
//            echo $e ->getMessage();
//        }
//        $result = ob_get_contents();
//        echo $result;
//
//        ob_clean();

        return true;
    }

    /**
     * 注册Request变量
     * @param swoole_http_request $request
     * @return bool
     */
    private function initRequestParams(swoole_http_request $request){

        Yaf_Registry::set('SY_SERVER', isset($request->server) ? $request->server : array());
        Yaf_Registry::set('SY_HEADER', isset($request->header) ? $request->header : array());
        Yaf_Registry::set('SY_GET', isset($request->get) ? $request->get : array());
        Yaf_Registry::set('SY_POST', isset($request->post) ? $request->post : array());
        Yaf_Registry::set('SY_COOKIE', isset($request->cookie) ? $request->cookie : array());
        Yaf_Registry::set('SY_FILES', isset($request->files) ? $request->files : array());
        //获取php://input数据并解析为数组
        Yaf_Registry::set('SY_INPUT', !empty($request->rawContent()) ? parse_str($request->rawContent()) : array());

        return true;
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