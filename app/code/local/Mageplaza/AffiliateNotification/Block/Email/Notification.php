<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * http://wiki.mageplaza.com/general/license.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @copyright   Copyright (c) 2015 Mageplaza (https://mageplaza.com/)
 * @license     https://mageplaza.com/license-agreement.html
 */
class Mageplaza_AffiliateNotification_Block_Email_Notification extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getAffiliateUrl()
    {
        return Mage::helper('affiliate/account')->getAccountUrl();
    }
}