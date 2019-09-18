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
	'IP_ANONYM' => 'IP anonymisiert',

	'ACP_IP_ANONYM_MAIN'		 	=> 'IP-anonymisieren',
	'ACP_IP_ANONYM_MAIN_EXPLAIN' 	=> 'Auf dieser Einstellungsseite kann die Funktion der Erweiterung aktiviert und konfiguriert werden',

	'ACP_IP_ANONYM_MAIN_SETTINGS'			=> 'IP-anonymisieren Einstellungen',
	'ACP_IP_ANONYM_MAIN_SETTINGS_EXPLAIN'	=> 'Aktiviere die Erweiterung, stelle das maximale Alter der IP-Adressen ein oder überschreibe die letzte Zeitmarke für den Start des CronJobs',

	'ACP_IP_ANONYM_MAX_AGE'				=> 'Maximales Alter der IP-Adressen',
	'ACP_IP_ANONYM_MAX_AGE_EXPLAIN'		=> 'Alle IP-Adressen, die zu Einträgen (z. B. Beiträgen) gehören, die älter sind als die hier angebene Anzahl von  Tagen, wird mittels CronJob mit „127.0.0.1“ überschrieben.',

	'ACP_IP_ANONYM_OVERWRITE_TIMESTAMP'			=> 'Internen Zeitstempel überschreiben',
	'ACP_IP_ANONYM_OVERWRITE_TIMESTAMP_EXPLAIN'	=> 'Aktiviert wird der letzte Zeitstempel in der Datenbank ignoriert und stattdessen der hier angegebene Zeitpunkt als Startpunkt für den CronJob genommen, um die IP-Adressen zu überschreiben.',

	'ACP_IP_ANONYM_OVERWRITE_TIMESTAMP_NEW_TIME'			=> 'Neuer Zeitstempel',
	'ACP_IP_ANONYM_OVERWRITE_TIMESTAMP_NEW_TIME_EXPLAIN'	=> 'Der hier eingetragene Zeitstempel überschrebit den internen Zeitstempel und lässt den CronJob nur IP-Adresse überschreiben, die neue sind als dieser Zeitstempel.',
	'ACP_IP_ANONYM_OVERWRITE_TIME_EXAMPLE'					=> 'DD:MM:YYYY HH:MM z. B. „01.01.1970 12:00“',
));
