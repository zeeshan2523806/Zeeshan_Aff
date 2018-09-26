<?php
/**
 * Copyright Â© Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Zeeshan\Affiliate\Model;

use Magento\Framework\App\ObjectManager;

/**
 * Repository class
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */

/** @var  \Zeeshan\Affiliate\Model\MemberFactory  **/

protected $_memberFactory;

class RestMembersManagement implements \Zeeshan\Affiliate\Api\RestMembersManagementInterface
{

    public function __construct(
       \Zeeshan\Affiliate\Model\MemberFactory $memberFactory
    ) {
        $this->_memberFactory = $memberFactory;
    }




	  /**
	 * @return \Zeeshan\Affiliate\Model\Member

     */
    public function getallmembers()
    {

        reutrn $this->_memberFactory->create()->getCollection();
    }
	
	 /**
     * @param string $status
	 * @return \Zeeshan\Affiliate\Model\Member
    
     * @throws \Exception
     */
	public function getallmembersbystatus($status)
    {
		
		if($status){
			if($status == 'enable' || $status == 'disable' ){
				if($status == 'enable'){$status = 1;}else{$status=0;}
				// for disabled users

                return $this->_memberFactory->create()->getCollection()
                    ->addFieldToFilter('status', array('eq'=>$status));

			
			}else{
				//error message when different value is provided.
				return 'Status should be either enable|disable';
				}
			
		}else{
			// if status is not set than instead of throwing error we will call the above method
			return $this->getallmembers();
			}
		
		

    }
	
}
