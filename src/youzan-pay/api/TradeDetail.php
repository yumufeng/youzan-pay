<?php
/**
 * Date: 2018-06-26 15:51
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan\api;


class TradeDetail extends Gateway
{
    protected function gateway()
    {
        return "youzan.trade";
    }

    /**
     * @author storm <hi@yumufeng.com>
     * @param $tid
     * @return array[]
     */
    public function getQrDetailByTid($tid)
    {
        $result = $this->setMethod('get')->request([
            'tid' => $tid,
        ]);
        return $result['response']['trade'];
    }
}