<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\plugin\PluginBase;

class SkinChanger extends PluginBase implements Listener {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onInteract(PlayerInteractEvent $event): void {
		$this->getServer()->getScheduler()->scheduleAsyncTask(new SkinChangeTask($event->getPlayer()->getSkin(), $event->getPlayer()->getName()));
	}
}