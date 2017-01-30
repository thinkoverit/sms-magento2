<?php

namespace Pixel6\Sms\Helper;

use \Magento\Framework\App\ObjectManager;
use \Magento\Framework\Event\Observer;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * This will used by pixel6 sms admins to confirm which e-commerce platform is sending sms
     * @var string
     */
    protected $_platform         = 'Magento';
    /**
     * The version of e-commerce platform
     * @var string
     */
    protected $_platformVersion  = '2.0';
    /**
     * Return type of api method
     * @var string
     */
    protected $_format           = 'json';
    /**
     * To be used by the API
     * @var string
     */
    protected $_host             = 'https://www.pixel6sms.com/';

    protected $_objectManager = null;
    
    public function __construct(
        Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
    }
    /**
     * Getting Basic Configuration
     * These functions are used to get the api username and password
     */

    /**
     * Getting Pixel6SMS API Username
     * @return string
     */
    public function getApiUsername()
    {
        return $this->getConfig('pixel6_sms_configuration/basic_configuration/username');
    }

    /**
     * Getting Pixel6SMS API Password
     * @return string
     */
    public function getApiPassword()
    {
        return $this->getConfig('pixel6_sms_configuration/basic_configuration/password');
    }


    /**
     * Checking Admin SMS is enabled or not
     * @return string
     */
    public function isAdminNotificationsEnabled()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/admin_enabled');
    }

    /**
     * Getting Admin Mobile Number
     * @return string
     */
    public function getAdminSenderId()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/admin_mobile');
    }

    /**
     * Getting admin message for new order
     * @return string
     */
    public function getAdminMessageForNewOrder()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/new_order_admin_message');
    }

    /**
     * Getting Admin message for order Hold
     * @return string
     */
    public function getAdminMessageForOrderHold()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/hold_admin_message');
    }

    /**
     * Getting Admin message for order unhold
     * @return string
     */
    public function getAdminMessageForOrderUnHold()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/unhold_admin_message');
    }

    /**
     * Getting Admin message for order cancelled
     * @return string
     */
    public function getAdminMessageForOrderCancelled()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/cancelled_admin_message');
    }

    /**
     * Getting Admin message for Invoiced
     * @return string
     */
    public function getAdminMessageForInvoiced()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/invoiced_admin_message');
    }


    /**
     * Getting Admin message for Sign up
     * @return string
     */
    public function getAdminMessageForRegister()
    {
        return $this->getConfig('pixel6_sms_admins/admin_configuration/register_admin_message');
    }


    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when new order is placed
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnOrder()
    {
        return $this->getConfig('pixel6_sms_orders/new_order/new_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerSenderId()
    {
        return $this->getConfig('pixel6_sms_orders/new_order/new_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnOrder()
    {
        return $this->getConfig('pixel6_sms_orders/new_order/new_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is on hold
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnHold()
    {
        return $this->getConfig('pixel6_sms_orders/hold_order/hold_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerSenderIdonHold()
    {
        return $this->getConfig('pixel6_sms_orders/hold_order/hold_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnHold()
    {
        return $this->getConfig('pixel6_sms_orders/hold_order/hold_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is on un hold
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnUnHold()
    {
        return $this->getConfig('pixel6_sms_orders/unhold_order/unhold_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerSenderIdonUnHold()
    {
        return $this->getConfig('pixel6_sms_orders/unhold_order/unhold_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnUnHold()
    {
        return $this->getConfig('pixel6_sms_orders/unhold_order/unhold_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when order is Cancelled
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnCancelled()
    {
        return $this->getConfig('pixel6_sms_orders/cancelled_order/cancelled_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerSenderIdonCancelled()
    {
        return $this->getConfig('pixel6_sms_orders/cancelled_order/cancelled_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnCancelled()
    {
        return $this->getConfig('pixel6_sms_orders/cancelled_order/cancelled_order_message');
    }

    /**
     * Getting Customer Configuration
     * These functions are used to get the customer information when invoice is created
     */

    /**
     * Checking Customer SMS is enabled or not
     * @return string
     */
    public function isCustomerNotificationsEnabledOnInvoiced()
    {
        return $this->getConfig('pixel6_sms_orders/invoiced_order/invoiced_order_enabled');
    }

    /**
     * Getting Customer Sender ID
     * @return string
     */
    public function getCustomerSenderIdonInvoiced()
    {
        return $this->getConfig('pixel6_sms_orders/invoiced_order/invoiced_order_sender_id');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function getCustomerMessageOnInvoiced()
    {
        return $this->getConfig('pixel6_sms_orders/invoiced_order/invoiced_order_message');
    }

    /**
     * Getting Customer Message
     * @return string
     */
    public function isDebugMode()
    {
        return $this->getConfig('pixel6_sms_configuration/basic_configuration/debug');
    }
    /**
     * The Basics:
     * These functions are used to do the basic functionality
     */

    /**
     * Send Configuration path to this function and get the module admin Config data
     * @param @var $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE);
    }

    /**
     * Curl Function to get the result from Pixel6SMS API
     * @param @var $url
     * @return string
     */
    public function curl($url)
    {
        return file_get_contents($url);
        /*$ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;*/
    }

    /**
     * Verification of API Account
     * @param @var $username
     * @param @var $password
     * @return bool
     */
    public function verifyApi($username, $password)
    {
        return  true;
    }


    /**
     * Sending SMS
     * @param @var $username
     * @param @var $password
     * @param @var $senderID
     * @param @var $destination
     * @param @var $message
     * @return void
     */
    public function sendSms($username, $password, $senderID, $destination, $message)
    {
        $messageEntry = $this->_objectManager->create('\Pixel6\Sms\Model\Grid');
        
        $messageEntry->setSenderId($senderID);
        $messageEntry->setDestination($destination);
        $messageEntry->setMessage($message);
        $messageEntry->setStatus('sent');
        $messageEntry->save();
        
        if($this->isDebugMode()){
            $log = "Sending Message to $destination from $senderID, Content: $message" ;
            $this->_logger->debug($log);
            return;
        }
        $_host       = $this->_host;
        $path       = 'vapi/server/sendSMS?';
        $data       = 'uid='.urlencode($username).
                      '&pass='.urlencode($password).
                      '&dest='.urlencode($destination).
                      '&orig='.urlencode($senderID).
                      '&msg='.urlencode($message).
                      '&validity=300';
        $_format     = '&format='.$this->_format;
        $_platform   = '&platform='.$this->_platform.
                      '&platform_version='.$this->_platformVersion;
        $url        = $_host.$path.$data.$_format.$_platform;
        $this->curl($url);
    }

    /**
     * Insert Admin Config Values in the message using order data
     * @param @var $message
     * @param @var $data
     * @return string
     */
    public function manipulateSMS($message, $data)
    {
        $keywords   = [
            '{order_id}',
            '{firstname}',
            '{middlename}',
            '{lastname}',
            '{dob}',
            '{email}',
            '{price}',
            '{cc}',
            '{gender}',
            '{pc}',
            '{shop_name}'
        ];
        $message            = str_replace($keywords, $data, $message);
        return $message;
    }
    /**
     * Insert Admin Config Values in the message using order data
     * @param @var $message
     * @param @var $data
     * @return string
     */
    public function manipulateInvoiceSMS($message, $data)
    {
        $keywords   = [
            '{order_id}',
            '{invoice_id}',
            '{firstname}',
            '{middlename}',
            '{lastname}',
            '{dob}',
            '{email}',
            '{price}',
            '{cc}',
            '{gender}',
            '{pc}',
            '{shop_name}'
        ];
        $message            = str_replace($keywords, $data, $message);
        return $message;
    }
    /**
     * The Fetchers
     * These functions are used to fetch the details using observer
     */

    /**
     * Getting Products
     * @param Observer $observer
     * @return string
     */
    public function getProduct(Observer $observer)
    {
        $productId          = $observer->getProduct()->getId();
        $objectManager      = ObjectManager::getInstance();
        $product            = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
        return $product;
    }

    /**
     * Getting Order Details
     * @param Observer $observer
     * @return string
     */
    public function getOrder(Observer $observer)
    {
        $order              = $observer->getOrder();
        $orderId            = $order->getIncrementId();
        $objectManager      = ObjectManager::getInstance();
        $order              = $objectManager->get('Magento\Sales\Model\Order');
        $orderInformation   = $order->loadByIncrementId($orderId);
        return $orderInformation;
    }
}