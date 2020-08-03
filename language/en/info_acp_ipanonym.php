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
	'ACP_IP_ANONYM_TITLE'		=> 'IP-anonymise',
	'ACP_IP_ANONYM_SETTINGS'	=> 'Settings',
	'ACP_IP_ANONYM_STATS'	=> 'Statistics',

	'IP_ANONYM_LOG_ANONYMIZE_IP_CRON'		=> 'IPs automatically anonymised',
));
