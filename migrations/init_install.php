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

	public static function depends_on()
	{
		 return array(
			'\phpbb\db\migration\data\v32x\v324',
		);
	}

	public function update_data()
	{
		$data = array(
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
				array('config.add', array('crizzo_ipanonym_enable', 0)),
				array('config.add', array('crizzo_ipanonym_lastpurge', 0, true)),
				array('config.add', array('crizzo_ipanonym_max_age', 180)),
				array('config.add', array('crizzo_ipanonym_sql_query_runs', 200)),
				array('config.add', array('crizzo_ipanonym_should_run_time', 120)),

				// Add permissions
				array('permission.add', array('a_ipanonym', true)),
			);

			// Check if admin role exists and assign permission to admin role
			if ($this->role_exists('ROLE_ADMIN_FULL'))
			{
				$data[] = array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ipanonym', 'role', true));
			}

			return $data;
	}

	/**
	 * Checks whether the given role does exist or not.
	 *
	 * @param String $role the name of the role
	 * @return true if the role exists, false otherwise
	 * Source: https://github.com/paul999/mention/
	 */
	private function role_exists($role)
	{
		$sql = 'SELECT role_id
		FROM ' . ACL_ROLES_TABLE . "
		WHERE role_name = '" . $this->db->sql_escape($role) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$role_id = $this->db->sql_fetchfield('role_id');
		$this->db->sql_freeresult($result);
		return $role_id;
	}
}
