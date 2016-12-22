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
 * Notification list block
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Notification_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Mageplaza Developers
     */
    public function _construct()
    {
        parent::_construct();
        $account    = $this->getAffiliateAccount();
        $validateId = array();
        $collection = Mage::getModel('mageplaza_affiliatenotification/notification')->getCollection()
            ->addFieldToFilter('status', 1);
        foreach ($collection as $item) {
            $groups = explode(',', $item->getAffiliateGroupIds());
            if (in_array($account->getAffiliateGroup(), $groups)) {
                $validateId[] = $item->getId();
            }

        }
        $notifications = Mage::getResourceModel('mageplaza_affiliatenotification/notification_collection')
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('entity_id', array('in' => $validateId));
        $notifications->setOrder('entity_id', 'desc');

        $this->setNotifications($notifications);
    }

    public function getAffiliateAccount()
    {
        $affiliateAccount = Mage::helper('affiliate/account')->getAffiliateAccount();

        return $affiliateAccount;
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Notification_List
     * @author Mageplaza Developers
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'mageplaza_affiliatenotification.notification.html.pager'
        )
            ->setCollection($this->getNotifications());
        $this->setChild('pager', $pager);
        $this->getNotifications()->load();

        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function isEnable($store = null)
    {
        return Mage::helper('mageplaza_affiliatenotification')->isEnabled($store);
    }
    public function isAffiliateLogin()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customer   = Mage::getSingleton('customer/session');
            $affAccount = Mage::getSingleton('affiliate/account')->load($customer->getCustomer()->getId(),'customer_id');
            if ($affAccount && $affAccount->getId()) {
                return true;
            }
        }

        return false;
    }
}
