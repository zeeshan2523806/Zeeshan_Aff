<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Controller\Adminhtml\Member;

abstract class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Member Factory
     * 
     * @var \Zeeshan\Affiliate\Model\MemberFactory
     */
    protected $_memberFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Zeeshan\Affiliate\Model\MemberFactory $memberFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Zeeshan\Affiliate\Model\MemberFactory $memberFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_memberFactory = $memberFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $memberItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($memberItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($memberItems) as $memberId) {
            /** @var \Zeeshan\Affiliate\Model\Member $member */
            $member = $this->_memberFactory->create()->load($memberId);
            try {
                $memberData = $memberItems[$memberId];//todo: handle dates
                $member->addData($memberData);
                $member->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithMemberId($member, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithMemberId($member, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithMemberId(
                    $member,
                    __('Something went wrong while saving the Member.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Member id to error message
     *
     * @param \Zeeshan\Affiliate\Model\Member $member
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithMemberId(\Zeeshan\Affiliate\Model\Member $member, $errorText)
    {
        return '[Member ID: ' . $member->getId() . '] ' . $errorText;
    }
}
