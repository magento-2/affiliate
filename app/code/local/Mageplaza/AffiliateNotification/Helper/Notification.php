<?php
/**
 * Mageplaza_AffiliateNotification extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com  License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://mageplaza.com/license-agreement/
 *
 * @category       Mageplaza
 * @package        Mageplaza_AffiliateNotification
 * @copyright      Copyright (c) 2016
 * @license        https://mageplaza.com/license-agreement/
 */

/**
 * Notification helper
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Helper_Notification extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the notifications list page
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getNotificationsUrl()
    {
        if ($listKey = Mage::getStoreConfig('affiliate/notification/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct' => $listKey));
        }

        return Mage::getUrl('mageplaza_affiliatenotification/notification/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Mageplaza Developers
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('mageplaza_affiliatenotification/notification/breadcrumbs');
    }

    public function sendNotificationNewsEmail($notification)
    {
        $accounts = Mage::getModel('affiliate/account')->getCollection()
            ->addFieldToFilter('status', Mageplaza_Affiliate_Model_Account::STATUS_ACTIVE)
            ->addFieldToFilter('email_notification_news', 1)
            ->addFieldToFilter('affiliate_group', array('in' => explode(',', $notification->getAffiliateGroupIds())));
        foreach ($accounts as $account) {
            $this->sendEmail($account, $notification);
        }
    }

    /**
     * send email to affiliate account
     *
     * @param $account
     * @param $notification
     * @return bool
     * @throws Mage_Core_Exception
     */
    public function sendEmail($account, $notification)
    {
        if (Mage::helper('mageplaza_affiliatenotification')->isEnabled() && Mage::helper('affiliate')->isEnabled()) {
            $customer = Mage::getModel('customer/customer')->load($account->getCustomerId());
            if (!$customer->getId()) {
                return false;
            }
            try {
                $storeIds = Mage::app()->getWebsite($customer->getWebsiteId())->getStoreIds();
                reset($storeIds);
                $storeId   = current($storeIds);
                $translate = Mage::getSingleton('core/translate');
                $translate->setTranslateInline(false);
                $container = new Varien_Object(
                    array(
                        'template_email' => Mage::helper('mageplaza_affiliatenotification')->getEmailTemplate($storeId),
                        'template_data'  => array(
                            'store_id'     => $storeId,
                            'customer'     => $customer,
                            'notification' => $notification,
                            'store_phone'  => Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_STORE_STORE_PHONE, $storeId),
                            'store_email'  => Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_SUPPORT_EMAIL, $storeId)
                        )
                    )
                );
                Mage::getModel('core/email_template')
                    ->setDesignConfig(array(
                        'area'  => 'frontend',
                        'store' => $storeId
                    ))->sendTransactional(
                        $container->getTemplateEmail(),
                        Mage::helper('affiliate')->getConfig('email/sender', $storeId),
                        $customer->getEmail(),
                        $customer->getName(),
                        $container->getTemplateData()
                    );

                $translate->setTranslateInline(true);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }

        }


        return true;
    }
}
