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
	'ACP_IP_ANONYM_STATS' 			=> 'Statistiken',
	'ACP_IP_ANONYM_STATS_EXPLAIN' 	=> 'Auf dieser Seite wird angezeigt, wann der Cronjob zuletzt lief und wie alt die ältesten noch nicht anonymisierten Einträge sind.',

	'ACP_IP_ANONYM_DATE'	=> 'Datum',

	'ACP_IP_ANONYM_CRON_LAST_RUN' 			=> 'Cronjob lief zuletzt am:',
	'ACP_IP_ANONYM_OLDEST_POST' 			=> 'Ältester nicht anonymisierter Beitrag:',
	'ACP_IP_ANONYM_OLDEST_PM' 				=> 'Älteste nicht anonymisierte Private Nachricht:',
	'ACP_IP_ANONYM_OLDEST_USER' 			=> 'Ältester nicht anonymisierter Benutzer:',
	'ACP_IP_ANONYM_OLDEST_LOG' 				=> 'Ältester nicht anonymisierter Log-Eintrag:',
	
	'ACP_IP_ANONYM_OLDEST_MCHAT_MESSAGE' 	=> 'Älteste nicht anonymisierte mChat Nachricht:',
	'ACP_IP_ANONYM_OLDEST_MCHAT_LOG' 		=> 'Älteste nicht anonymisierter mChat Log-Eintrag:',
));
