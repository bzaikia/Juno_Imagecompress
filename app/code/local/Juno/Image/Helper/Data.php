<?php

/**
 * Author: Hieu Nguyen
 */
class Juno_Image_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PATH = 'juno_image/image_compress/enabled';
    protected $_images;

    /**
     * @return bool
     */
    public function isEnable()
    {
        return Mage::getStoreConfig(self::PATH);
    }

    /**
     * @return array
     */
    public function getCompressedImage()
    {
        if (!isset($this->_images)) {
            $resource = Mage::getSingleton('core/resource');
            $result = array();
            $sql = $this->_getWriteAdapter()
                ->select()->from($resource->getTableName('image_compress'), 'path');
            $result = $this->_getWriteAdapter()->fetchCol($sql);

            $this->_images = $result;
        }
        return $this->_images;
    }

    /**
     * @return Magento_Db_Adapter_Pdo_Mysql
     */
    protected function _getWriteAdapter()
    {
        $resource = Mage::getSingleton('core/resource');
        /**
         * @var $writeAdapter Magento_Db_Adapter_Pdo_Mysql
         */
        $writeAdapter = $resource->getConnection('core_write');
        return $writeAdapter;
    }
}