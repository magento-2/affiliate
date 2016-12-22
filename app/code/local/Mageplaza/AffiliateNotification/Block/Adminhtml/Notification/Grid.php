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
 * Notification admin grid block
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Mageplaza Developers
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('notificationGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Grid
     * @author Mageplaza Developers
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mageplaza_affiliatenotification/notification')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Grid
     * @author Mageplaza Developers
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('mageplaza_affiliatenotification')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'title',
            array(
                'header'    => Mage::helper('mageplaza_affiliatenotification')->__('Title'),
                'align'     => 'left',
                'index'     => 'title',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('mageplaza_affiliatenotification')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('mageplaza_affiliatenotification')->__('Enabled'),
                    '0' => Mage::helper('mageplaza_affiliatenotification')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'send_email',
            array(
                'header' => Mage::helper('mageplaza_affiliatenotification')->__('Send email to Affiliates'),
                'index'  => 'send_email',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('mageplaza_affiliatenotification')->__('Yes'),
                    '0' => Mage::helper('mageplaza_affiliatenotification')->__('No'),
                )

            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('mageplaza_affiliatenotification')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('mageplaza_affiliatenotification')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('mageplaza_affiliatenotification')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('mageplaza_affiliatenotification')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('mageplaza_affiliatenotification')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('mageplaza_affiliatenotification')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('mageplaza_affiliatenotification')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('mageplaza_affiliatenotification')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Grid
     * @author Mageplaza Developers
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('notification');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('mageplaza_affiliatenotification')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('mageplaza_affiliatenotification')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('mageplaza_affiliatenotification')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('mageplaza_affiliatenotification')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('mageplaza_affiliatenotification')->__('Enabled'),
                            '0' => Mage::helper('mageplaza_affiliatenotification')->__('Disabled'),
                        )
                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'send_email',
            array(
                'label'      => Mage::helper('mageplaza_affiliatenotification')->__('Change Send email to Affiliates'),
                'url'        => $this->getUrl('*/*/massSendEmail', array('_current'=>true)),
                'additional' => array(
                    'flag_send_email' => array(
                        'name'   => 'flag_send_email',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('mageplaza_affiliatenotification')->__('Send email to Affiliates'),
                        'values' => array(
                                '1' => Mage::helper('mageplaza_affiliatenotification')->__('Yes'),
                                '0' => Mage::helper('mageplaza_affiliatenotification')->__('No'),
                            )

                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Mageplaza_AffiliateNotification_Model_Notification
     * @return string
     * @author Mageplaza Developers
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Mageplaza Developers
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Block_Adminhtml_Notification_Grid
     * @author Mageplaza Developers
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
