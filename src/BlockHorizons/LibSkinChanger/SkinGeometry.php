<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger;

class SkinGeometry implements \JsonSerializable {

	/** @var int */
	private $texturewidth = 64;
	/** @var int */
	private $textureheight = 64;
	/** @var string */
	private $META_ModelVersion = "1.0.6";
	/** @var string */
	private $rigtype = "normal";

	/** @var bool */
	private $animationArmsDown = false;
	/** @var bool */
	private $animationArmsOutFront = false;
	/** @var bool */
	private $animationStatueOfLibertyArms = false;
	/** @var bool */
	private $animationSingleArmAnimation = false;
	/** @var bool */
	private $animationStationaryLegs = false;
	/** @var bool */
	private $animationSingleLegAnimation = false;
	/** @var bool */
	private $animationNoHeadBob = false;
	/** @var bool */
	private $animationDontShowArmor = false;
	/** @var bool */
	private $animationUpsideDown = false;
	/** @var bool */
	private $animationInvertedCrouch = false;

	public function __construct(array $geometry = []) {
		foreach($geometry as $key => $geom) {
			if(is_array($geom)) {
				continue;
			}
			$this->{$key} = $geom;
		}
	}

	/**
	 * @return int
	 */
	public function getTexturewidth(): int {
		return $this->texturewidth;
	}

	/**
	 * @param int $texturewidth
	 */
	public function setTexturewidth(int $texturewidth): void {
		$this->texturewidth = $texturewidth;
	}

	/**
	 * @return int
	 */
	public function getTextureheight(): int {
		return $this->textureheight;
	}

	/**
	 * @param int $textureheight
	 */
	public function setTextureheight(int $textureheight): void {
		$this->textureheight = $textureheight;
	}

	/**
	 * @return string
	 */
	public function getMETAModelVersion(): string {
		return $this->META_ModelVersion;
	}

	/**
	 * @param string $META_ModelVersion
	 */
	public function setMETAModelVersion(string $META_ModelVersion): void {
		$this->META_ModelVersion = $META_ModelVersion;
	}

	/**
	 * @return string
	 */
	public function getRigtype(): string {
		return $this->rigtype;
	}

	/**
	 * @param string $rigtype
	 */
	public function setRigtype(string $rigtype): void {
		$this->rigtype = $rigtype;
	}

	/**
	 * @return bool
	 */
	public function isAnimationArmsDown(): bool {
		return $this->animationArmsDown;
	}

	/**
	 * @param bool $animationArmsDown
	 */
	public function setAnimationArmsDown(bool $animationArmsDown = true): void {
		$this->animationArmsDown = $animationArmsDown;
	}

	/**
	 * @return bool
	 */
	public function isAnimationArmsOutFront(): bool {
		return $this->animationArmsOutFront;
	}

	/**
	 * @param bool $animationArmsOutFront
	 */
	public function setAnimationArmsOutFront(bool $animationArmsOutFront = true): void {
		$this->animationArmsOutFront = $animationArmsOutFront;
	}

	/**
	 * @return bool
	 */
	public function isAnimationStatueOfLibertyArms(): bool {
		return $this->animationStatueOfLibertyArms;
	}

	/**
	 * @param bool $animationStatueOfLibertyArms
	 */
	public function setAnimationStatueOfLibertyArms(bool $animationStatueOfLibertyArms = true): void {
		$this->animationStatueOfLibertyArms = $animationStatueOfLibertyArms;
	}

	/**
	 * @return bool
	 */
	public function isSingleArmAnimation(): bool {
		return $this->animationSingleArmAnimation;
	}

	/**
	 * @param bool $animationSingleArmAnimation
	 */
	public function setSingleArmAnimation(bool $animationSingleArmAnimation = true): void {
		$this->animationSingleArmAnimation = $animationSingleArmAnimation;
	}

	/**
	 * @return bool
	 */
	public function isAnimationStationaryLegs(): bool {
		return $this->animationStationaryLegs;
	}

	/**
	 * @param bool $animationStationaryLegs
	 */
	public function setAnimationStationaryLegs(bool $animationStationaryLegs = true): void {
		$this->animationStationaryLegs = $animationStationaryLegs;
	}

	/**
	 * @return bool
	 */
	public function isSingleLegAnimation(): bool {
		return $this->animationSingleLegAnimation;
	}

	/**
	 * @param bool $animationSingleLegAnimation
	 */
	public function setSingleLegAnimation(bool $animationSingleLegAnimation = true): void {
		$this->animationSingleLegAnimation = $animationSingleLegAnimation;
	}

	/**
	 * @return bool
	 */
	public function isAnimationNoHeadBob(): bool {
		return $this->animationNoHeadBob;
	}

	/**
	 * @param bool $animationNoHeadBob
	 */
	public function setAnimationNoHeadBob(bool $animationNoHeadBob = true): void {
		$this->animationNoHeadBob = $animationNoHeadBob;
	}

	/**
	 * @return bool
	 */
	public function isAnimationDontShowArmor(): bool {
		return $this->animationDontShowArmor;
	}

	/**
	 * @param bool $animationDontShowArmor
	 */
	public function setAnimationDontShowArmor(bool $animationDontShowArmor = true): void {
		$this->animationDontShowArmor = $animationDontShowArmor;
	}

	/**
	 * @return bool
	 */
	public function isAnimationUpsideDown(): bool {
		return $this->animationUpsideDown;
	}

	/**
	 * @param bool $animationUpsideDown
	 */
	public function setAnimationUpsideDown(bool $animationUpsideDown = true): void {
		$this->animationUpsideDown = $animationUpsideDown;
	}

	/**
	 * @return bool
	 */
	public function isAnimationInvertedCrouch(): bool {
		return $this->animationInvertedCrouch;
	}

	/**
	 * @param bool $animationInvertedCrouch
	 */
	public function setAnimationInvertedCrouch(bool $animationInvertedCrouch = true): void {
		$this->animationInvertedCrouch = $animationInvertedCrouch;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		$data = [];
		foreach($this as $key => $value) {
			$data[$key] = $value;
		}
		return $data;
	}
}