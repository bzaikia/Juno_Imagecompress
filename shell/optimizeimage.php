<?php
/**
 * Author: Hieu Nguyen
 */

require_once 'shell/abstract.php';

class Optimize_Image extends Mage_Shell_Abstract
{
    public function run()
    {
        Mage::getModel('juno_image/observer')->optimizeImage();
    }
}

ini_set("memory_limit", "1024M");
$obj = new Optimize_Image();
$obj->run();