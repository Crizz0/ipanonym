<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2019 Crizzo <https://www.crizzo.de>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace crizzo\ipanonym\acp;

class ipanonym_info
{
	function module()
	{
		return array(
			'filename'	=> '\crizzo\ipanonym\acp\ipanomym_module',
			'title'		=> 'ACP_IP_ANONYM_TITLE',
			'version'	=> '1.0.1-dev',
			'modes'		=> array(
				'ipanonym_settings'	=> array(
				'title' => 'ACP_IP_ANONYM_SETTINGS',
				'auth' => 'ext_crizzo/ipanonym && acl_a_ipanonym',
				'cat' => array('ACP_IP_ANONYM_TITLE')
				),
			),
		);
	}
}
