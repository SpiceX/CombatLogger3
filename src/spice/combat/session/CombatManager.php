<?php
declare(strict_types=1);

namespace spice\combat\session;

use pocketmine\Player;
use spice\combat\CombatLogger;

/**
 * Class CombatManager
 * @package spice\combat\session
 */
class CombatManager
{
	/** @var CombatSession[] */
	private array $sessions = [];

	/** @var CombatLogger */
	private CombatLogger $plugin;

	/**
	 * CombatManager constructor.
	 * @param CombatLogger $plugin
	 */
	public function __construct(CombatLogger $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * @param Player $player
	 */
	public function registerSession(Player $player)
	{
		$this->sessions[$player->getName()] = new CombatSession($player);
	}

	/**
	 * @param Player $player
	 */
	public function unregisterSession(Player $player){
		unset($this->sessions[$player->getName()]);
	}

	/**
	 * @param Player $player
	 * @return CombatSession|null
	 */
	public function getSession(Player $player): ?CombatSession
	{
		return $this->sessions[$player->getName()] ?? null;
	}

	/**
	 * @return CombatSession[]
	 */
	public function getSessions(): array
	{
		return $this->sessions;
	}


}