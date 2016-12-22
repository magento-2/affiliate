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
 * Notification edit form tab
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Edit_Tab_Form
     * @author Mageplaza Developers
     */
    protected function _prepareForm()
    {
        $notification=Mage::registry('current_notification');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('notification_');
        $form->setFieldNameSuffix('notification');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'notification_form',
            array('legend' => Mage::helper('mageplaza_affiliatenotification')->__('Notification'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField(
            'title',
            'text',
            array(
                'label' => Mage::helper('mageplaza_affiliatenotification')->__('Title'),
                'name'  => 'title',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('mageplaza_affiliatenotification')->__('Description'),
                'name'  => 'description',

           )
        );

        $fieldset->addField(
            'content',
            'editor',
            array(
                'label' => Mage::helper('mageplaza_affiliatenotification')->__('Content'),
                'name'  => 'content',
            'config' => $wysiwygConfig,

           )
        );

        $fieldset->addField('affiliate_group_ids', 'multiselect', array(
            'name'     => 'affiliate_group_ids[]',
            'label'    => Mage::helper('mageplaza_affiliatenotification')->__('Affiliate Groups'),
            'title'    => Mage::helper('mageplaza_affiliatenotification')->__('Affiliate Groups'),
            'required' => true,
            'values'   => Mage::getResourceModel('affiliate/group_collection')
                ->addFieldToFilter('status', 1)
                ->load()
                ->toOptionArray()
        ));

        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('mageplaza_affiliatenotification')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('mageplaza_affiliatenotification')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('mageplaza_affiliatenotification')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('mageplaza_affiliatenotification')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('mageplaza_affiliatenotification')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_notification')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getNotificationData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNotificationData());
            Mage::getSingleton('adminhtml/session')->setNotificationData(null);
        } elseif (Mage::registry('current_notification')) {
            $formValues = array_merge($formValues, Mage::registry('current_notification')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
