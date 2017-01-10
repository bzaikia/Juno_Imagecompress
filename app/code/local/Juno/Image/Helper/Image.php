<?php

/**
 * Author: Hieu Nguyen
 */
class Juno_Image_Helper_Image extends Mage_Core_Helper_Abstract
{
    const PATH_HOST = 'juno_image/image_compress/host';

    /**
     * compress the image
     *
     * @param $img
     */
    public function compress($img)
    {
        $imgUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $img;
        $filePath = Mage::getBaseDir() . DS . $img;
        $str = file_get_contents($this->getOptimizeImageUrl($imgUrl));
        if (strlen($str) > 1000) {
            file_put_contents($filePath, file_get_contents($str));
        }

        $this->logImage($filePath);
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function getOptimizeImageUrl($imageUrl)
    {
        $host = Mage::getStoreConfig(self::PATH_HOST);
        return 'http://' . $host . '/?img=' . $imageUrl;
    }

    /**
     * log the compress image into db, so we dont compress same image next time
     *
     * @param $img
     */
    public function logImage($img)
    {
        $resource = Mage::getSingleton('core/resource');
        /**
         * @var $writeAdapter Magento_Db_Adapter_Pdo_Mysql
         */
        $writeAdapter = $resource->getConnection('core_write');
        $data = array(
            'path' => $img
        );
        $writeAdapter->insert($resource->getTableName('image_compress'), $data);
        Mage::log($img, null, 'image_compress.log');
    }
}