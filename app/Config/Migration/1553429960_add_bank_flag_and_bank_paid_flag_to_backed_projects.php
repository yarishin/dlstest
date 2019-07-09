<?php
class AddBankFlagAndBankPaidFlagToBackedProjects extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_bank_flag_and_bank_paid_flag_to_backed_projects';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'backed_projects' => array(
					'bank_flag' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'manual_flag'),
					'bank_paid_flag' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'after' => 'bank_flag'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'backed_projects' => array('bank_flag', 'bank_paid_flag'),
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
