<?php

namespace Pixel6\Sms\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\View\Element\Context;
use \Pixel6\Sms\Helper\Data as Helper;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * Customer login observer
 */
class Registration implements ObserverInterface
{
    /**
     * Https request
     *
     * @var \Zend\Http\Request
     */
    protected $_request;

    /**
     * Layout Interface
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * Helper for Pixel6SMS Module
     * @var \Pixel6\Sms\Helper\Data
     */
    protected $_helper;

    /**
     * Username
     * @var $username
     */
    protected $username;

    /**
     * Password
     * @var $password
     */
    protected $password;

    /**
     * Sender ID
     * @var $senderId
     */
    protected $senderId;

    /**
     * Destination
     * @var $destination
     */
    protected $destination;

    /**
     * Message
     * @var $message
     */
    protected $message;

    /**
     * Whether Enabled or not
     * @var $enabled
     */
    protected $enabled;
    
    protected $_storeManager;
    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper _helper
     */
    public function __construct(
        Context $context,
        Helper $helper,
        StoreManagerInterface $storeManager 
    ) {
        $this->_helper  = $helper;
        $this->_request = $context->getRequest();
        $this->_layout  = $context->getLayout();
        $this->_storeManager = $storeManager;
    }

    /**
     * The execute class
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /**
         * Getting Module Configuration from admin panel
         */

        //Getting Username
        $this->username = $this->_helper->getApiUsername();

        //Getting Password
        $this->password = $this->_helper->getApiPassword();

        /**
         * Verification of API Account
         */

        //Verification of API
        $verificationResult = $this->_helper->verifyApi($this->username, $this->password);
        if ($verificationResult == true) {
            //Getting Order Details
            $event = $observer->getEvent();
            $customer = [
                'id'=>$event->getCustomer()->getId(),
                'createdAt'=>$event->getCustomer()->getCreatedAt(),
                'email'=>$event->getCustomer()->getEmail(),
                'firstName'=>$event->getCustomer()->getFirstname(),
                'lastName'=>$event->getCustomer()->getLastname(),
                'shopName' => $this->_storeManager->getStore()->getName(),
            ];
            //Sending SMS to Admin
            if ($this->_helper->isAdminNotificationsEnabled() == 1) {
                $this->senderId = "Your Magento";
                $this->destination = $this->_helper->getAdminSenderId();
                $this->message = $this->_helper->getAdminMessageForRegister();
                $keywords = ['{customer_id}','{created_at}','{email}','{firstname}','{lastname}','{shop_name}'];
                $this->message = str_replace($keywords, $customer, $this->message);
                $this->_helper->sendSms(
                    $this->username,
                    $this->password,
                    $this->senderId,
                    $this->destination,
                    $this->message
                );
            }
        }
    }
}