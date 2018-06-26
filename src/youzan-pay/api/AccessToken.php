<?php
/**
 * Date: 2018-06-26 15:48
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan\api;


use Yumufeng\youzan\tool\Curl;
use Yumufeng\youzan\YouzanFatory;

class AccessToken
{
    const TOKEN_CACHE_KEY = 'damon.youzan.pay.core.token.';
    const API_TOKEN_GATEWAY = 'https://open.youzan.com/oauth/token';
    const GRANT_TYPE = 'silent';
    protected $clientId;
    protected $clientSecret;
    protected $storeId;

    public function __construct(YouzanFatory $app)
    {
        $config = $app->getConfig();
        $this->clientId = $config['ak'];
        $this->clientSecret = $config['sk'];
        $this->storeId = $config['storeId'];
    }

    /**
     * Get access token.
     *
     * @param  boolean $forceRefresh
     *
     * @return string
     */
    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->getCacheKey();
        $cached = \cache($cacheKey);
        if (!$cached || $forceRefresh) {
            $token = $this->getTokenFromServer();
            \cache($cacheKey, $token['access_token'], $token['expires_in'] - 1500);
            return $token['access_token'];
        }
        return $cached;
    }

    /**
     * Get access token from server
     *
     * @return array
     */
    protected function getTokenFromServer()
    {
        $response = Curl::post(self::API_TOKEN_GATEWAY, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => self::GRANT_TYPE,
            'kdt_id' => $this->storeId
        ]);
        return Curl::json($response);
    }

    protected function getCacheKey()
    {
        return self::TOKEN_CACHE_KEY . $this->clientId;
    }
}