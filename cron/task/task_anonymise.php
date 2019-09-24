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
	public function anonymise_ips($time_run, $last_purge, $db)
	{
		// postings
		$sql = 'UPDATE ' . POSTS_TABLE . "
			SET poster_ip = '127.0.0.3'
			WHERE post_time < " . (int)$time_run; // between time_run and (int)$last_purge
		$db->sql_query_limit($sql, 500);

		// private messages
		$sql = 'UPDATE ' . PRIVMSGS_TABLE . "
			SET author_ip = '127.0.0.3'
			WHERE message_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 500);

		// user
		$sql = 'UPDATE ' . USERS_TABLE . "
			SET user_ip = '127.0.0.3'
			WHERE user_regdate < " . (int)$time_run;
		$db->sql_query_limit($sql, 500);

		// logs
		$sql = 'UPDATE ' . LOG_TABLE . "
			SET log_ip = '127.0.0.3'
			WHERE log_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 500);

		// polls
		$sql = 'UPDATE ' . POLL_VOTES_TABLE . "
			SET vote_user_ip = '127.0.0.3'";
		$db->sql_query_limit($sql, 100);

		// sessions
		$sql = 'UPDATE ' . SESSIONS_TABLE . "
			SET session_ip = '127.0.0.3'
			WHERE session_time < " . (int)$time_run;
		$db->sql_query_limit($sql, 500);

		$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . "
			SET last_ip = '127.0.0.3'";
		$db->sql_query($sql);
	}
}
