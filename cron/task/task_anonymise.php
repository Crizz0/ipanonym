<?php
/**
 *
 * IP anonymised extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Crizzo <https://www.crizzo.de>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace crizzo\ipanonym\cron\task;


/**
 * IP-anonymise cron task.
 */

class task_anonymise
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \dmzx\mchat\core\settings */
	protected $mchat;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config							$config
	 * @param \phpbb\db\driver\driver_interface				$db
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \dmzx\mchat\core\settings $mchat = null)
	{
		$this->config 		= $config;
		$this->db			= $db;
		$this->mchat		= $mchat;
	}

	public function anonymise_ips($time_run)
	{
		$sql_query_runs = (int) $this->config['crizzo_ipanonym_sql_query_runs'];

		// postings
		$sql = 'UPDATE ' . POSTS_TABLE . "
			SET poster_ip = '127.0.0.1'
			WHERE post_time < " . (int) $time_run . " AND poster_ip <> '127.0.0.1'
			ORDER BY post_time ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// private messages
		$sql = 'UPDATE ' . PRIVMSGS_TABLE . "
			SET author_ip = '127.0.0.1'
			WHERE message_time < " . (int) $time_run . " AND author_ip <> '127.0.0.1'
			ORDER BY message_time ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// user
		$sql = 'UPDATE ' . USERS_TABLE . "
			SET user_ip = '127.0.0.1'
			WHERE user_regdate < " . (int) $time_run . " AND user_ip <> '127.0.0.1'
			ORDER BY user_regdate ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// logs
		$sql = 'UPDATE ' . LOG_TABLE . "
			SET log_ip = '127.0.0.1'
			WHERE log_time < " . (int) $time_run . " AND log_ip <> '127.0.0.1'
			ORDER BY log_time ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// polls; The ACP description tells the admin, that these entries are overwritten regardless of their the age.
		$sql = 'UPDATE ' . POLL_VOTES_TABLE . "
			SET vote_user_ip = '127.0.0.1'
			WHERE vote_user_ip <> '127.0.0.1'
			ORDER BY topic_id ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// sessions
		$sql = 'UPDATE ' . SESSIONS_TABLE . "
			SET session_ip = '127.0.0.1'
			WHERE session_time < " . (int) $time_run . " AND session_ip <> '127.0.0.1'
			ORDER BY session_time ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
			SET last_ip = '127.0.0.1'
			WHERE last_login < " . (int) $time_run . " AND last_ip <> '127.0.0.1'
			ORDER BY last_login ASC";
		$this->db->sql_query_limit($sql, $sql_query_runs);

		// mchat messages
		if (is_callable([$this->mchat, 'get_table_mchat']))
		{
			$sql = 'UPDATE ' . $this->mchat->get_table_mchat() . "
				SET user_ip = '127.0.0.1'
				WHERE message_time < " . (int) $time_run . " AND user_ip <> '127.0.0.1'
				ORDER BY message_time ASC";
			$this->db->sql_query_limit($sql, $sql_query_runs);
		}

		// mchat logs
		if (is_callable([$this->mchat, 'get_table_mchat_log']))
		{
			$sql = 'UPDATE ' . $this->mchat->get_table_mchat_log() . "
				SET log_ip = '127.0.0.1'
				WHERE log_time < " . (int) $time_run . " AND log_ip <> '127.0.0.1'
				ORDER BY log_time ASC";
			$this->db->sql_query_limit($sql, $sql_query_runs);
		}
	}
}
