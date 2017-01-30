<?php

namespace Pixel6\Sms\Model;
 
use Pixel6\Sms\Api\Data\GridInterface;
 
class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'sms_grid_records';
 
    /**
     * @var string
     */
    protected $_cacheTag = 'sms_grid_records';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'sms_grid_records';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    
    public function __construct(
            \Magento\Framework\Model\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\Stdlib\DateTime\DateTime $date,
            \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
            \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
            array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_date = $date;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Pixel6\Sms\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }
 
    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }
 
    /**
     * Get sender_id.
     *
     * @return varchar
     */
    public function getSenderId()
    {
        return $this->getData(self::SENDER_ID);
    }
 
    /**
     * Set sender_id.
     */
    public function setSenderId($sender_id)
    {
        return $this->setData(self::SENDER_ID, $sender_id);
    }
 
    /**
     * Get destination.
     *
     * @return varchar
     */
    public function getDestination()
    {
        return $this->getData(self::DESTINATION);
    }
 
    /**
     * Set destination.
     */
    public function setDestination($destination)
    {
        return $this->setData(self::DESTINATION, $destination);
    }
 
    /**
     * Get sent_at.
     *
     * @return varchar
     */
    public function getSentAt()
    {
        return $this->getData(self::SENT_AT);
    }
 
    /**
     * Set sent_at.
     */
    public function setSentAt($sent_at)
    {
        return $this->setData(self::SENT_AT, $sent_at);
    }
 
    /**
     * Get message.
     *
     * @return varchar
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }
 
    /**
     * Set message.
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }
 
    /**
     * Get status.
     *
     * @return varchar
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }
 
    /**
     * Set status.
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Check required data
     *
     * @return $this
     */
    public function beforeSave()
    {
        parent::beforeSave();

        // set current date if added at data is not defined
        if (is_null($this->getSentAt())) {
            $this->setSentAt($this->_date->gmtDate());
        }

        return $this;
    }
}