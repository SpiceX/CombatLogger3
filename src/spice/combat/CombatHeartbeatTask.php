<?php
declare(strict_types=1);

namespace spice\combat;

use pocketmine\scheduler\Task;
use spice\combat\session\CombatManager;

/**
 * Class CombatHeartbeatTask
 * @package spice\combat
 */
class CombatHeartbeatTask extends Task
{
	/** @var CombatManager */
	private CombatManager $manager;

	/**
	 * CombatHeartbeatTask constructor.
	 */
	public function __construct(CombatManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * @param int $currentTick
	 */
	public function onRun(int $currentTick)
	{
		foreach ($this->manager->getSessions() as $session){
			$session->tick();
		}
	}
}