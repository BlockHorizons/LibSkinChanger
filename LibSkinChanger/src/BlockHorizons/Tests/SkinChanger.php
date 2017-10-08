<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class SkinChanger extends PluginBase implements Listener {

	/** @var array */
	private $geometryData = [];

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
		if($command->getName() === "spawntest") {
			$player = $sender;
			if(!($player instanceof Player)) {
				return false;
			}
			$nbt = new CompoundTag();
			$nbt->Pos = new ListTag("Pos", [
				new DoubleTag("", $player->getX()),
				new DoubleTag("", $player->getY()),
				new DoubleTag("", $player->getZ())
			]);
			$nbt->Motion = new ListTag("Motion", [
				new DoubleTag("", 0),
				new DoubleTag("", 0),
				new DoubleTag("", 0)
			]);
			$nbt->Rotation = new ListTag("Rotation", [
				new FloatTag("", $player->getYaw()),
				new FloatTag("", $player->getPitch())
			]);
			$player->saveNBT();
			$nbt->Inventory = clone $player->namedtag->Inventory;
			$nbt->Skin = new CompoundTag("Skin", ["Data" => new StringTag("Data", $player->getSkin()->getSkinData()), "Name" => new StringTag("Name", $player->getSkin()->getSkinId())]);

			/** @var Human $human */
			$human = Entity::createEntity("Human", $player->getLevel(), $nbt);
			$human->spawnToAll();
			$human->setMaxHealth(20);
			$human->setHealth(20);
			return true;
		}
		return false;
	}

	public function onInteract(EntityDamageEvent $event): void {
		if(!($event instanceof EntityDamageByEntityEvent)) {
			return;
		}
		$player = $event->getDamager();
		$human = $event->getEntity();
		if(!($player instanceof Player) || !($human instanceof Human)) {
			return;
		}
		$human->setSkin($player->getSkin());
		$human->sendSkin([$player]);

		$this->getServer()->getScheduler()->scheduleAsyncTask(new SkinChangeTask($human->getSkin()));
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new HumanExplodeTask($this, $human), 3);
		$event->setCancelled();
	}

	/**
	 * @param array $geometryData
	 */
	public function storeGeometryData(array $geometryData): void {
		foreach($geometryData as $key => $data) {
			$this->geometryData[$key] = $data;
		}
	}

	/**
	 * @param int  $id
	 * @param bool $delete
	 *
	 * @return array
	 */
	public function getNextFrame(int $id, bool $delete = false): array {
		if($delete) {
			$return = $this->geometryData[$id];
			unset($this->geometryData[$id]);
			return $return;
		}
		return $this->geometryData[$id];
	}

	/**
	 * @param int $id
	 *
	 * @return bool
	 */
	public function frameExists(int $id): bool {
		return isset($this->geometryData[$id]);
	}

	/**
	 * @return bool
	 */
	public function isFrameAvailable(): bool {
		return !empty($this->geometryData);
	}

	public function emptyFrameCache(): void {
		$this->geometryData = [];
	}
}