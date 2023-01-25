<?php

$installer = $this;
$installer->startSetup();

Mage::log('setup', null, 'orderorigin.log');

$installer->run(" 
ALTER TABLE `{$installer->getTable('sales/order')}` ADD `utm_source` VARCHAR(255) NOT NULL;
ALTER TABLE `{$installer->getTable('sales/order')}` ADD `utm_campaign` VARCHAR(255) NOT NULL;
ALTER TABLE `{$installer->getTable('sales/order')}` ADD `utm_medium` VARCHAR(255) NOT NULL;
");

$installer->endSetup();