<?php

class Cammino_Orderorigin_Model_Observer
{

    public function checkSources($observer)
    {
        $params = Mage::app()->getRequest()->getParams();
        if (!empty($params['gclid'])) {
            Mage::getSingleton('core/cookie')->set('gclid_cookie', $params['gclid'], 7776000, '/');
        }
        if (!empty($params['utm_source'])) {
            Mage::getSingleton('core/session')->setUtmSource($params['utm_source']);
        }
        if (!empty($params['utm_medium'])) {
            Mage::getSingleton('core/session')->setUtmMedium($params['utm_medium']);
        }
        if (!empty($params['utm_campaign'])) {
            Mage::getSingleton('core/session')->setUtmCampaign($params['utm_campaign']);
        }
        $httpReferer = Mage::app()->getRequest()->getServer('HTTP_REFERER');
        if (!empty($httpReferer)) {
            if (strpos($httpReferer, Mage::getBaseUrl()) !== false) {
            } else {
                Mage::getSingleton('core/session')->setHttpReferer($httpReferer);
            }
        }
    }

    public function setOrderSources($observer)
    {
        $order = $observer->getEvent()->getOrder();
        $gclid = Mage::getSingleton('core/cookie')->get('gclid_cookie');
        $utmSource = Mage::getSingleton('core/session')->getUtmSource();
        $utmMedium = Mage::getSingleton('core/session')->getUtmMedium();
        $utmCampaign = Mage::getSingleton('core/session')->getUtmCampaign();
        $httpReferer = Mage::getSingleton('core/session')->getHttpReferer();
        if (empty($utmSource)) {
            if (!empty($gclid)) {
                $utmSource = 'Google Ads';
            } else {
                if (empty($httpReferer)) {
                    $utmSource = 'Direct';
                } else {
                    if (strpos($httpReferer, 'google.com') !== false) {
                        $utmSource = 'Google';
                    } else {
                        $utmSource = $httpReferer;
                    }
                }
            }
        }
        $order->setUtmSource($utmSource);
        $order->setUtmMedium($utmMedium);
        $order->setUtmCampaign($utmCampaign);
        $order->setGclid($gclid);
        $order->getResource()->saveAttribute($order, "utm_source");
        $order->getResource()->saveAttribute($order, "gclid");
        $order->getResource()->saveAttribute($order, "utm_medium");
        $order->getResource()->saveAttribute($order, "utm_campaign");
    }
}