<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Controller\Adminhtml\Member;

use Magento\Framework\Exception\LocalizedException as FrameworkException;

class Save extends \Zeeshan\Affiliate\Controller\Adminhtml\Member
{
    /**
     * Upload model
     * 
     * @var \Zeeshan\Affiliate\Model\Upload
     */
    protected $_uploadModel;


    /**
     * Image model
     * 
     * @var \Zeeshan\Affiliate\Model\Member\Image
     */
    protected $_imageModel;

    /**
     * Backend session
     * 
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;

    /**
     * constructor
     * 
     * @param \Zeeshan\Affiliate\Model\Upload $uploadModel
     * @param \Zeeshan\Affiliate\Model\Member\Image $imageModel
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Zeeshan\Affiliate\Model\MemberFactory $memberFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Zeeshan\Affiliate\Model\Upload $uploadModel,
        \Zeeshan\Affiliate\Model\Member\Image $imageModel,
        \Magento\Backend\Model\Session $backendSession,
        \Zeeshan\Affiliate\Model\MemberFactory $memberFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_uploadModel    = $uploadModel;
        $this->_imageModel     = $imageModel;
        $this->_backendSession = $backendSession;
        parent::__construct($memberFactory, $registry, $resultRedirectFactory, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('member');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            //$data = $this->_filterData($data);
            $member = $this->_initMember();
            $member->setData($data);
            //$profile_picture = 
			//echo $this->_imageModel->getBaseDir();
			
			//echo "<br />";
			
			//print_r($data);
			
			//print_r($_FILES);
			
			$profile_picture	=	$this->_uploadModel->uploadFileAndGetName('profile_picture', $this->_imageModel->getBaseDir(), $data);
            $member->setProfilePicture($profile_picture);
            //$sampleUploadFile = $this->_uploadModel->uploadFileAndGetName('sample_upload_file', $this->_fileModel->getBaseDir(), $data);
            //$member->setSampleUploadFile($sampleUploadFile);
            $this->_eventManager->dispatch(
                'zeeshan_affiliate_member_prepare_save',
                [
                    'member' => $member,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $member->save();
                $this->messageManager->addSuccess(__('The Member has been saved.'));
                $this->_backendSession->setZeeshanAffiliateMemberData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'zeeshan_affiliate/*/edit',
                        [
                            'member_id' => $member->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('zeeshan_affiliate/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Member.'));
            }
            $this->_getSession()->setZeeshanAffiliateMemberData($data);
            $resultRedirect->setPath(
                'zeeshan_affiliate/*/edit',
                [
                    'member_id' => $member->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('zeeshan_affiliate/*/');
        return $resultRedirect;
    }

}
