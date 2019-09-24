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
	'ACP_IP_ANONYM_DAYS'	=> 'Days',

	'ACP_IP_ANONYM_ENABLE' 			=> 'Activate IP-anonymise',
	'ACP_IP_ANONYM_ENABLE_EXPLAIN' 	=> 'If activated, the settings on this page apply and the IPs will be anonymised.',

	'ACP_IP_ANONYM_LOG_ENTRY'		=> 'IP-Adressen anonymisiert',

	'ACP_IP_ANONYM_MAIN'		 	=> 'IP-anonymise - Settings',
	'ACP_IP_ANONYM_MAIN_EXPLAIN' 	=> 'On this settings page you are able to activate and configure the extension.',

	'ACP_IP_ANONYM_MAIN_SETTINGS'			=> 'IP-anonymise - Settings',
	'ACP_IP_ANONYM_MAIN_SETTINGS_EXPLAIN'	=> 'Activate the extension and setup the maximum age of IP addresses',

	'ACP_IP_ANONYM_MAX_AGE'				=> 'Maximum age of IP addresses',
	'ACP_IP_ANONYM_MAX_AGE_EXPLAIN'		=> 'Every IP-address, which belongs to any database entry (e. g. postings, private messages, log-entries) and which are older than this count of days, will be overwritten by “127.0.0.1“.',

	'ACP_IP_ANONYM_UPDATED'		=> 'The settings of IP-anonymise were updated.',
));
