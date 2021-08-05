<?php
declare(strict_types=1);

namespace spice\combat\kit;

use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Class Kit
 * @package spice\combat\kit
 */
class Kit
{
	/** @var string */
	private string $name;
	/** @var Item[] */
	private array $items;

	/**
	 * Kit constructor.
	 * @param string $name
	 * @param Item[] $items
	 */
	public function __construct(string $name, array $items)
	{

		$this->name = $name;
		$this->items = $items;
	}

	/**
	 * @param Player $player
	 */
	public function applyTo(Player $player)
	{
		foreach ($this->items as $item) {
			if ($player->getInventory()->canAddItem($item)) {
				$player->getInventory()->addItem($item);
			} else {
				$player->getLevel()->dropItem($player, $item);
			}
		}
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getItems(): array
	{
		return $this->items;
	}
}