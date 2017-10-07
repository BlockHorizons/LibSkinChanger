<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use BlockHorizons\LibSkinChanger\PlayerSkin;
use pocketmine\entity\Skin;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Random;

class HumanExplodeTask extends PluginTask {

	/** @var Player */
	private $player = null;
	/** @var int */
	private $tick = 0;
	/** @var PlayerSkin */
	private $skin = null;
	/** @var float */
	private $drag = 0.02;
	/** @var float */
	private $gravity = 0.08;

	public function __construct(SkinChanger $plugin, Player $player) {
		parent::__construct($plugin);
		$this->player = $player;
		$this->skin = new PlayerSkin($player->getSkin(), true);
	}

	public function onRun(int $currentTick): void {
		if(!$this->player->isOnline()) {
			return;
		}
		foreach($this->skin->getComponent(PlayerSkin::BODY)->getGeometry()->getCubes() as $cube) {
			if((float) $cube->getOrigin()[1] <= 0.0 && $cube->getVelocity() !== [0, 0, 0]) {
				$cube->setVelocity([0, 0, 0]);
			} else {
				$velocity = $cube->getVelocity();
				$origin = $cube->getOrigin();
				$cube->setOrigin([$origin[0] + $velocity[0] * 0.1, $origin[1] + $velocity[1] * 0.1, $origin[2] + $velocity[2] * 0.1]);
				$cube->setVelocity([$velocity[0] * (1 - $this->drag), ($velocity[1] - $this->gravity) * (1 - $this->drag) , $velocity[2] * (1 - $this->drag)]);
			}
		}
		if($this->tick > 300) {
			$this->getOwner()->getServer()->getScheduler()->cancelTask($this->getTaskId());
		}
		$this->tick++;
		$oldSkin = $this->player->getSkin();
		$newSkin = new Skin($oldSkin->getSkinId(), $oldSkin->getSkinData(), $oldSkin->getCapeData(), $name = "geometry." . microtime(), $this->skin->getGeometryData($name));
		$this->player->setSkin($newSkin);
		$this->player->sendSkin($this->player->getServer()->getOnlinePlayers());
	}
}