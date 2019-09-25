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
 * IP-anonymise  cron task.
 */

class task_anonymise
{
	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config							$config
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config 					= $config;
	}

	public function anonymise_ips($time_run, $db)
	{
		$sql_query_runs = (int) $this->config['crizzo_ipanonym_sql_query_runs'];
		
		// postings
		$sql = 'UPDATE ' . POSTS_TABLE . '
			SET poster_ip = "127.0.0.1"
			WHERE post_time < ' . (int)$time_run . ' AND poster_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		// private messages
		$sql = 'UPDATE ' . PRIVMSGS_TABLE . '
			SET author_ip = "127.0.0.1"
			WHERE message_time < ' . (int)$time_run . ' AND author_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		// user
		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_ip = "127.0.0.1"
			WHERE user_regdate < ' . (int)$time_run . ' AND user_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		// logs
		$sql = 'UPDATE ' . LOG_TABLE . '
			SET log_ip = "127.0.0.1"
			WHERE log_time < ' . (int)$time_run . ' AND log_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		// polls
		$sql = 'UPDATE ' . POLL_VOTES_TABLE . '
			SET vote_user_ip = "127.0.0.1"
			WHERE vote_user_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		// sessions
		$sql = 'UPDATE ' . SESSIONS_TABLE . '
			SET session_ip = "127.0.0.1"
			WHERE session_time < ' . (int)$time_run . ' AND session_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);

		$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . '
			SET last_ip = "127.0.0.1"
			WHERE last_ip <> "127.0.0.1"';
		$db->sql_query_limit($sql, $sql_query_runs);
	}
}
