<?php
/**
 * Date: 2018-06-26 15:46
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan\api;


use Yumufeng\youzan\tool\Curl;
use Yumufeng\youzan\YouzanFatory;

abstract class Gateway
{
    const API_GATEWAY = 'https://open.youzan.com/api/oauthentry/%s/%s/%s';

    public function __construct(YouzanFatory $app)
    {
        $this->app = $app;
    }

    /**
     * GET, CREATE
     *
     * @var string
     */
    protected $method;

    /**
     * Send Http Request
     *
     * @param  array $parameters
     *
     * @return array
     */
    protected function request(array $parameters = [])
    {
        $response = Curl::post($this->getFullGateway(), $parameters);
        return Curl::json($response);
    }

    /**
     * Get full request url.
     *
     * @return string
     */
    protected function getFullGateway()
    {
        $url = sprintf(self::API_GATEWAY, $this->gateway(), $this->version(), $this->getMethod());

        $url .= '?access_token=' . $this->app->getToken();
        return $url;
    }

    /**
     * Get current api version
     *
     * @return string
     */
    protected function version()
    {
        return '3.0.0';
    }

    /**
     * Set method
     *
     * @param $this
     */
    protected function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    protected function getMethod()
    {
        return $this->method;
    }

    abstract protected function gateway();
}