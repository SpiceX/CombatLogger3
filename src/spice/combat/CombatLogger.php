<?php
declare(strict_types=1);

namespace spice\combat;

use pocketmine\plugin\PluginBase;
use spice\combat\kit\KitManager;
use spice\combat\session\CombatManager;

/**
 * Class CombatLogger
 * @package spice\combat
 */
class CombatLogger extends PluginBase
{
	/** @var CombatLogger */
	private static CombatLogger $instance;
	/** @var CombatManager */
	private CombatManager $combatManager;
	/** @var KitManager */
	private KitManager $kitManager;

	public function onEnable()
	{
		self::$instance = $this;
		$this->kitManager = new KitManager($this);
		$this->getServer()->getPluginManager()->registerEvents(new CombatListener($this), $this);
		$this->getScheduler()->scheduleRepeatingTask(
			new CombatHeartbeatTask($this->combatManager = new CombatManager($this)), 20
		);
		$this->getServer()->getCommandMap()->register("CombatLogger3", new CombatCommand($this));
	}

	public function onDisable()
	{
		$this->kitManager->saveKits();
	}

	/**
	 * @return CombatManager
	 */
	public function getCombatManager(): CombatManager
	{
		return $this->combatManager;
	}

	/**
	 * @return KitManager
	 */
	public function getKitManager(): KitManager
	{
		return $this->kitManager;
	}

	/**
	 * @return CombatLogger
	 */
	public static function getInstance(): CombatLogger
	{
		return self::$instance;
	}
}