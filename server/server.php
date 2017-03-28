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
    private $serveIp = '0.0.0.0';
    private $servePort = '80';
    private $serveConfigArr = array();

    private function __construct($appIni, $serveIni)
    {
        if (!is_file($appIni) && pathinfo($appIni, 4)){
            //TODO:配置文件不存在的话返回错误和1001;
            throw new \Yaf_Exception_LoadFailed('配置文件路径错误:'.$appIni, 1001);
        }
        if (is_file($serveIni)){
            switch (pathinfo($serveIni,4)){
                case 'ini':
                    $this->serveConfigArr = parse_ini_file($serveIni, true);
                    break;
                case 'php':
                    break;
                default:
                    throw new Yaf_Exception('server配置文件加载错误');
            }
        }else{

        }
        var_dump($this->serveConfigArr);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
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
        // TODO: Implement __set() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }


}