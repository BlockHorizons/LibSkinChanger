<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use BlockHorizons\LibSkinChanger\PlayerSkin;
use pocketmine\entity\Skin;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class SkinChangeTask extends AsyncTask {

	/** @var Skin */
	private $skin = null;
	/** @var string */
	private $playerName = "";

	public function __construct(Skin $skin, string $playerName) {
		$this->skin = $skin;
		$this->playerName = $playerName;
	}

	public function onRun(): void {
		$skin = new PlayerSkin($this->skin);
		$skin->getComponent(PlayerSkin::RIGHT_ARM)->getGeometry()->setRotation([50.0, 50.0, 50.0]);
		$skin->getComponent(PlayerSkin::HEAD)->getGeometry()->setPivot([0, 0, 0])->setRotation([180.0, 180.0, 180.0]);
		$this->setResult($skin);
	}

	public function onCompletion(Server $server): void {
		/** @var PlayerSkin $newSkin */
		$newSkin = $this->getResult();
		$player = $server->getPlayerExact($this->playerName);
		if($player === null) {
			return;
		}
		$player->setSkin(new Skin("testSkin", $newSkin->getSkinData(), $this->skin->getCapeData(), "geometry.test", $newSkin->getGeometryJson("geometry.test")));
		$player->sendSkin($server->getOnlinePlayers());
	}
}