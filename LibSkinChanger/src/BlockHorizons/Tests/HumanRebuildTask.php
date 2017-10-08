<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use BlockHorizons\LibSkinChanger\PlayerSkin;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class HumanRebuildTask extends PluginTask {

	/** @var Human */
	private $player = null;
	/** @var int */
	private $tick = 0;
	/** @var int */
	private $frame = 200;
	/** @var Skin */
	private $oldSkin = null;

	public function __construct(SkinChanger $plugin, Human $player) {
		parent::__construct($plugin);
		$this->player = $player;
		$this->oldSkin = $player->getSkin();
	}

	public function onRun(int $currentTick): void {
		/** @var SkinChanger $plugin */
		$plugin = $this->getOwner();

		++$this->tick;
		if(!$plugin->isFrameAvailable()){
			return;
		}
		--$this->frame;
		if(!$plugin->frameExists($this->frame)) {
			if($this->frame < 1) {
				$plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
				$plugin->emptyFrameCache();
			}
			return;
		}

		if($this->tick >= 300) {
			$plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
			$plugin->emptyFrameCache();
			return;
		}
		$data = $plugin->getNextFrame($this->frame, true);

		$newSkin = new Skin($this->oldSkin->getSkinId(), $this->oldSkin->getSkinData(), "", $data[0], $data[1]);
		$this->player->setSkin($newSkin);
		$this->player->sendSkin(Server::getInstance()->getOnlinePlayers());
	}
}