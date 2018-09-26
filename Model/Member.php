<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Model;

/**
 * @method Member setName($name)
 * @method Member setTags($tags)
 * @method Member setStatus($status)
 * @method Member setProfilePicture($profile_picture)
 * @method mixed getName()
 * @method mixed getStatus()
 * @method Member setCreatedAt(\string $createdAt)
 * @method string getCreatedAt()
 * @method Member setUpdatedAt(\string $updatedAt)
 * @method string getUpdatedAt()
 */
class Member extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'zeeshan_affiliate_member';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = 'zeeshan_affiliate_member';

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'zeeshan_affiliate_member';


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Zeeshan\Affiliate\Model\ResourceModel\Member');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
