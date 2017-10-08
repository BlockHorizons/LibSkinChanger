<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger\SkinComponents;

class Cube implements \JsonSerializable {

	/** @var float */
	public $gravity = 0.04;
	/** @var float */
	public $drag = 0.98;
	/** @var bool */
	private $onGround = false;

	/** @var float[] */
	private $origin = [];
	/** @var float[] */
	private $size = [];
	/** @var float[] */
	private $uv = [];
	/** @var float[] */
	private $velocity = [];

	/** @var float */
	private $inflate = 0.0;
	/** @var bool */
	private $mirror = false;

	public function __construct(array $cubeData = []) {
		$this->origin = $cubeData["origin"] ?? [0.0, 0.0, 0.0];
		$this->size = $cubeData["size"] ?? [1.0, 1.0, 1.0];
		$this->uv = $cubeData["uv"] ?? [0.0, 0.0];
		$this->velocity = $cubeData["velocity"] ?? [0.0, 0.0, 0.0];

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
			"mirror" => $this->mirror,
			"velocity" => $this->velocity
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
	 *
	 * @return Cube
	 */
	public function setOrigin(array $origin): self {
		$this->origin = $origin;

		return $this;
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
	 *
	 * @return Cube
	 */
	public function setSize(array $size): self {
		$this->size = $size;

		return $this;
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
	 *
	 * @return Cube
	 */
	public function setUv(array $uv): self {
		$this->uv = $uv;

		return $this;
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
	 *
	 * @return Cube
	 */
	public function setInflate(float $inflate): self {
		$this->inflate = $inflate;

		return $this;
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
	 *
	 * @return Cube
	 */
	public function setMirrored(bool $value = true): self {
		$this->mirror = $value;

		return $this;
	}

	/**
	 * Sets the velocity of this cube. Velocity does nothing on its own.
	 * This is simply a method to store plugin edited velocity in the cube.
	 * Should be an array with 3 floats.
	 *
	 * @param float[] $velocity
	 *
	 * @return Cube
	 */
	public function setVelocity(array $velocity): self {
		$this->velocity = $velocity;

		return $this;
	}

	/**
	 * Returns the velocity of this cube.
	 * Returns an array with 3 floats.
	 *
	 * @return float[]
	 */
	public function getVelocity(): array {
		return $this->velocity;
	}

	public function applyGravity(): void {
		$this->velocity[1] -= $this->gravity;
		$this->origin[1] += $this->velocity[1] / 10;
	}

	/**
	 * Attempts to move this cube.
	 *
	 * @return bool
	 */
	public function tryChangeMovement(): bool {
		if($this->onGround) {
			return false;
		}
		if($this->origin[1] <= 0.01) {
			$this->onGround = true;
			return false;
		}
		$this->velocity[0] *= $this->drag;
		$this->velocity[2] *= $this->drag;

		$this->origin[0] += $this->velocity[0] / 10;
		$this->origin[2] += $this->velocity[2] / 10;
		$this->applyGravity();
		return true;
	}
}