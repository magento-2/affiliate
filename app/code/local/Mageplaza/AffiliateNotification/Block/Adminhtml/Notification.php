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
 * Notification admin block
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Adminhtml_Notification extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_notification';
        $this->_blockGroup         = 'mageplaza_affiliatenotification';
        parent::__construct();
        $this->_headerText         = Mage::helper('mageplaza_affiliatenotification')->__('Notification');
        $this->_updateButton('add', 'label', Mage::helper('mageplaza_affiliatenotification')->__('Add Notification'));

    }
}
