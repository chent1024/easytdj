<?php

namespace WenboBao\EasyTDJ;

use WenboBao\EasyTDJ\TaoBao\Application as TaoBao;
use WenboBao\EasyTDJ\PinDuoDuo\Application as PinDuoDuo;
use WenboBao\EasyTDJ\JingDong\Application as JingDong;
use WenboBao\EasyTDJ\Apith\Application as Apith;

/**
 * Class Factory.
 */
class Factory
{

    /**
     * @var 单例模式
     */
    private static $instance;


    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $obj = self::getInstance();
        return $obj->make ($name, ...$arguments);
    }


    /**
     * 单例获取当前对象
     * @Author: david
     * @Date: 2018/4/26
     * @return static
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 获取配置文件名字
     * @return string
     */
    public function getConfigName()
    {
        return "easytdj";
    }

    /**
     * @param $name
     * @param array $config
     * @return mixed
     */
    public function make($name, array $config = [])
    {
        if (!in_array($name, ['taobao', 'jingdong', 'pinduoduo', 'apith'])) {
            throw  new \InvalidArgumentException('static method is not exists');
        }

        if (count($config) == 0) {
            $config = config("{$this->getConfigName ()}.{$name}", []);
        }
        $config = $this->getConfig($name, $config);

        return $this->getClient($name, $config);
    }


    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    protected function getConfig($name, array $config)
    {
        if ($name == "taobao") {
            if (!array_key_exists('app_key', $config) || !array_key_exists('app_secret', $config)) {
                throw new \InvalidArgumentException('The top client requires api keys.');
            }
            return array_only($config, ['app_key', 'app_secret', 'format']);
        }
        if ($name == "pinduoduo") {
            if (!array_key_exists('client_id', $config) || !array_key_exists('client_secret', $config)) {
                throw new \InvalidArgumentException('The pinduoduo client requires client_id and client_secret.');
            }
            return array_only($config, ['client_id', 'client_secret', 'format']);
        }
        if ($name == "jingdong") {
            if (!array_key_exists('app_key', $config) || !array_key_exists('app_secret', $config)) {
                throw new \InvalidArgumentException('The jingdong client requires app_key and app_secret.');
            }
            return array_only($config, ['app_key', 'app_secret', 'format']);
        }
        if ($name == "apith") {
            if (!array_key_exists('app_key', $config) || !array_key_exists('app_secret', $config)) {
                throw new \InvalidArgumentException('The apith client requires app_key and app_secret.');
            }
            return array_only($config, ['app_key', 'app_secret', 'format']);
        }
    }

    /**
     * Get the topclient client.
     *
     * @param string[] $auth
     *
     * @return CloudsearchClient
     */
    protected function getClient($name, array $config)
    {
        if ($name == "taobao") {
            $c = new TaoBao;
            $c->appkey = $config['app_key'];
            $c->secretKey = $config['app_secret'];
            $c->format = isset($config['format']) ? $config['format'] : 'json';
            return $c;
        }
        if ($name == "pinduoduo") {
            $c = new PinDuoDuo();
            $c->clientId = $config['client_id'];
            $c->clientSecret = $config['client_secret'];
            $c->format = isset($config['format']) ? $config['format'] : 'json';
            return $c;
        }
        if ($name == "jingdong") {
            $c = new JingDong();
            $c->appKey = $config['app_key'];
            $c->appSecret = $config['app_secret'];
            $c->format = isset($config['format']) ? $config['format'] : 'json';
            return $c;
        }
        if ($name == "apith") {
            $c = new Apith();
            $c->appKey = $config['app_key'];
            $c->appSecret = $config['app_secret'];
            $c->format = isset($config['format']) ? $config['format'] : 'json';
            return $c;
        }
    }


}
