<?php
class DeleteSettingIdOfProjectsEtc extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_setting_id_of_projects_etc';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'projects' => array('setting_id'),
			),
			'alter_field' => array(
				'projects' => array(
					'max_back_level' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '支援パターン数', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'create_field' => array(
				'projects' => array(
					'setting_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
				),
			),
			'alter_field' => array(
				'projects' => array(
					'max_back_level' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '支援パターン数', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
