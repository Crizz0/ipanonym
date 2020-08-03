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
	'ACP_IP_ANONYM_TITLE'		=> 'IP-anonymisieren',
	'ACP_IP_ANONYM_SETTINGS'	=> 'Einstellungen',
	'ACP_IP_ANONYM_STATS'	=> 'Statistiken',

	'LOG_ANONYMIZE_IP_CRON'		=> 'IPs automatisch anonymisiert',
));
