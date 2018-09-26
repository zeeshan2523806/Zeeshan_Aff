<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */
namespace Zeeshan\Affiliate\Block\Adminhtml\Member\Helper;

/**
 * @method string getValue()
 */
class Image extends \Magento\Framework\Data\Form\Element\Image
{
    /**
     * Member image model
     * 
     * @var \Zeeshan\Affiliate\Model\Member\Image
     */
    protected $_imageModel;

    /**
     * constructor
     * 
     * @param \Zeeshan\Affiliate\Model\Member\Image $imageModel
     * @param \Magento\Framework\Data\Form\Element\Factory $factoryElement
     * @param \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        \Zeeshan\Affiliate\Model\Member\Image $imageModel,
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $data
    )
    {
        $this->_imageModel = $imageModel;
        parent::__construct($factoryElement, $factoryCollection, $escaper, $urlBuilder, $data);
    }

    /**
     * Get image preview url
     *
     * @return string
     */
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = $this->_imageModel->getBaseUrl().$this->getValue();
        }
        return $url;
    }
}
