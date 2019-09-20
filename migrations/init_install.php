<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2019 Crizzo <https://www.crizzo.de>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace crizzo\ipanonym\migrations;

class init_install extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['crizzo_ipanonym_enable']);
	}

	public function update_data()
	{
		return array(
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_IP_ANONYM_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_IP_ANONYM_TITLE',
				array(
					'module_basename'	=> '\crizzo\ipanonym\acp\ipanonym_module',
					'modes'				=> array('ipanonym_settings'),
				),
			)),
			// Add config values
			array('config.add', array('crizzo_ipanonym_enable', false)),
			array('config.add', array('crizzo_ipanonym_lastpurge', '')),
			array('config.add', array('crizzo_ipanonym_max_age', 180)),
			array('config.add', array('crizzo_ipanonym_overwrite', false)),
			array('config.add', array('crizzo_ipanonym_overwrite_time', '01.01.1970')),
			// Add permissions
			array('permission.add', array('a_ipanonym', true)),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ipanonym', 'role', true)),
		);
	}
}
