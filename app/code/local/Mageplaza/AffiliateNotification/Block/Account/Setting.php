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
class Mageplaza_AffiliateNotification_Block_Account_Setting extends Mage_Core_Block_Template
{
    /**
     * get current affiliate account
     *
     * @return Mageplaza_Affiliate_Model_Account
     */
    protected function _construct()
    {
        parent::_construct();

        $account = $this->helper('affiliate/account')->getAffiliateAccount();
        $this->setAccount($account);
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function isNotificationEnable()
    {
        return Mage::helper('mageplaza_affiliatenotification')->isEnabled();
    }

    /**
     * get affiliate account login
     *
     * @return Mageplaza_Affiliate_Model_Account|null
     */
    public function getAffiliateAccount()
    {
        $affiliateAccount = Mage::helper('affiliate/account')->getAffiliateAccount();

        return $affiliateAccount;
    }
}