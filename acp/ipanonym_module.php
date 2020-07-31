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
	protected $db;
	protected $user;

	public function main($id, $mode)
	{

		global $config, $template, $request, $phpbb_container, $db, $user;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Mode switch start
		switch ($mode)
		{
			// Settings
			case 'ipanonym_settings':
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
			break;
			
			// Statistics
			case 'ipanonym_stats':

				/** @var \phpbb\language\language $language */
				$language = $phpbb_container->get('language');

				// Add the ipanonym ACP lang file
				$language->add_lang('acp_stats', 'crizzo/ipanonym');

				$this->config = $config;
				$this->template = $template;
				$this->db = $db;
				$this->user = $user;

				$this->tpl_name = 'acp_ipanonym_stats';
				$this->page_title = ('ACP_IP_ANONYM_STATS');

				// Get the information from the database
				// posts
				$sql = 'SELECT post_time FROM ' . POSTS_TABLE . "
					WHERE poster_ip <> '127.0.0.1'
					ORDER BY post_time ASC";
				$oldest_post = $this->db->sql_query_limit($sql, 1);

				// private messages
				$sql = 'SELECT message_time FROM ' . PRIVMSGS_TABLE . "
					WHERE author_ip <> '127.0.0.1'
					ORDER BY message_time ASC";
				$oldest_pm =$this->db->sql_query_limit($sql, 1);

				// user
				$sql = 'SELECT user_regdate FROM ' . USERS_TABLE . "
					WHERE user_ip <> '127.0.0.1'
					ORDER BY user_regdate ASC";
				$oldest_user =$this->db->sql_query_limit($sql, 1);

				// logs
				$sql = 'SELECT log_time FROM ' . LOG_TABLE . "
					WHERE log_ip <> '127.0.0.1'
					ORDER BY log_time ASC";
				$oldest_log =$this->db->sql_query_limit($sql, 1);

				// mchat messages
				if (is_callable([$this->mchat, 'get_table_mchat']))
				{
					$mchat_avail = true;
					$sql = 'SELECT message_time FROM ' . $this->mchat->get_table_mchat() . "
						WHERE user_ip <> '127.0.0.1'
						ORDER BY message_time ASC";
					$oldest_mchat_message = $this->db->sql_query_limit($sql, 1);
				}

				// mchat logs
				if (is_callable([$this->mchat, 'get_table_mchat_log']))
				{
					$mchat_log_avail = true;
					$sql = 'SELECT log_time FROM ' . $this->mchat->get_table_mchat_log() . "
						WHERE log_ip <> '127.0.0.1'
						ORDER BY log_time ASC";
					$oldest_mchat_log =$this->db->sql_query_limit($sql, 1);
				}

				$cronjob_last_run_time = $this->config['crizzo_ipanonym_lastpurge'];

				$this->template->assign_vars(array(
					'MCHAT_AVAILABLE'		=> $mchat_avail,
					'MCHAT_LOG_AVAILABLE'	=> $mchat_log_avail,

					'CRONJOB_LAST_RUN_TIME'		=> $this->user->format_date($cronjob_last_run_time),
					'OLDEST_POST_TIME'			=> $this->user->format_date($oldest_post),
					'OLDEST_PM_TIME'			=> $this->user->format_date($oldest_pm),
					'OLDEST_USER_TIME'			=> $this->user->format_date($oldest_user),
					'OLDEST_LOG_TIME'			=> $this->user->format_date($oldest_log),
					'OLDEST_MCHAT_MESSAGE'		=> $this->user->format_date($oldest_mchat_message),
					'OLDEST_MCHAT_LOG'			=> $this->user->format_date($oldest_mchat_log),
				));
			break;
		}
	}
}
