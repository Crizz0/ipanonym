<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2020 Crizzo <https://www.crizzo.de>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace crizzo\ipanonym\migrations;

class v102 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\crizzo\ipanonym\migrations\init_install',
		);
	}

	public function update_data()
	{
		$data = array(
				// Add ACP module
				array('module.add', array(
					'acp',
					'ACP_IP_ANONYM_TITLE',
					array(
						'module_basename'	=> '\crizzo\ipanonym\acp\ipanonym_module',
						'modes'				=> array('ipanonym_stats'),
					),
				)),
				// Configs for disable adding a log entry
				array('config.add', array('crizzo_ipanonym_log_add_entry', 1)),
				array('config.add', array('crizzo_ipanonym_log_add_entry_counter', 1, true)),
		);
		return $data;
	}
}
