<?php

	Class extension_timefield extends Extension{

		public function uninstall(){
			return Symphony::Database()->query("DROP TABLE `tbl_fields_time`");
		}

		public function install(){
			return Symphony::Database()->query("
					CREATE TABLE `tbl_fields_time` (
					`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
					`field_id` INT(11) UNSIGNED NOT NULL,
					PRIMARY KEY  (`id`),
					UNIQUE KEY `field_id` (`field_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			");
		}

	}
