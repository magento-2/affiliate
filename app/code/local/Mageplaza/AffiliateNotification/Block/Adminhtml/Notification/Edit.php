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
 * Notification admin edit form
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        parent::__construct();
        $this->_blockGroup = 'mageplaza_affiliatenotification';
        $this->_controller = 'adminhtml_notification';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('mageplaza_affiliatenotification')->__('Save Notification')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('mageplaza_affiliatenotification')->__('Delete Notification')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('mageplaza_affiliatenotification')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_addButton(
            'saveandsendmail',
            array(
                'label'   => Mage::helper('mageplaza_affiliatenotification')->__('Save And Send Email'),
                'onclick' => 'saveAndSendEmail()',
                'class'   => 'mail',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
             function saveAndSendEmail() {
                editForm.submit($('edit_form').action+'mail/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_notification') && Mage::registry('current_notification')->getId()) {
            return Mage::helper('mageplaza_affiliatenotification')->__(
                "Edit Notification '%s'",
                $this->escapeHtml(Mage::registry('current_notification')->getTitle())
            );
        } else {
            return Mage::helper('mageplaza_affiliatenotification')->__('Add Notification');
        }
    }
}
