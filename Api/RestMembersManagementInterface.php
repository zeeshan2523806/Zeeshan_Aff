<?php
namespace Zeeshan\Affiliate\Api;
  
/**
 * Interface RestMembersManagementInterface
 * @package Zeeshan\Affiliate\Api
 */
interface RestMembersManagementInterface
{

	/**
	* @return \Zeeshan\Affiliate\Model\Member
    
     * @throws \Exception
     */
    public function getallmembers();
	
	 /**
     * @param string $status
	 * @return \Zeeshan\Affiliate\Model\Member
    
     * @throws \Exception
     */
	public function getallmembersbystatus($status);


}