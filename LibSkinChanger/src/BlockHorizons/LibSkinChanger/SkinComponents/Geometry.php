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
			"parent" => $this->parent,
			"neverRender" => $this->noRender
		];
	}

	/**
	 * Returns an array containing the pivot (rotation point) of this component.
	 * Returns array with 3 floats.
	 *
	 * @return float[]
	 */
	public function getPivot(): array {
		return $this->pivot;
	}

	/**
	 * Sets the pivot (rotation point) of this component.
	 * Should be an array containing 3 floats.
	 *
	 * @param float[] $pivot
	 *
	 * @return Geometry
	 */
	public function setPivot(array $pivot): self {
		$this->pivot = $pivot;

		return $this;
	}

	/**
	 * Returns the rotation of this component.
	 * Returns array with 3 floats.
	 *
	 * @return float[]
	 */
	public function getRotation(): array {
		return $this->rotation;
	}

	/**
	 * Sets the rotation of this component.
	 * Should be an array containing 3 floats.
	 *
	 * @param float[] $rotation
	 *
	 * @return Geometry
	 */
	public function setRotation(array $rotation): self {
		$this->rotation = $rotation;

		return $this;
	}

	/**
	 * Returns all cubes (Cube.php) of this component.
	 *
	 * @return Cube[]
	 */
	public function getCubes(): array {
		return $this->cubes;
	}

	/**
	 * Adds a cube to this component.
	 * See Cube.php
	 *
	 * @param Cube $cube
	 *
	 * @return Geometry
	 */
	public function addCube(Cube $cube): self {
		$this->cubes[] = $cube;

		return $this;
	}

	/**
	 * Deletes a cube with the given ID.
	 *
	 * @param int $key
	 */
	public function deleteCube(int $key): void {
		unset($this->cubes[$key]);
	}

	/**
	 * Deletes all cubes of this component.
	 */
	public function deleteAllCubes(): void {
		$this->cubes = [];
	}

	/**
	 * Returns the name of this geometry component.
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Returns the meta bone type of this geometry component.
	 *
	 * @return string
	 */
	public function getMetaBoneType(): string {
		return $this->metaBoneType;
	}

	/**
	 * Returns the parent of this geometry component.
	 *
	 * @return string
	 */
	public function getParent(): string {
		return $this->parent;
	}

	/**
	 * Returns all cubes in an array form instead of Cube instances.
	 *
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
	 * Returns whether this geometry component should render (be visible) to the client.
	 *
	 * @return bool
	 */
	public function shouldRender(): bool {
		return !$this->noRender;
	}

	/**
	 * Sets this geometry component to (not) render this component.
	 *
	 * @param bool $value
	 *
	 * @return Geometry
	 */
	public function setNoRender(bool $value = true): self {
		$this->noRender = $value;

		return $this;
	}

	/**
	 * Returns a cube with the given index.
	 *
	 * @param int $index
	 *
	 * @return Cube|null
	 */
	public function getCube(int $index): ?Cube {
		return $this->cubes[$index] ?? null;
	}

	/**
	 * Explodes (subdivides) the body part into small cubes.
	 * This function does not add velocity to the cubes.
	 *
	 * @return Geometry
	 */
	public function explodeCubes(): self {
		$cubes = [];
		foreach($this->cubes as $cube) {
			$origin = $cube->getOrigin();
			$sizes = $cube->getSize();
			for($x = 0; $x < $sizes[0]; $x++) {
				for($y = 0; $y < $sizes[1]; $y++) {
					for($z = 0; $z < $sizes[2]; $z++) {
						if($x !== 0 && $y !== 0 && $z !== 0 && $x !== $sizes[0] - 1 && $y !== $sizes[1] - 1 && $z !== $sizes[2] - 1) {
							continue;
						}
						$cubes[] = (new Cube())->setOrigin([$x + $origin[0], $y + $origin[1], $z + $origin[2]])->setUv([$cube->getUv()[0] + $x, $cube->getUv()[1] + $y]);
					}
				}
			}
		}
		$this->deleteAllCubes();
		foreach($cubes as $cube) {
			$this->cubes[] = $cube;
		}
		return $this;
	}

	/**
	 * Attempts to change the movement of all cubes.
	 */
	public function tryChangeMovement(): bool {
		$return = false;
		foreach($this->cubes as $key => $cube) {
			if(random_int(0, 500) === 1) {
				$this->deleteCube($key);
				continue;
			}
			if($cube->tryChangeMovement()) {
				$return = true;
			}
		}
		return $return;
	}
}
