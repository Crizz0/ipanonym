<?php
/**
*
* IP anonymised extension for the phpBB Forum Software package.
*
* @copyright (c) 2019 Crizzo <https://www.crizzo.de>
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
	'ACP_IP_ANONYM_DAYS'			=> 'Days',

	'ACP_IP_ANONYM_ENABLE' 			=> 'Activate IP-anonymise',
	'ACP_IP_ANONYM_ENABLE_EXPLAIN' 	=> 'If activated, the settings on this page apply and the IPs will be anonymised.',

	'ACP_IP_ANONYM_HOURS'			=> 'Hours',

	'ACP_IP_ANONYM_LOG_ENTRY'		=> 'IP-addresses anonymised',

	'ACP_IP_ANONYM_MAIN'		 	=> 'IP-anonymise - Settings',
	'ACP_IP_ANONYM_MAIN_EXPLAIN' 	=> 'On this settings page you are able to activate and configure the extension.',

	'ACP_IP_ANONYM_MAIN_SETTINGS'			=> 'IP-anonymise - Settings',
	'ACP_IP_ANONYM_MAIN_SETTINGS_EXPLAIN'	=> 'Activate the extension and setup the maximum age of IP addresses',

	'ACP_IP_ANONYM_MAX_AGE'					=> 'Maximum age of IP-addresses',
	'ACP_IP_ANONYM_MAX_AGE_EXPLAIN'			=> 'Every IP-address, which belongs to any database entry (e. g. postings, private messages, log-entries) and which are older than this count of days, will be overwritten by “127.0.0.1“. Excluded are poll votings, they will be always overwritten  regardless of their age.',

	'ACP_IP_ANONYM_QUERY_RUNS'				=> 'SQL-query-limit runs',
	'ACP_IP_ANONYM_QUERY_RUNS_EXPLAIN'		=> 'This value controls the sql queries per database table the IP anonymised function performs in each run. Every run consists of seven sql queries to seven different tables. Decrease this value, if you experience performance issues or increase it to perform more runs per task.',

	'ACP_IP_ANONYM_SHOULD_RUN_TIME'				=> 'Time passed between each run',
	'ACP_IP_ANONYM_SHOULD_RUN_TIME_EXPLAIN'		=> 'The cronjob will only run once within this time period.',

	'ACP_IP_ANONYM_UPDATED'		=> 'The settings of IP-anonymise were updated.',
));
