<?php
declare(strict_types=1);

namespace spice\combat;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use spice\combat\kit\Kit;

/**
 * Class CombatCommand
 * @package spice\combat
 */
class CombatCommand extends Command implements PluginIdentifiableCommand
{
	/** @var CombatLogger */
	private CombatLogger $plugin;

	/**
	 * CombatCommand constructor.
	 */
	public function __construct(CombatLogger $plugin)
	{
		parent::__construct("combat", "combat logger command", "/combat help", ['cmb']);
		$this->setPermission("combat.cmd");
		$this->plugin = $plugin;
	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array $args
	 * @return mixed|void
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if (!$sender instanceof Player || !isset($args[0])){
			return;
		}
		switch ($args[0]){
			case 'kit':
				if (!isset($args[1], $args[2])){
					$sender->sendMessage("§cUsage: /cmb kit <create|remove> <name>");
					break;
				}
				switch ($args[1]){
					case 'create':
						$kit = $this->plugin->getKitManager()->getKit($args[2]);
						if ($kit instanceof Kit){
							$sender->sendMessage("§eKit already exists!");
							break;
						}
						$this->plugin->getKitManager()->createKit($args[2], $sender->getInventory()->getContents());
						$sender->sendMessage("§eKit $args[2] created!");
						break;
					case 'remove':
						$kit = $this->plugin->getKitManager()->getKit($args[2]);
						if (!$kit instanceof Kit){
							$sender->sendMessage("§eKit does not exists!");
							break;
						}
						$this->plugin->getKitManager()->removeKit($args[2]);
						$sender->sendMessage("§eKit $args[2] removed!");
						break;
				}
				break;
			case 'help':
			default:
				$sender->sendMessage("§eCombat Logger3 Help Menu §7(1/1)" . "\n" .
				"§e/cmb help §7- Shows this menu" . "\n" .
				"§e/cmb kit §7- <create|remove> <name>" . "\n"
				);
		}
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(): Plugin
	{
		return $this->plugin;
	}
}