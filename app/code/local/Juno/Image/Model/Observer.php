<?php

/**
 * Author: Hieu Nguyen
 */
class Juno_Image_Model_Observer
{
    const PATH_FOLDER = 'juno_image/image_compress/folder';
    protected $_images;

    /**
     * collect list image of that should be optimized, specify by configuration
     */
    protected function _initImages()
    {
        $folders = explode(';', Mage::getStoreConfig(self::PATH_FOLDER));
        foreach ($folders as $folder) {
            $path = Mage::getBaseDir() . DS . $folder . DS;
            if (empty($folder) || !file_exists($path)) continue;
            $directory = new RecursiveDirectoryIterator($path);
            $iterator = new RecursiveIteratorIterator($directory);
            $files = new RegexIterator($iterator, '/^.+\.(jpg)$/i', RecursiveRegexIterator::GET_MATCH);
            foreach ($files as $file) {
                if (file_exists($file[0])) {
                    $this->_images[] = $file[0];
                }
            }
        }
    }

    /**
     * compress the image, this should be trigger by cron
     */
    public function optimizeImage()
    {
        if (!Mage::helper('juno_image')->isEnable()) {
            return;
        }
        $this->_initImages();
        $optimizedImages = Mage::helper('juno_image')->getCompressedImage();
        $images = array_diff($this->_images, $optimizedImages);
        foreach ($images as $image) {
            Mage::helper('juno_image/image')->compress($this->_getImagePath($image));
        }
    }

    /**
     * @param $image
     * @return int
     */
    protected function _getImageKey($image)
    {
        $key = filesize($image);
        while (!empty($this->_images[$key])) {
            $key++;
        }

        return $key;
    }

    /**
     * @param $imgPath
     * @return string
     */
    protected function _getImagePath($imgPath)
    {
        return substr($imgPath, strlen(Mage::getBaseDir()) + 1);
    }
}