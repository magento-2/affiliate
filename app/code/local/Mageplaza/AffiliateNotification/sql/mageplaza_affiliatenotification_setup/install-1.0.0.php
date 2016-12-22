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
 * AffiliateNotification module install script
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->dropTable($installer->getTable('mageplaza_affiliatenotification/notification'));

$table = $installer->getConnection()
    ->newTable($installer->getTable('mageplaza_affiliatenotification/notification'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ),
        'Notification ID'
    )
    ->addColumn(
        'title',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable' => false,
        ),
        'Title'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Description'
    )
    ->addColumn(
        'content',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Content'
    )
    ->addColumn(
        'affiliate_group_ids',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Affiliate Groups'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'url_key',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'URL key'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Notification Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Notification Creation Time'
    )
    ->setComment('Notification Table');
$installer->getConnection()->createTable($table);
$installer->getConnection()->addColumn($this->getTable('affiliate/account'), 'email_notification_news', 'int(3) default "1"');
$installer->endSetup();
