<?php
/**
 * Date: 2018-06-26 15:39
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan;

use Yumufeng\youzan\api\AccessToken;
use Yumufeng\youzan\api\QrCode;
use Yumufeng\youzan\api\TradeDetail;
use Yumufeng\youzan\api\TradeQr;

/**
 * @property AccessToken accessToken
 * @property QrCode qrCode
 * @property TradeDetail tradeDetail
 * @property TradeQr tradeQr
 * @package extend\youzan
 */
class YouzanFatory
{
    protected $config;
    /**
     * @var null|static 实例对象
     */
    protected static $instance = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 获取示例
     * @param array $options 实例配置
     * @return static
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) self::$instance = new self($options);

        return self::$instance;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        $classname = __NAMESPACE__."\\api\\" . ucfirst($name);
        if (!class_exists($classname)) {
            throw new \Exception($classname . ' api undefined');
            return false;
        }
        $new = new $classname(self::$instance);
        return $new;

    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getToken()
    {
        return $this->accessToken->getToken();
    }
}