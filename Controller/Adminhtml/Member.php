<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Controller\Adminhtml;

abstract class Member extends \Magento\Backend\App\Action
{
    /**
     * Member Factory
     * 
     * @var \Zeeshan\Affiliate\Model\MemberFactory
     */
    protected $_memberFactory;

    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result redirect factory
     * 
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $_resultRedirectFactory;

    /**
     * constructor
     * 
     * @param \Zeeshan\Affiliate\Model\MemberFactory $memberFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Zeeshan\Affiliate\Model\MemberFactory $memberFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_memberFactory           = $memberFactory;
        $this->_coreRegistry          = $coreRegistry;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    /**
     * Init Member
     *
     * @return \Zeeshan\Affiliate\Model\Member
     */
    protected function _initMember()
    {
        $memberId  = (int) $this->getRequest()->getParam('member_id');
        /** @var \Zeeshan\Affiliate\Model\Member $member */
        $member    = $this->_memberFactory->create();
        if ($memberId) {
            $member->load($memberId);
        }
        $this->_coreRegistry->register('zeeshan_affiliate_member', $member);
        return $member;
    }
}
