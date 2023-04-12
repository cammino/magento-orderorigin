<?php

$installer = $this;
$installer->startSetup();

Mage::log('update 1.0.1', null, 'orderorigin.log');

$installer->run(" 
ALTER TABLE `{$installer->getTable('sales/order')}` ADD `gclid` VARCHAR(255) NOT NULL;
");

$installer->endSetup();