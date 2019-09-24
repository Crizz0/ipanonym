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
	'ACP_IP_ANONYM_DAYS'	=> 'Tage',

	'ACP_IP_ANONYM_ENABLE' 			=> 'IP-anonymisieren aktivieren',
	'ACP_IP_ANONYM_ENABLE_EXPLAIN' 	=> 'Sofern aktiviert, werden die hier eingetragenen Einstellungen angewendet und die IPs anonymisiert.',

	'ACP_IP_ANONYM_LOG_ENTRY'		=> 'IP-Adressen anonymisiert',

	'ACP_IP_ANONYM_MAIN'		 	=> 'IP-anonymisieren - Einstellungen',
	'ACP_IP_ANONYM_MAIN_EXPLAIN' 	=> 'Auf dieser Einstellungsseite kann die Funktion der Erweiterung aktiviert und konfiguriert werden.',

	'ACP_IP_ANONYM_MAIN_SETTINGS'			=> 'IP-anonymisieren - Einstellungen',
	'ACP_IP_ANONYM_MAIN_SETTINGS_EXPLAIN'	=> 'Aktiviere die Erweiterung und stelle das maximale Alter der IP-Adressen ein.',

	'ACP_IP_ANONYM_MAX_AGE'				=> 'Maximales Alter der IP-Adressen',
	'ACP_IP_ANONYM_MAX_AGE_EXPLAIN'		=> 'Alle IP-Adressen, die zu Einträgen (z. B. Beiträgen, Privaten Nachrichten, Log-Einträgen) gehören, die älter sind als die hier angebene Anzahl von Tagen, wird mittels CronJob mit „127.0.0.1“ überschrieben.',

	'ACP_IP_ANONYM_UPDATED'		=> 'Die Einstellungen von IP-anonymisieren wurden aktualisiert.',
));
