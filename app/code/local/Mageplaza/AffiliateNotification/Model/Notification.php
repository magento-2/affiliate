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
 * Notification model
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Model_Notification extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'mageplaza_affiliatenotification_notification';
    const CACHE_TAG = 'mageplaza_affiliatenotification_notification';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'mageplaza_affiliatenotification_notification';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'notification';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('mageplaza_affiliatenotification/notification');
    }

    /**
     * before save notification
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Model_Notification
     * @author Mageplaza Developers
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the url to the notification details page
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getNotificationUrl()
    {
        if ($this->getUrlKey()) {
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('affiliate/notification/url_prefix')) {
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('affiliate/notification/url_suffix')) {
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('mageplaza_affiliatenotification/notification/view', array('id'=>$this->getId()));
    }

    /**
     * check URL key
     *
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Mageplaza Developers
     */
    public function checkUrlKey($urlKey, $active = true)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * get the notification Content
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getContent()
    {
        $content = $this->getData('content');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($content);
        return $html;
    }

    /**
     * save notification relation
     *
     * @access public
     * @return Mageplaza_AffiliateNotification_Model_Notification
     * @author Mageplaza Developers
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Mageplaza Developers
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        $values['send_email'] = 'If Yes, it will send notification to all subscriber Affiliates. You can edit email template in Affiliate > Settings > Email templates';

        return $values;
    }
    
    /**
      * get Affiliate Groups
      *
      * @access public
      * @return array
      * @author Mageplaza Developers
      */
    public function getAffiliateGroupIds()
    {
        if (!$this->getData('affiliate_group_ids')) {
            return explode(',', $this->getData('affiliate_group_ids'));
        }
        return $this->getData('affiliate_group_ids');
    }
    /**
      * get Website
      *
      * @access public
      * @return array
      * @author Mageplaza Developers
      */
    public function getWebsite()
    {
        if (!$this->getData('website')) {
            return explode(',', $this->getData('website'));
        }
        return $this->getData('website');
    }
}
