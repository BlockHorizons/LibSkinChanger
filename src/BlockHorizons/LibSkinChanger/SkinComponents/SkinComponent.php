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

	public function __construct(PlayerSkin $skin, array $geometry = [], bool $ignoreSkin = false) {
		if($this->hasSkin() && !$ignoreSkin){
			$minX = $this->xOffset;
			$maxX = $minX + $this->skinWidth;
			$minY = $this->yOffset;
			$maxY = $minY + $this->skinHeight;
			for($x = $minX; $x < $maxX; $x++) {
				for($y = $minY; $y < $maxY; $y++) {
					$this->pixels[($y << 6) | $x] = $skin->getPixelAt($x, $y);
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
	 * Returns the geometry (Geometry.php) of this skin component.
	 * @return Geometry
	 */
	public function getGeometry(): Geometry {
		return $this->geometry;
	}

	/**
	 * @return SkinPixel[]
	 */
	public function getPixels(): array {
		return $this->pixels;
	}

	/**
	 * Returns a pixel (SkinPixel.php) on a relative position in this skin component.
	 *
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
		return $this->pixels[($x << 6) | $y] ?? null;
	}

	/**
	 * Returns whether this skin has a skin field associated with it or not.
	 *
	 * @return bool
	 */
	public function hasSkin(): bool {
		return $this->hasSkin;
	}

	/**
	 * Returns the width of the skin of this skin component.
	 *
	 * @return int
	 */
	public function getSkinWidth(): int {
		return $this->skinWidth;
	}

	/**
	 * Returns the height of the skin of this skin component.
	 * @return int
	 */
	public function getSkinHeight(): int {
		return $this->skinHeight;
	}

	/**
	 * Returns the X offset for the location of this component in the complete skin.
	 *
	 * @return int
	 */
	public function getXOffset(): int {
		return $this->xOffset;
	}

	/**
	 * Returns the Y offset for the location of this component in the complete skin.
	 *
	 * @return int
	 */
	public function getYOffset(): int {
		return $this->yOffset;
	}
}