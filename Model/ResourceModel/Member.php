<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Model\ResourceModel;

class Member extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Date model
     * 
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        $this->_date = $date;
        parent::__construct($context);
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('zeeshan_affiliate_member', 'member_id');
    }

    /**
     * Retrieves Member Name from DB by passed id.
     *
     * @param string $id
     * @return string|bool
     */
    public function getMemberNameById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'name')
            ->where('member_id = :member_id');
        $binds = ['member_id' => (int)$id];
        return $adapter->fetchOne($select, $binds);
    }
    /**
     * before save callback
     *
     * @param \Magento\Framework\Model\AbstractModel|\Zeeshan\Affiliate\Model\Member $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdatedAt($this->_date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }
        return parent::_beforeSave($object);
    }
}
