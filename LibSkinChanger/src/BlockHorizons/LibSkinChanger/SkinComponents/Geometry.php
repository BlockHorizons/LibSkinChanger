<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger\SkinComponents;

class Geometry implements \JsonSerializable {

	/** @var float[] */
	private $pivot = [];
	/** @var float[] */
	private $rotation = [];
	/** @var Cube[] */
	private $cubes = [];
	/** @var string */
	private $name = "";
	/** @var string */
	private $metaBoneType = "";
	/** @var string */
	private $parent = "";
	/** @var bool */
	private $noRender = false;

	public function __construct(array $data) {
		$default = [0.0, 0.0, 0.0];
		$this->pivot = $data["pivot"] ?? $default;
		$this->rotation = $data["rotation"] ?? $default;
		foreach($data["cubes"] as $cube) {
			$this->cubes[] = new Cube($cube);
		}
		$this->name = $data["name"];
		$this->parent = $data["parent"] ?? "";
		$this->metaBoneType = $data["META_BoneType"] ?? "base";
		$this->noRender = $data["noRender"] ?? false;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"pivot" => $this->pivot,
			"rotation" => $this->rotation,
			"cubes" => $this->getCubeArray(),
			"name" => $this->name,
			"META_BoneType" => $this->metaBoneType,
			"parent" => $this->parent
		];
	}

	/**
	 * @return float[]
	 */
	public function getPivot(): array {
		return $this->pivot;
	}

	/**
	 * @param float[] $pivot
	 *
	 * @return Geometry
	 */
	public function setPivot(array $pivot): self {
		$this->pivot = $pivot;

		return $this;
	}

	/**
	 * @return float[]
	 */
	public function getRotation(): array {
		return $this->rotation;
	}

	/**
	 * @param float[] $rotation
	 *
	 * @return Geometry
	 */
	public function setRotation(array $rotation): self {
		$this->rotation = $rotation;

		return $this;
	}

	/**
	 * @return Cube[]
	 */
	public function getCubes(): array {
		return $this->cubes;
	}

	/**
	 * @param Cube $cube
	 *
	 * @return Geometry
	 */
	public function addCube(Cube $cube): self {
		$this->cubes[] = $cube;

		return $this;
	}

	/**
	 * @param int $key
	 */
	public function deleteCube(int $key): void {
		unset($this->cubes[$key]);
	}

	public function deleteAllCubes(): void {
		foreach($this->cubes as $key => $cube) {
			unset($this->cubes[$key]);
		}
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getMetaBoneType(): string {
		return $this->metaBoneType;
	}

	/**
	 * @return string
	 */
	public function getParent(): string {
		return $this->parent;
	}

	/**
	 * @return array
	 */
	public function getCubeArray(): array {
		$cubes = [];
		foreach($this->cubes as $cube) {
			$cubes[] = $cube->jsonSerialize();
		}
		return $cubes;
	}

	/**
	 * @return bool
	 */
	public function shouldRender(): bool {
		return !$this->noRender;
	}

	/**
	 * @param bool $value
	 *
	 * @return Geometry
	 */
	public function setNoRender(bool $value = true): self {
		$this->noRender = $value;

		return $this;
	}
}