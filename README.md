# youzan-pay
基于有赞云、微小店的个人收款收银解决方案

```composer require yumufeng/youzan-pay dev-master```

### 配置

```php
 $config = [
    'ak'=>'', //appId
    'sk'=>'', // appSec
    'storeId'=>'' //店铺ID
 ]
```
### 创建付款二维码

（不区分支付宝、微信支付，自动识别UA进行提示）

```php
$options = [
    'qr_source' => '', // 商户订单号
    'qr_price' => bcmul('', 100), // 支付金额
    'qr_name' => '', // 支付订单描述
    'qr_type' => 'QR_TYPE_DYNAMIC'
];
//获取二维码的信息
$qr_content  = \Yumufeng\youzan\YouzanFatory::instance($config)->qrCode->create($options);

//进行自己的业务逻辑
//Todo
        
```        

### 检查是否已经支付

这个需要前端主动去后端查询，建议使用 长轮询、websocket

```php

$qrId = input('qid');
$result = \extend\youzan\YouzanFatory::instance($config)->tradeQr->queryByQrId($qrId);

if($result === true){
    //处理自己的业务逻辑
}

```

### 异步通知处理

不建议采用这个，即使消息送达了，还是需要主动通过API去查询支付状况的
```php
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $client_id = $config['ak'];//应用的 client_id
        $client_secret = $config['sk'];//应用的 client_secret
        $msg = $data['msg'];
        $sign_string = $client_id . "" . $msg . "" . $client_secret;
        $sign = md5($sign_string);
        /**
         * 判断消息是否合法，若合法则返回成功标识
         */
        if ($sign != $data['sign']) {
            exit();
        }
        /**
         * msg内容经过 urlencode 编码，需进行解码
         */
        $msg = json_decode(urldecode($msg), true);
        /**
         * 根据 type 来识别消息事件类型，具体的 type 值以文档为准，此处仅是示例
         */
        if ($data['type'] == "trade_TradePaid") {
         //处理付款成功、交易成功的订单的消息
         if ($data['status'] == "TRADE_PAID") {
              $detail = \Yumufeng\youzan\YouzanFatory::instance($config)->tradeDetail->getQrDetailByTid($data['id']);
              $qrId = $detail['qr_id'];
              //拿到qr_id 去自己的表里面查询 未付款的状态
              $payment = db('payment')->where(['trade_no' => $qrId, 'trade_status' => 0])->find();  
              
              //如果未付款
               if (!empty($payment)) {
               //更新付款状态
               
               // 进行自己的业务处理
               }
                    
          }
        }

```
