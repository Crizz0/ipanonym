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

/**
* @ignore
*/


/**
* @package acp
*/
class ipanonym_module
{
	public $u_action;

	public function main($id, $mode) {

		global $config, $user, $template, $language, $request, $phpbb_container, $db, $phpbb_dispatcher, $phpbb_root_path, $phpEx;



		$this->user = $user;
		$this->request = $request;
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->php_ext = $phpEx;

		$this->tpl_name = 'acp_ipanonym_main';
		$this->page_title = ('ACP_IP_ANONYM_MAIN');

		$form_name = 'IP_ANONYM_ACP_MAIN';
		add_form_key($form_name);
		$error = '';


		$template->assign_vars(array(
			'ERRORS'					=> $error,
			'U_ACTION'					=> $this->u_action,
		));
	}
}
