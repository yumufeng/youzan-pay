<?php
/**
 * Date: 2018-06-26 15:50
 * @author storm <hi@yumufeng.com>
 */

namespace Yumufeng\youzan\api;


class TradeQr extends Gateway
{
    protected function gateway()
    {
        return "youzan.trades.qr";
    }

    /**
     * 根据二维码ID查询支付状态
     * @author storm <hi@yumufeng.com>
     * @param $qrID
     * @return bool
     */
    public function queryByQrId($qrID)
    {
        $queryData = $this->setMethod('get')->request([
            'qr_id' => $qrID,
            'status' => 'TRADE_RECEIVED',
        ]);

        return isset($queryData['response']['total_results']) ? $queryData['response']['total_results'] > 0 : false;
    }
}