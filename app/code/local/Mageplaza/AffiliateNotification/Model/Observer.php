<?php

class Mageplaza_AffiliateNotification_Model_Observer
{
    public function accountSaveSetting($observer)
    {
        if(Mage::helper('mageplaza_affiliatenotification')->isEnabled()){
            $affAccount = $observer->getEvent()->getAccount();
            $action=$observer->getEvent()->getAction();
            $accountData = $action->getRequest()->getParam('account');
            if(!isset($accountData['email_notification_news'])){
                $accountData['email_notification_news']=0;
            }
            $affAccount->addData(array(
                'email_notification_news'      => $accountData['email_notification_news']
            ));
        }
       return $this;
    }
}