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

	public function __construct(Skin $skin) {
		$this->skin = $skin;
	}

	public function onRun(): void {
		$skin = new PlayerSkin($this->skin);
		$skin->explodeAllGeometry();

		foreach($skin->getComponent(PlayerSkin::BODY)->getGeometry()->getCubes() as $cube) {
			$cube->setVelocity([$this->randomFloat(), $this->randomFloat(1, true), $this->randomFloat()]);
		}

		$frames = [];
		$geometryName = "geometry.test";
		$this->publishProgress([[$geometryName, $skin->getGeometryData($geometryName)]]);

		for($i = 1; $i <= 200; $i++) {
			$skin->getComponent(PlayerSkin::BODY)->getGeometry()->tryChangeMovement();
			$name = $geometryName . $i;
			$frames[$i] = [$name, $skin->getGeometryData($name)];
			$this->publishProgress($frames);
			$frames = [];
		}
	}

	public function onProgressUpdate(Server $server, $progress): void {
		/** @var SkinChanger $plugin */
		$plugin = $server->getPluginManager()->getPlugin("SkinChangerTests");
		if($plugin === null) {
			return;
		}
		$plugin->storeGeometryData($progress);
	}

	public function randomFloat(float $multiplication = 1.0, bool $absolute = false): float {
		if(!$absolute) {
			return (random_int(0, 1) === 0 ? -1 : 1) * lcg_value() * $multiplication;
		}
		return lcg_value() * $multiplication;
	}
}