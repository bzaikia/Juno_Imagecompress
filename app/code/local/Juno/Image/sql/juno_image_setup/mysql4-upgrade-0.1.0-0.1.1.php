<?php
/**
 * Author: Hieu Nguyen
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$attributeSetTable = $resource->getTableName('image_compress');
$installer->getConnection()->addColumn($attributeSetTable, 'hash', 'varchar(99) DEFAULT ""');

$installer->getConnection()->createTable($table);

$installer->endSetup();