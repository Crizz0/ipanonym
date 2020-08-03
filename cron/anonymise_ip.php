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
 * IP-anonymise cron task.
 */

class anonymise_ip extends \phpbb\cron\task\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\log\log_interface */
	protected $phpbb_log;

	/** @var \crizzo\ipanonym\cron\task\task_anonymise */
	protected $task_anonymise;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config							$config
	 * @param \phpbb\log\log_interface 						$phpbb_log
	 * @param \crizzo\ipanonym\cron\task\task_anonymise 	$task_anonymise
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\log\log_interface $phpbb_log, \crizzo\ipanonym\cron\task\task_anonymise $task_anonymise)
	{
		$this->config 					= $config;
		$this->phpbb_log 				= $phpbb_log;
		$this->task_anonymise			= $task_anonymise;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		$time_now = time();
		$time_run = $time_now - (int) $this->config['crizzo_ipanonym_max_age'] * 60 * 60 * 24;

		$this->config->set('crizzo_ipanonym_lastpurge', $time_now, false);
		$this->task_anonymise->anonymise_ips($time_run);
		$add_entry = $this->config['crizzo_ipanonym_log_add_entry'];
		$entry_counter = $this->config['crizzo_ipanonym_log_add_entry_counter'];

		if ($add_entry > 0)
		{
			if ($entry_counter >= $add_entry)
			{
				$this->phpbb_log->add('admin', ANONYMOUS, '127.0.0.1', 'IP_ANONYM_LOG_ANONYMIZE_IP_CRON');
				$entry_counter = 1;
				$this->config->set('crizzo_ipanonym_log_add_entry_counter', $entry_counter, false);
			}
			else
			{
				$entry_counter = $entry_counter + 1;
				$this->config->set('crizzo_ipanonym_log_add_entry_counter', $entry_counter, false);
			}
		}
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return $this->config['crizzo_ipanonym_enable'];
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run (24 hours).
	 *
	 * @return bool
	 */
	public function should_run()
	{
		$should_run_minutes = (int) $this->config['crizzo_ipanonym_should_run_time'];

		$should_run_time = time() - ($should_run_minutes * 60);

		return (int) $this->config['crizzo_ipanonym_lastpurge'] < $should_run_time;
	}
}
