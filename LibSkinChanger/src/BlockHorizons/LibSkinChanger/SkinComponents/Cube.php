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
	 * @return float[]
	 */
	public function getOrigin(): array {
		return $this->origin;
	}

	/**
	 * @param float[] $origin
	 */
	public function setOrigin(array $origin): void {
		$this->origin = $origin;
	}

	/**
	 * @return float[]
	 */
	public function getSize(): array {
		return $this->size;
	}

	/**
	 * @param float[] $size
	 */
	public function setSize(array $size): void {
		$this->size = $size;
	}

	/**
	 * @return float[]
	 */
	public function getUv(): array {
		return $this->uv;
	}

	/**
	 * @param float[] $uv
	 */
	public function setUv(array $uv): void {
		$this->uv = $uv;
	}

	/**
	 * @return float
	 */
	public function getInflate(): float {
		return $this->inflate;
	}

	/**
	 * @param float $inflate
	 */
	public function setInflate(float $inflate): void {
		$this->inflate = $inflate;
	}

	/**
	 * @return bool
	 */
	public function isMirrored(): bool {
		return $this->mirror;
	}

	/**
	 * @param bool $value
	 */
	public function setMirrored(bool $value = true): void {
		$this->mirror = $value;
	}
}