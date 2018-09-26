<?php
/**
 * Zeeshan_Affiliate | A test module for Sun and Sand Sports UAE
   @category  Zeeshan
   @package   Zeeshan_Affiliate

 */namespace Zeeshan\Affiliate\Model;

use Magento\Framework\Exception\LocalizedException as FrameworkException;
class Upload
{
    /**
     * Upload model factory
     * 
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_uploaderFactory;
	
	protected $_file;
	
	
	/**
     * Image model
     * 
     * @var \Zeeshan\Affiliate\Model\Member\Image
     */
    protected $_imageModel;

    /**
     * constructor
     * 
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     */
    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
		\Magento\Framework\Filesystem\Io\File $file,
		\Zeeshan\Affiliate\Model\Member\Image $imageModel
    )
    {
        $this->_file	=	$file;
		$this->_imageModel     = $imageModel;
		$this->_uploaderFactory = $uploaderFactory;
    }

    /**
     * upload file
     *
     * @param $input
     * @param $destinationFolder
     * @param $data
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function uploadFileAndGetName($input, $destinationFolder, $data)
    {
       try {
        if (isset($data[$input]['delete'])) {
            return '';
        } else {
			if (!is_dir($destinationFolder)) {
				$ioAdapter = $this->_file;
				$ioAdapter->mkdir($destinationFolder, 0775);
			}
            $uploader = $this->_uploaderFactory->create(['fileId' => $input]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            $result = $uploader->save($destinationFolder);
            return $this->_imageModel->getBaseUrl()."/".$result['file'];
        }
    } catch (\Exception $e) {
        if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
            return $e->getMessage();
        } else {
            if (isset($data[$input]['value'])) {
                return $data[$input]['value'];
            }
        }
    }
    return '';
}
}
