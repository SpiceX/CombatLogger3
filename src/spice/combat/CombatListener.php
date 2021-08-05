<?php
declare(strict_types=1);

namespace spice\combat;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;

/**
 * Class CombatListener
 * @package spice\combat
 */
class CombatListener implements Listener
{

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
	 * @param PlayerJoinEvent $event
	 * @priority NORMAL
	 */
	public function onPlayerJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$this->plugin->getCombatManager()->registerSession($player);
	}

	/**
	 * @param EntityDamageByEntityEvent $event
	 * @priority NORMAL
	 */
	public function onEntityDamageByEntity(EntityDamageByEntityEvent $event)
	{
		$damager = $event->getDamager();
		$victim = $event->getEntity();
		if (!$damager instanceof Player || !$victim instanceof Player) {
			return;
		}
		$damagerSession = $this->plugin->getCombatManager()->getSession($damager);
		$victimSession = $this->plugin->getCombatManager()->getSession($victim);

		if ($damagerSession->isTagged() && $damagerSession->getOponent() !== $victim->getName()){
			$event->setCancelled();
		}

		$damagerSession->setTagged($victim);
		$victimSession->setTagged($damager);

		if ($event->getFinalDamage() > $victim->getHealth()){
			$damagerSession->reward();
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 * @priority NORMAL
	 */
	public function onPlayerQuit(PlayerQuitEvent $event)
	{
		$player = $event->getPlayer();
		$this->plugin->getCombatManager()->unregisterSession($player);
	}
}