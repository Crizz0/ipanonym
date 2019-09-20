<?php
/**
 *
 * IP anonymised extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Crizzo <https://www.crizzo.de>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace crizzo\ipanonym\cron;


/**
 * IP-anonymise  cron task.
 */

class anonymise_ip extends \phpbb\cron\task\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\log\log_interface */
	protected $log;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\log\log_interface 				$log
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\log\log_interface $log)
	{
		$this->config 					= $config;
		$this->db						= $db;
		$this->phpbb_log 				= $log;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		// Check if cronjob should run
		if ($this->config['crizzo_ipanonym_enable'] == 0)
		{
			return;
		}

		$time_now = time();
		$time_run = $time_now - (int)$this->config['crizzo_ipanonym_max_age'] * 60 * 60 * 24;
		$task_anonymise = new \crizzo\ipanonym\cron\task\task_anonymise;
		$task_anonymise = anonymise_ip($time_now, $this->db) ;
		$this->phpbb_log->add('user', ANONYMOUS, '127.0.0.1', 'LOG_ANONYMIZE_IP_CRON');
		$this->config->set('crizzo_ipanonym_lastpurge', $time_now, false);
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run (2 days).
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['crizzo_ipanonym_lastpurge'] < strtotime('2 days ago');
	}
}
