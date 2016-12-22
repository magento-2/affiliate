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
 * Notification admin edit tabs
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Mageplaza Developers
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('notification_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mageplaza_affiliatenotification')->__('Notification'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Edit_Tabs
     * @author Mageplaza Developers
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_notification',
            array(
                'label'   => Mage::helper('mageplaza_affiliatenotification')->__('Notification'),
                'title'   => Mage::helper('mageplaza_affiliatenotification')->__('Notification'),
                'content' => $this->getLayout()->createBlock(
                    'mageplaza_affiliatenotification/adminhtml_notification_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve notification entity
     *
     * @access public
     * @return Mageplaza_AffiliateNotification_Model_Notification
     * @author Mageplaza Developers
     */
    public function getNotification()
    {
        return Mage::registry('current_notification');
    }
}
