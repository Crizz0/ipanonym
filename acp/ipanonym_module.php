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
	protected $db;
	protected $language;
	protected $request;
	protected $template;
	protected $user;

	public function main($id, $mode)
	{

		global $config, $template, $request, $phpbb_container, $db, $user;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;

		// Mode switch start
		switch ($mode)
		{
			// Settings
			case 'ipanonym_settings':
				// Add the ipanonym ACP lang file
				$this->language->add_lang('acp', 'crizzo/ipanonym');

				$this->tpl_name = 'acp_ipanonym_main';
				$this->page_title = ('ACP_IP_ANONYM_MAIN');

				$form_name = 'IP_ANONYM_ACP_MAIN';
				add_form_key($form_name);
				$error = '';

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key($form_name))
					{
						$error = $this->language->lang('FORM_INVALID');
					}

					if (empty($error) && $this->request->is_set_post('submit'))
					{
						$this->config->set('crizzo_ipanonym_enable', $this->request->variable('crizzo_ipanonym_enable', false));
						$this->config->set('crizzo_ipanonym_max_age', $this->request->variable('crizzo_ipanonym_max_age', 0));
						$this->config->set('crizzo_ipanonym_sql_query_runs', $this->request->variable('crizzo_ipanonym_sql_query_runs', 0));
						$this->config->set('crizzo_ipanonym_should_run_time', $this->request->variable('crizzo_ipanonym_should_run_time', 0));
						$this->config->set('crizzo_ipanonym_log_add_entry', $this->request->variable('crizzo_ipanonym_log_add_entry', 0));

						trigger_error($this->language->lang('ACP_IP_ANONYM_UPDATED') . adm_back_link($this->u_action));
					}
				}

				$this->template->assign_vars(array(
					'ERRORS'								=> $error,
					'U_ACTION'								=> $this->u_action,

					'IP_ANONYM_ENABLED'						=> $this->config['crizzo_ipanonym_enable'],
					'IP_ANONYM_MAX_AGE_VALUE'				=> $this->config['crizzo_ipanonym_max_age'],
					'ACP_IP_ANONYM_QUERY_RUNS_VALUE'		=> $this->config['crizzo_ipanonym_sql_query_runs'],
					'ACP_IP_ANONYM_SHOULD_RUN_TIME_VALUE'	=> $this->config['crizzo_ipanonym_should_run_time'],
					'ACP_IP_ANONYM_LOG_ADD_ENTRY_VALUE'		=> $this->config['crizzo_ipanonym_log_add_entry'],
				));
			break;

			// Statistics
			case 'ipanonym_stats':

				// Add the ipanonym ACP lang file
				$this->language->add_lang('acp_stats', 'crizzo/ipanonym');

				// Check for mChat availability
				if ($phpbb_container->has('dmzx.mchat.settings'))
				{
					$mchat = $phpbb_container->get('dmzx.mchat.settings');
				}
				else
				{
					$mchat = null;
				}

				$this->tpl_name = 'acp_ipanonym_stats';
				$this->page_title = ('ACP_IP_ANONYM_STATS');

				// Get the information from the database
				// posts
				$sql = 'SELECT post_time FROM ' . POSTS_TABLE . "
					WHERE poster_ip <> '127.0.0.1'
					ORDER BY post_time ASC";
				$result = $this->db->sql_query_limit($sql, 1);
				$row = $this->db->sql_fetchrow($result);
				$oldest_post = $row ? $row['post_time'] : 0;
				$this->db->sql_freeresult($result);

				// private messages
				$sql = 'SELECT message_time FROM ' . PRIVMSGS_TABLE . "
					WHERE author_ip <> '127.0.0.1'
					ORDER BY message_time ASC";
				$result = $this->db->sql_query_limit($sql, 1);
				$row = $this->db->sql_fetchrow($result);
				$oldest_pm = $row ? $row['message_time'] : 0;
				$this->db->sql_freeresult($result);

				// user
				$sql = 'SELECT user_regdate FROM ' . USERS_TABLE . "
					WHERE user_ip <> '127.0.0.1'
					ORDER BY user_regdate ASC";
				$result = $this->db->sql_query_limit($sql, 1);
				$row = $this->db->sql_fetchrow($result);
				$oldest_user = $row ? $row['user_regdate'] : 0;
				$this->db->sql_freeresult($result);

				// logs
				$sql = 'SELECT log_time FROM ' . LOG_TABLE . "
					WHERE log_ip <> '127.0.0.1'
					ORDER BY log_time ASC";
				$result = $this->db->sql_query_limit($sql, 1);
				$row = $this->db->sql_fetchrow($result);
				$oldest_log = $row ? $row['log_time'] : 0;
				$this->db->sql_freeresult($result);

				// mchat statistics
				if (is_callable([$mchat, 'get_table_mchat']) && is_callable([$mchat, 'get_table_mchat_log']))
				{
					// mchat messages
					$mchat_avail = true;
					$sql = 'SELECT message_time FROM ' . $mchat->get_table_mchat() . "
						WHERE user_ip <> '127.0.0.1'
						ORDER BY message_time ASC";
					$result = $this->db->sql_query_limit($sql, 1);
					$row = $this->db->sql_fetchrow($result);
					$oldest_mchat_message = $row ? $row['message_time'] : 0;
					$this->db->sql_freeresult($result);

					// mchat logs
					$mchat_log_avail = true;
					$sql = 'SELECT log_time FROM ' . $mchat->get_table_mchat_log() . "
						WHERE log_ip <> '127.0.0.1'
						ORDER BY log_time ASC";
					$result = $this->db->sql_query_limit($sql, 1);
					$row = $this->db->sql_fetchrow($result);
					$oldest_mchat_log = $row ? $row['log_time'] : 0;
					$this->db->sql_freeresult($result);

					// Template events for mChat
					$this->template->assign_vars(array(
						'MCHAT_AVAILABLE'			=> $mchat_avail,
						'MCHAT_LOG_AVAILABLE'		=> $mchat_log_avail,
						'OLDEST_MCHAT_MESSAGE'		=> $oldest_mchat_message ? $this->user->format_date($oldest_mchat_message) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
						'OLDEST_MCHAT_LOG'			=> $oldest_mchat_log ? $this->user->format_date($oldest_mchat_log) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
					));
				}

				$cronjob_last_run_time = $this->config['crizzo_ipanonym_lastpurge'];

				$this->template->assign_vars(array(
					'CRONJOB_LAST_RUN_TIME'		=> $cronjob_last_run_time ? $this->user->format_date($cronjob_last_run_time) : $this->language->lang('ACP_IP_ANONYM_NO_CRONJOB_RUN'),
					'OLDEST_POST_TIME'			=> $oldest_post ? $this->user->format_date($oldest_post) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
					'OLDEST_PM_TIME'			=> $oldest_pm ? $this->user->format_date($oldest_pm) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
					'OLDEST_USER_TIME'			=> $oldest_user ? $this->user->format_date($oldest_user) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
					'OLDEST_LOG_TIME'			=> $oldest_log ? $this->user->format_date($oldest_log) : $this->language->lang('ACP_IP_ANONYM_NO_DATE'),
				));

			break;
		}
	}
}
