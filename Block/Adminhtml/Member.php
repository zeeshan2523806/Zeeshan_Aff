<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */
namespace Zeeshan\Affiliate\Block\Adminhtml;

class Member extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_member';
        $this->_blockGroup = 'Zeeshan_Affiliate';
        $this->_headerText = __('Members');
        $this->_addButtonLabel = __('Create New Member');
        parent::_construct();
    }
}
