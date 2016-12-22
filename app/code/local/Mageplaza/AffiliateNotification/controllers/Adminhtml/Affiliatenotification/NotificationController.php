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
 * Notification admin controller
 *
 * @category    Mageplaza
 * @package     Mageplaza_AffiliateNotification
 * @author      Mageplaza Developers
 */
class Mageplaza_AffiliateNotification_Adminhtml_Affiliatenotification_NotificationController extends Mageplaza_AffiliateNotification_Controller_Adminhtml_AffiliateNotification
{
    /**
     * init the notification
     *
     * @access protected
     * @return Mageplaza_AffiliateNotification_Model_Notification
     */
    protected function _initNotification()
    {
        $notificationId = (int)$this->getRequest()->getParam('id');
        $notification   = Mage::getModel('mageplaza_affiliatenotification/notification');
        if ($notificationId) {
            $notification->load($notificationId);
        }
        Mage::register('current_notification', $notification);

        return $notification;
    }

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
        $this->_title(Mage::helper('mageplaza_affiliatenotification')->__('Manage Notifications'))
            ->_title(Mage::helper('mageplaza_affiliatenotification')->__('Notifications'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit notification - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function editAction()
    {
        $notificationId = $this->getRequest()->getParam('id');
        $notification   = $this->_initNotification();
        if ($notificationId && !$notification->getId()) {
            $this->_getSession()->addError(
                Mage::helper('mageplaza_affiliatenotification')->__('This notification no longer exists.')
            );
            $this->_redirect('*/*/');

            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNotificationData(true);
        if (!empty($data)) {
            $notification->setData($data);
        }
        Mage::register('notification_data', $notification);
        $this->loadLayout();
        $this->_title(Mage::helper('mageplaza_affiliatenotification')->__('Manage Notifications'))
            ->_title(Mage::helper('mageplaza_affiliatenotification')->__('Notifications'));
        if ($notification->getId()) {
            $this->_title($notification->getTitle());
        } else {
            $this->_title(Mage::helper('mageplaza_affiliatenotification')->__('Add notification'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new notification action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save notification - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('notification')) {
            try {
                $notification = $this->_initNotification();
                $notification->addData($data);
                $notification->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mageplaza_affiliatenotification')->__('Notification was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $notification->getId()));

                    return;
                } elseif ($this->getRequest()->getParam('mail')) {
                    Mage::helper('mageplaza_affiliatenotification/notification')->sendNotificationNewsEmail($notification);
                    $this->_redirect('*/*/edit', array('id' => $notification->getId()));

                    return;
                }
                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNotificationData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mageplaza_affiliatenotification')->__('There was a problem saving the notification.')
                );
                Mage::getSingleton('adminhtml/session')->setNotificationData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mageplaza_affiliatenotification')->__('Unable to find notification to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete notification - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $notification = Mage::getModel('mageplaza_affiliatenotification/notification');
                $notification->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mageplaza_affiliatenotification')->__('Notification was successfully deleted.')
                );
                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mageplaza_affiliatenotification')->__('There was an error deleting notification.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);

                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('mageplaza_affiliatenotification')->__('Could not find notification to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete notification - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function massDeleteAction()
    {
        $notificationIds = $this->getRequest()->getParam('notification');
        if (!is_array($notificationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mageplaza_affiliatenotification')->__('Please select notifications to delete.')
            );
        } else {
            try {
                foreach ($notificationIds as $notificationId) {
                    $notification = Mage::getModel('mageplaza_affiliatenotification/notification');
                    $notification->setId($notificationId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('mageplaza_affiliatenotification')->__('Total of %d notifications were successfully deleted.', count($notificationIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mageplaza_affiliatenotification')->__('There was an error deleting notifications.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function massStatusAction()
    {
        $notificationIds = $this->getRequest()->getParam('notification');
        if (!is_array($notificationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mageplaza_affiliatenotification')->__('Please select notifications.')
            );
        } else {
            try {
                foreach ($notificationIds as $notificationId) {
                    $notification = Mage::getSingleton('mageplaza_affiliatenotification/notification')->load($notificationId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d notifications were successfully updated.', count($notificationIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mageplaza_affiliatenotification')->__('There was an error updating notifications.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Send email to Affiliates change - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function massSendEmailAction()
    {
        $notificationIds = $this->getRequest()->getParam('notification');
        if (!is_array($notificationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('mageplaza_affiliatenotification')->__('Please select notifications.')
            );
        } else {
            try {
                foreach ($notificationIds as $notificationId) {
                    $notification = Mage::getSingleton('mageplaza_affiliatenotification/notification')->load($notificationId)
                        ->setSendEmail($this->getRequest()->getParam('flag_send_email'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d notifications were successfully updated.', count($notificationIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('mageplaza_affiliatenotification')->__('There was an error updating notifications.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function exportCsvAction()
    {
        $fileName = 'notification.csv';
        $content  = $this->getLayout()->createBlock('mageplaza_affiliatenotification/adminhtml_notification_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function exportExcelAction()
    {
        $fileName = 'notification.xls';
        $content  = $this->getLayout()->createBlock('mageplaza_affiliatenotification/adminhtml_notification_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Mageplaza Developers
     */
    public function exportXmlAction()
    {
        $fileName = 'notification.xml';
        $content  = $this->getLayout()->createBlock('mageplaza_affiliatenotification/adminhtml_notification_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Mageplaza Developers
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('affiliate/mageplaza_affiliatenotification');
    }
}
