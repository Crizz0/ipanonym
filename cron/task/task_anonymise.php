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
	public function anonymise_ips($time_run, $db)
	{
		// postings
		$sql = 'UPDATE ' . POSTS_TABLE . "
			SET poster_ip = '127.0.0.2'
			WHERE post_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 200);

		// private messages
		$sql = 'UPDATE ' . PRIVMSGS_TABLE . "
			SET author_ip = '127.0.0.2'
			WHERE message_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 200);

		// user
		$sql = 'UPDATE ' . USERS_TABLE . "
			SET user_ip = '127.0.0.2'
			WHERE user_regdate < " . (int)$time_run;
		$db->sql_query_limit($sql, 200);

		// logs
		$sql = 'UPDATE ' . LOG_TABLE . "
			SET log_ip = '127.0.0.2'
			WHERE log_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 200);

		// polls
		$sql = 'UPDATE ' . POLL_VOTES_TABLE . "
			SET vote_user_ip = '127.0.0.2'";
		$db->sql_query_limit($sql, 200);

		// sessions
		$sql = 'UPDATE ' . SESSIONS_TABLE . "
			SET session_ip = '127.0.0.2'
			WHERE session_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 200);

		$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
			SET last_ip = '127.0.0.2'";
		$db->sql_query($sql);
	}
}
