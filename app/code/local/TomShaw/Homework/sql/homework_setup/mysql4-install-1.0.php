<?php

$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('tomshaw_homework')};
CREATE TABLE {$this->getTable('tomshaw_homework')} (
  `homework_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `priority` tinyint(1) NOT NULL DEFAULT '1',
  `store_id` tinyint(3) unsigned NOT NULL default '0',
  `due_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`homework_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('tomshaw_student')};
CREATE TABLE {$this->getTable('tomshaw_student')} (
  `student_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `homework_id` int(10) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`student_id`),
  KEY `FK_HOMEWORK_PARENT` (`homework_id`),
  KEY `FK_CUSTOMER_STUDENT` (`customer_id`),
  CONSTRAINT `FK_HOMEWORK_PARENT` FOREIGN KEY (`homework_id`) REFERENCES {$this->getTable('tomshaw_homework')} (`homework_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CUSTOMER_STUDENT` FOREIGN KEY (`customer_id`) REFERENCES {$this->getTable('customer_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
