<?php

namespace Pixel6\Sms\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\View\Element\Context;
use \Pixel6\Sms\Helper\Data                 as Helper;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * Customer login observer
 */
class InvoicePay implements ObserverInterface
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

        //Getting Sender ID
        $this->senderId = $this->_helper->getCustomerSenderIdonInvoiced();

        //Getting Message
        $this->message  = $this->_helper->getCustomerMessageOnInvoiced();

        //Getting Customer Notification value
        $this->enabled  = $this->_helper->isCustomerNotificationsEnabledOnInvoiced();

        //Checking if sms is enable or not
        if ($this->enabled == 1) {
            /**
             * Verification of API Account
             */
            //Verification of API
            $verificationResult = $this->_helper->verifyApi($this->username, $this->password);
            if ($verificationResult == true) {
                //Getting Order Details
                $invoice   = $observer->getInvoice();
                $order     = $invoice->getOrder($invoice);
                $orderData = [
                    'orderId'       => $order->getIncrementId(),
                    'invoiceId'       => $invoice->getIncrementId(),
                    'firstname'     => $order->getCustomerFirstname(),
                    '$middlename'   => $order->getCustomerMiddlename(),
                    'lastname'      => $order->getCustomerLastname(),
                    'customerDob'   => $order->getCustomerDob(),
                    'customerEmail' => $order->getCustomerEmail(),
                    'totalPrice'    => number_format($order->getGrandTotal(), 2),
                    'countryCode'   => $order->getOrderCurrencyCode(),
                    'gender'        => ($order->getCustomerGender() ? 'Female' : 'Male'),
                    'protectCode'   => $order->getProtectCode(),
                    'shopName' => $this->_storeManager->getStore()->getName(),
                ];
                //Getting Telephone Number
                $this->destination = $order->getBillingAddress()->getTelephone();

                //Manipulating SMS
                $this->message = $this->_helper->manipulateInvoiceSMS($this->message, $orderData);

                //Sending SMS
                $this->_helper->sendSms($this->username,
                    $this->password,
                    $this->senderId,
                    $this->destination,
                    $this->message
                );

                //Sending SMS to Admin
                if ($this->_helper->isAdminNotificationsEnabled() == 1) {
                    $this->destination = $this->_helper->getAdminSenderId();
                    $this->message = $this->_helper->getAdminMessageForInvoiced();
                    $this->message = $this->_helper->manipulateInvoiceSMS($this->message, $orderData);
                    $this->_helper->sendSms($this->username,
                        $this->password,
                        $this->senderId,
                        $this->destination,
                        $this->message
                    );
                }
            }
        }


    }
}