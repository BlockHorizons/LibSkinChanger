<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger\SkinComponents;

class Cube implements \JsonSerializable {

	/** @var float[] */
	private $origin = [];
	/** @var float[] */
	private $size = [];
	/** @var float[] */
	private $uv = [];

	/** @var float */
	private $inflate = 0.0;
	/** @var bool */
	private $mirror = false;

	public function __construct(array $cubeData) {
		$this->origin = $cubeData["origin"] ?? [0.0, 0.0, 0.0];
		$this->size = $cubeData["size"] ?? [1.0, 1.0, 1.0];
		$this->uv = $cubeData["uv"] ?? [0.0, 0.0];

		$this->inflate = $cubeData["inflate"] ?? 0.0;
		$this->mirror = $cubeData["mirror"] ?? false;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"origin" => $this->origin,
			"size" => $this->size,
			"uv" => $this->uv,
			"inflate" => $this->inflate,
			"mirror" => $this->mirror
		];
	}

	/**
	 * Returns the origin of this cube.
	 * Returns an array containing 3 floats.
	 *
	 * @return float[]
	 */
	public function getOrigin(): array {
		return $this->origin;
	}

	/**
	 * Sets the origin of this cube.
	 * Should be an array containing 3 floats.
	 *
	 * @param float[] $origin
	 */
	public function setOrigin(array $origin): void {
		$this->origin = $origin;
	}

	/**
	 * Returns the size of this cube.
	 * Returns an array containing 3 floats.
	 *
	 * @return float[]
	 */
	public function getSize(): array {
		return $this->size;
	}

	/**
	 * Sets the size of this cube.
	 * Should be an array containing 3 floats.
	 *
	 * @param float[] $size
	 */
	public function setSize(array $size): void {
		$this->size = $size;
	}

	/**
	 * Returns the UV of this cube. This means the pixel location on the skin of the player.
	 * Returns an array containing 2 floats.
	 *
	 * @return float[]
	 */
	public function getUv(): array {
		return $this->uv;
	}

	/**
	 * Sets the UV of this cube. This means the pixel location on the skin of the player.
	 * Should be an array containing 2 floats.
	 *
	 * @param float[] $uv
	 */
	public function setUv(array $uv): void {
		$this->uv = $uv;
	}

	/**
	 * Returns how far from the original size this cube should be extended.
	 *
	 * @return float
	 */
	public function getInflate(): float {
		return $this->inflate;
	}

	/**
	 * Sets how far from the original size this cube should be extended.
	 *
	 * @param float $inflate
	 */
	public function setInflate(float $inflate): void {
		$this->inflate = $inflate;
	}

	/**
	 * Returns whether the rotation of this cube is mirrored.
	 *
	 * @return bool
	 */
	public function isMirrored(): bool {
		return $this->mirror;
	}

	/**
	 * Sets the rotation of this cube mirrored.
	 *
	 * @param bool $value
	 */
	public function setMirrored(bool $value = true): void {
		$this->mirror = $value;
	}
}