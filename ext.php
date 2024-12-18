<?php
/**
 *
 * IP anonymised extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024 Crizzo <https://www.crizzo.de>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace crizzo\ipanonym;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$valid_phpbb 	= phpbb_version_compare(PHPBB_VERSION, '3.3.1', '>=') && phpbb_version_compare(PHPBB_VERSION, '4.0.0-dev', '<');
		$valid_php 		= phpbb_version_compare(PHP_VERSION, '7.1.3', '>=');

		return ($valid_phpbb && $valid_php);
	}
}
