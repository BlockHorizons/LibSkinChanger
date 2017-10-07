<?php

declare(strict_types = 1);

namespace BlockHorizons\Tests;

use BlockHorizons\LibSkinChanger\PlayerSkin;
use BlockHorizons\LibSkinChanger\SkinComponents\Cube;
use pocketmine\entity\Skin;
use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Random;

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
		$skin->explodeAllGeometry();

		foreach($skin->getComponent(PlayerSkin::BODY)->getGeometry()->getCubes() as $cube) {
			$cube->setVelocity([$this->randomFloat(8), $this->randomFloat(2, true), $this->randomFloat(8)]);
		}

		$this->setResult($skin);
	}

	public function onCompletion(Server $server): void {
		/** @var PlayerSkin $newSkin */
		$newSkin = $this->getResult();
		$player = $server->getPlayerExact($this->playerName);
		if($player === null) {
			return;
		}
		/** @var $plugin SkinChanger */
		if(($plugin = $server->getPluginManager()->getPlugin("SkinChangerTests")) === null) {
			return;
		}
		$player->setSkin(new Skin($this->skin->getSkinId(), $this->skin->getSkinData(), $this->skin->getCapeData(), "geometry.test", $newSkin->getGeometryData("geometry.test")));
		$player->sendSkin($server->getOnlinePlayers());
		$server->getScheduler()->scheduleRepeatingTask(new HumanExplodeTask($plugin, $player), 1);
	}

	public function randomFloat(float $multiplication = 1.0, bool $absolute = false): float {
		if(!$absolute) {
			return (random_int(0, 1) === 0 ? -1 : 1) * lcg_value() * $multiplication;
		}
		return lcg_value() * $multiplication;
	}
}