<?php
/**
 * 苏宁开放平台接口 -
 *
 * @author suning
 * @date   2018-2-7
 */

namespace WenboBao\EasyTDJ\SuNing\Request\Netalliance;

use WenboBao\EasyTDJ\SuNing\SuningRequest;
use WenboBao\EasyTDJ\SuNing\RequestCheckUtil;

class OrderGetRequest extends SuningRequest
{

    /**
     *
     */
    private $orderCode;

    public function getOrderCode()
    {
        return $this->orderCode;
    }

    public function setOrderCode($orderCode)
    {
        $this->orderCode = $orderCode;
        $this->apiParams["orderCode"] = $orderCode;
    }

    public function getApiMethodName()
    {
        return 'suning.netalliance.order.get';
    }

    public function getApiParams()
    {
        return $this->apiParams;
    }

    public function check()
    {
        //非空校验
        RequestCheckUtil::checkNotNull($this->orderCode, 'orderCode');
    }

    public function getBizName()
    {
        return "getOrder";
    }

}

?>