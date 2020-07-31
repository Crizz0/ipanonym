<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2020 Crizzo <https://www.crizzo.de>
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
class ipanonym_stats
{
	public $tpl_name;
	public $page_title;

	protected $config;
	protected $template;

	public function main($id, $mode)
	{

		global $config, $template, $phpbb_container;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Add the ipanonym ACP lang file
		$language->add_lang('acp_stats', 'crizzo/ipanonym');

		$this->config = $config;
		$this->template = $template;

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


		$this->template->assign_vars(array(
			'ACP_IP_ANONYM_QUERY_RUNS_VALUE'		=> $this->config['crizzo_ipanonym_lastpurge'],
			'MCHAT_AVAILABLE'		=> $mchat_avail,
			'MCHAT_LOG_AVAILABLE'	=> $mchat_log_avail,
		));
	}
}
