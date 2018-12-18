<?php

	Class extension_timefield extends Extension{

		public function uninstall(){
			return Symphony::Database()
				->drop('tbl_fields_time')
				->ifExists()
				->execute()
				->success();
		}

		public function install(){
			return Symphony::Database()
				->create('tbl_fields_time')
				->ifNotExists()
				->fields([
					'id' => [
						'type' => 'int(11)',
						'auto' => true,
					],
					'field_id' => 'int(11)'
				])
				->keys([
					'id' => 'primary',
					'field_id' => 'unique',
				])
				->execute()
				->success();
		}

	}
