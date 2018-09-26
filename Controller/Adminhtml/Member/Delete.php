<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */
namespace Zeeshan\Affiliate\Controller\Adminhtml\Member;

class Delete extends \Zeeshan\Affiliate\Controller\Adminhtml\Member
{
    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('member_id');
        if ($id) {
            $name = "";
            try {
                /** @var \Zeeshan\Affiliate\Model\Member $member */
                $member = $this->_memberFactory->create();
                $member->load($id);
                $name = $member->getName();
                $member->delete();
                $this->messageManager->addSuccess(__('The Member has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_zeeshan_affiliate_member_on_delete',
                    ['name' => $name, 'status' => 'success']
                );
                $resultRedirect->setPath('zeeshan_affiliate/*/');
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_zeeshan_affiliate_member_on_delete',
                    ['name' => $name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('zeeshan_affiliate/*/edit', ['member_id' => $id]);
                return $resultRedirect;
            }
        }
        // display error message
        $this->messageManager->addError(__('Member to delete was not found.'));
        // go to grid
        $resultRedirect->setPath('zeeshan_affiliate/*/');
        return $resultRedirect;
    }
}
