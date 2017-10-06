<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class SkinChanger extends PluginBase implements Listener {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $event): void {
		$this->getServer()->getScheduler()->scheduleAsyncTask(new SkinChangeTask($event->getPlayer()->getSkin(), $event->getPlayer()->getName()));
	}
}