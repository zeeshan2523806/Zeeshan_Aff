<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */
namespace Zeeshan\Affiliate\Block\Adminhtml\Member\Edit\Tab;

class Member extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Wysiwyg config
     * 
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * Country options
     * 
     * @var \Magento\Config\Model\Config\Source\Locale\Country
     */
    protected $_countryOptions;

    /**
     * Country options
     * 
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $_booleanOptions;

    /**
     * Sample Multiselect options
     * 
     * @var \Zeeshan\Affiliate\Model\Member\Source\SampleMultiselect
     */
    protected $_sampleMultiselectOptions;

    /**
     * constructor
     * 
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Config\Model\Config\Source\Yesno $booleanOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Config\Model\Config\Source\Yesno $booleanOptions,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    )
    {
        $this->_wysiwygConfig            = $wysiwygConfig;
        $this->_booleanOptions           = $booleanOptions;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Zeeshan\Affiliate\Model\Member $member */
        $member = $this->_coreRegistry->registry('zeeshan_affiliate_member');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('member_');
        $form->setFieldNameSuffix('member');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Member Information'),
                'class'  => 'fieldset-wide'
            ]
        );
       
        if ($member->getId()) {
            $fieldset->addField(
                'member_id',
                'hidden',
                ['name' => 'member_id']
            );
        }
        $fieldset->addField(
            'name',
            'text',
            [
                'name'  => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );
		$fieldset->addField(
            'profile_picture',
            'image',
            [
                'name'  => 'profile_picture',
                'label' => __('Profile Picture'),
                'title' => __('Profile Picture'),
            ]
        );
		$fieldset->addType('image', 'Zeeshan\Affiliate\Block\Adminhtml\Member\Helper\Image');
		$fieldset->addField(
            'status',
            'select',
            [
                'name'  => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'values' => $this->_booleanOptions->toOptionArray(),
            ]
        );

        $memberData = $this->_session->getData('zeeshan_affiliate_member_data', true);
        if ($memberData) {
            $member->addData($memberData);
        } else {
            if (!$member->getId()) {
                $member->addData($member->getDefaultValues());
            }
        }
        $form->addValues($member->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Member');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
