<?php

namespace Pixel6\Sms\Model\ResourceModel\Grid;

 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Pixel6\Sms\Model\Grid', 'Pixel6\Sms\Model\ResourceModel\Grid');
    }
}