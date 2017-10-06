<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger\SkinComponents;

use BlockHorizons\LibSkinChanger\PlayerSkin;
use BlockHorizons\LibSkinChanger\SkinPixel;

abstract class SkinComponent {

	/** @var SkinPixel[] */
	private $pixels = [];
	/** @var Geometry */
	private $geometry = null;
	/** @var int */
	protected $skinWidth = 0;
	/** @var int */
	protected $skinHeight = 0;
	/** @var int */
	protected $xOffset = 0;
	/** @var int */
	protected $yOffset = 0;
	/** @var string */
	protected $geometryComponentName = "";
	/** @var bool */
	protected $hasSkin = true;

	public function __construct(PlayerSkin $skin, array $geometry = []) {
		if($this->hasSkin()){
			$minX = $this->xOffset;
			$maxX = $minX;
			$minY = $this->yOffset;
			$maxY = $minY + $this->skinHeight;
			for($x = $minX; $x < $maxX; $x++) {
				for($y = $minY; $y < $maxY; $y++) {
					$this->pixels[($y << 4) | $x] = $skin->getPixelAt($x, $y);
				}
			}
		}
		foreach($geometry["bones"] as $key => $component) {
			if($component["name"] === $this->geometryComponentName) {
				$this->geometry = new Geometry($geometry["bones"][$key]);
				return;
			}
		}
		$this->geometry = new Geometry(["name" => $this->geometryComponentName, "cubes" => []]);
	}

	/**
	 * @return Geometry
	 */
	public function getGeometry(): Geometry {
		return $this->geometry;
	}

	/**
	 * @param int $x
	 * @param int $y
	 *
	 * @return SkinPixel|null
	 */
	public function getPixelAt(int $x, int $y): ?SkinPixel {
		if($x > $this->skinWidth || $y > $this->skinHeight) {
			throw new \InvalidArgumentException("Pixel coordinates should be ranged 0 - 64");
		}
		if($x < 0 || $y < 0) {
			throw new \InvalidArgumentException("Pixel coordinates should be ranged 0 - 64");
		}
		return $this->pixels[($y << 6) | $x] ?? null;
	}

	/**
	 * @return bool
	 */
	public function hasSkin(): bool {
		return $this->hasSkin;
	}

	/**
	 * @return int
	 */
	public function getSkinWidth(): int {
		return $this->skinWidth;
	}

	/**
	 * @return int
	 */
	public function getSkinHeight(): int {
		return $this->skinHeight;
	}

	/**
	 * @return int
	 */
	public function getXOffset(): int {
		return $this->xOffset;
	}

	/**
	 * @return int
	 */
	public function getYOffset(): int {
		return $this->yOffset;
	}
}