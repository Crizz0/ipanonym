<?php
/**
 *
 * IP anonymised extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Crizzo <https://www.crizzo.de>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace crizzo\ipanonym\event;
/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
* Event listener
*/
class permission_listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template $template Template object
	 */
	public function __construct(\phpbb\auth\auth $auth)
	{
		$this->auth = $auth;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions' => 'permissions',
		);
	}

	/**
	 * Add permissions
	 *
	 * @param	object	$event	The event object
	 * @return	null
	 * @access	public
	 */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_ipanonym'] = array('lang' => 'ACL_A_IPANONYM', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
