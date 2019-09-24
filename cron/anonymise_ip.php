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

	/** @var \crizzo\ipanonym\cron\task\task_anonymise */
	protected $task_anonymise;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface				$db
	 * @param \phpbb\config\config							$config
	 * @param \phpbb\log\log_interface 						$log
	 * @param \crizzo\ipanonym\cron\task\task_anonymise 	$task_anonymise
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\log\log_interface $log, \crizzo\ipanonym\cron\task\task_anonymise $task_anonymise)
	{
		$this->config 					= $config;
		$this->db						= $db;
		$this->phpbb_log 				= $log;
		$this->task_anonymise			= $task_anonymise;
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

		if ($this->config['crizzo_ipanonym_overwrite'])
		{
			$last_purge = $this->config['crizzo_ipanonym_overwrite_time'];
		}
		else {
			$last_purge = $this->config['crizzo_ipanonym_lastpurge'];
		}

		$this->task_anonymise->anonymise_ips($time_run, $last_purge, $this->db) ;
		$this->phpbb_log->add('admin', ANONYMOUS, '127.0.0.1', 'LOG_ANONYMIZE_IP_CRON');
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
		return $this->config['crizzo_ipanonym_lastpurge'] < strtotime('2 minutes ago');
	}
}
