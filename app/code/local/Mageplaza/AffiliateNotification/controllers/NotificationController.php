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
 * Notification front contrller
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_NotificationController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Mageplaza Developers
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('mageplaza_affiliatenotification/notification')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('mageplaza_affiliatenotification')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'notifications',
                    array(
                        'label' => Mage::helper('mageplaza_affiliatenotification')->__('Notifications'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('mageplaza_affiliatenotification/notification')->getNotificationsUrl());
        }
        $this->renderLayout();
    }

    /**
     * init Notification
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Model_Notification
     * @author Mageplaza Developers
     */
    protected function _initNotification()
    {
        $notificationId   = $this->getRequest()->getParam('id', 0);
        $notification     = Mage::getModel('mageplaza_affiliatenotification/notification')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($notificationId);
        if (!$notification->getId()) {
            return false;
        } elseif (!$notification->getStatus()) {
            return false;
        }
        return $notification;
    }

    /**
     * view notification action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function viewAction()
    {
        $notification = $this->_initNotification();
        if (!$notification || !Mage::helper('mageplaza_affiliatenotification')->isEnabled()) {
            $this->_forward('no-route');
            $this->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
            return;
        }
        Mage::register('current_notification', $notification);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        $this->_title($notification->getTitle());
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('affiliatenotification-notification affiliatenotification-notification' . $notification->getId());
        }
        if (Mage::helper('mageplaza_affiliatenotification/notification')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'affiliate',
                    array(
                        'label'    => Mage::helper('mageplaza_affiliatenotification')->__('Affiliate'),
                        'link'     => Mage::getUrl('affiliate'),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'notification',
                    array(
                        'label' => $notification->getTitle(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $notification->getNotificationUrl());
        }
        $this->renderLayout();
    }
}
