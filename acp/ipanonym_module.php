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
	public $tpl_name;
	public $page_title;

	protected $config;
	protected $request;
	protected $template;

	public function main($id, $mode) {

		global $config, $template, $request, $phpbb_container;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Add the ipanonym ACP lang file
		$language->add_lang('acp', 'crizzo/ipanonym');

		$this->request = $request;
		$this->config = $config;
		$this->template = $template;

		$this->tpl_name = 'acp_ipanonym_main';
		$this->page_title = ('ACP_IP_ANONYM_MAIN');

		$form_name = 'IP_ANONYM_ACP_MAIN';
		add_form_key($form_name);
		$error = '';

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_name))
			{
				$error = $language->lang('FORM_INVALID');
			}

			if (empty($error) && $this->request->is_set_post('submit'))
			{
				$this->config->set('crizzo_ipanonym_enable', $this->request->variable('crizzo_ipanonym_enable', false));
				$this->config->set('crizzo_ipanonym_max_age', $this->request->variable('crizzo_ipanonym_max_age', 0));
				$this->config->set('crizzo_ipanonym_sql_query_runs', $this->request->variable('crizzo_ipanonym_sql_query_runs', 0));
				$this->config->set('crizzo_ipanonym_should_run_time', $this->request->variable('crizzo_ipanonym_should_run_time', 0));

				trigger_error($language->lang('ACP_IP_ANONYM_UPDATED') . adm_back_link($this->u_action));
			}
		}

		$this->template->assign_vars(array(
			'ERRORS'								=> $error,
			'U_ACTION'								=> $this->u_action,

			'IP_ANONYM_ENABLED'						=> $this->config['crizzo_ipanonym_enable'],
			'IP_ANONYM_MAX_AGE_VALUE'				=> $this->config['crizzo_ipanonym_max_age'],
			'ACP_IP_ANONYM_QUERY_RUNS_VALUE'		=> $this->config['crizzo_ipanonym_sql_query_runs'],
			'ACP_IP_ANONYM_SHOULD_RUN_TIME_VALUE'	=> $this->config['crizzo_ipanonym_should_run_time'],
		));
	}
}
