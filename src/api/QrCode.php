<?php
/**
 * Date: 2018-06-26 15:49
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan\api;


class QrCode extends Gateway
{

    protected function gateway()
    {
        return 'youzan.pay.qrcode';
    }

    public function create(array $parameters = [])
    {
        $result =  $this->setMethod('create')->request($parameters);
        if (isset($result['error_response'])){
            throw  new \Exception('Youzan QrCode Create Api Exception');
        }
        return $result ['response'];
    }

    public function get(array $parameters = [])
    {
        return $this->setMethod('get')->request($parameters);
    }
}