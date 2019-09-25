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

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Add the auto groups ACP lang file
		$language->add_lang('acp', 'crizzo/ipanonym');

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

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_name))
			{
				$error = $language->lang('FORM_INVALID');
			}

			if (empty($error) && $request->is_set_post('submit'))
			{
				$config->set('crizzo_ipanonym_enable', $request->variable('crizzo_ipanonym_enable', false));
				$config->set('crizzo_ipanonym_max_age', $request->variable('crizzo_ipanonym_max_age', 0));
				$config->set('crizzo_ipanonym_sql_query_runs', $request->variable('crizzo_ipanonym_sql_query_runs', 0));
				$config->set('crizzo_ipanonym_should_run_time', $request->variable('crizzo_ipanonym_should_run_time', 0));

				trigger_error($language->lang('ACP_IP_ANONYM_UPDATED') . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars(array(
			'ERRORS'					=> $error,
			'U_ACTION'					=> $this->u_action,

			'IP_ANONYM_ENABLED'			=> $config['crizzo_ipanonym_enable'],
			'IP_ANONYM_MAX_AGE_VALUE'	=> $config['crizzo_ipanonym_max_age'],
			'ACP_IP_ANONYM_QUERY_RUNS_VALUE'	=> $config['crizzo_ipanonym_sql_query_runs'],
			'ACP_IP_ANONYM_SHOULD_RUN_TIME_VALUE'	=> $config['crizzo_ipanonym_should_run_time'],
		));
	}
}
