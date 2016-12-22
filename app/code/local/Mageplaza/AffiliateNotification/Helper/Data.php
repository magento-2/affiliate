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
 * AffiliateNotification default helper
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_ENABLED = 'affiliate/notification/is_enabled';
    const XML_PATH_EMAIL_TEMPLATE = 'affiliate/notification/email_notification_template';

    public function isEnabled($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ENABLED, $store);
    }

    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Mageplaza Developers
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])
            ) {
                $converted[$option['value']] = $option['label'];
            }
        }

        return $converted;
    }
    public function getEmailTemplate($storeId = null)
    {
        if (!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }

        return Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
    }
}
