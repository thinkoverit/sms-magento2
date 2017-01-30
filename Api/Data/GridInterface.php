<?php
namespace Pixel6\Sms\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const SENDER_ID = 'sender_id';
    const DESTINATION = 'destination';
    const SENT_AT = 'sent_at';
    const MESSAGE = 'message';
    const STATUS = 'status';
 
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId();
 
    /**
     * Set EntityId.
     */
    public function setEntityId($entityId);
 
    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getSenderId();
 
    /**
     * Set Content.
     */
    public function setSenderId($sender_id);
 
    /**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getDestination();
 
    /**
     * Set PublishDate.
     */
    public function setDestination($destination);
 
    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getSentAt();
 
    /**
     * Set StartingPrice.
     */
    public function setSentAt($sent_at);
 
    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getMessage();
 
    /**
     * Set UpdateTime.
     */
    public function setMessage($message);
 
    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getStatus();
 
    /**
     * Set CreatedAt.
     */
    public function setStatus($status);
}