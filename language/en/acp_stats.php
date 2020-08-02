<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2020 Crizzo <https://www.crizzo.de>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'ACP_IP_ANONYM_STATS' 			=> 'Statistics',
	'ACP_IP_ANONYM_STATS_EXPLAIN' 	=> 'On this pages is displayed when the last cronjob run and how old the oldest non anonymised entries are.',

	'ACP_IP_ANONYM_DATE'	=> 'Date',

	'ACP_IP_ANONYM_CRON_LAST_RUN' 			=> 'Cronjob run last:',
	'ACP_IP_ANONYM_OLDEST_POST' 			=> 'Oldest not anonymised post:',
	'ACP_IP_ANONYM_OLDEST_PM' 				=> 'Oldest not anonymised private message:',
	'ACP_IP_ANONYM_OLDEST_USER' 			=> 'Oldest not anonymised user account:',
	'ACP_IP_ANONYM_OLDEST_LOG' 				=> 'Oldest not anonymised log entry:',

	'ACP_IP_ANONYM_OLDEST_MCHAT_MESSAGE' 	=> 'Oldest not anonymised post mChat message:',
	'ACP_IP_ANONYM_OLDEST_MCHAT_LOG' 		=> 'Oldest not anonymised post mChat log entry:',

	'ACP_IP_ANONYM_NO_CRONJOB_RUN'			=> 'Cronjob did not run yet',
	'ACP_IP_ANONYM_NO_DATE'					=> 'No entry available',
));
