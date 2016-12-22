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
 * Notification view block
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Block_Notification_View extends Mage_Core_Block_Template
{
    /**
     * get the current notification
     *
     * @access public
     * @return mixed (Mageplaza_AffiliateNotification_Model_Notification|null)
     * @author Mageplaza Developers
     */
    public function getCurrentNotification()
    {
        return Mage::registry('current_notification');
    }


}
