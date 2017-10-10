<?php

declare(strict_types = 1);

namespace BlockHorizons\LibSkinChanger;

class SkinPixel {

	/** @var int */
	private $a = 0;
	/** @var int */
	private $r = 0;
	/** @var int */
	private $g = 0;
	/** @var int */
	private $b = 0;

	public function __construct(int $r, int $g, int $b, int $a = 0xff) {
		$this->r = $r & 0xff;
		$this->g = $g & 0xff;
		$this->b = $b & 0xff;
		$this->a = $a & 0xff;
	}

	/**
	 * Returns the alpha (opacity) value of this pixel.
	 *
	 * @return int
	 */
	public function getAlpha(): int {
		return $this->a;
	}

	/**
	 * Sets the alpha (opacity) value of this colour, lower = more transparent.
	 *
	 * @param int $a
	 */
	public function setAlpha(int $a): void {
		$this->a = $a & 0xff;
	}

	/**
	 * Returns the red value of this colour.
	 *
	 * @return int
	 */
	public function getR(): int {
		return $this->r;
	}

	/**
	 * Sets the red value of this colour.
	 * @param int $r
	 */
	public function setR(int $r): void {
		$this->r = $r & 0xff;
	}

	/**
	 * Returns the green value of this pixel.
	 *
	 * @return int
	 */
	public function getG(): int {
		return $this->g;
	}

	/**
	 * Sets the green value of this pixel.
	 *
	 * @param int $g
	 */
	public function setG(int $g): void {
		$this->g = $g & 0xff;
	}

	/**
	 * Returns the blue value of this pixel.
	 *
	 * @return int
	 */
	public function getB(): int{
		return $this->b;
	}

	/**
	 * Sets the blue value of this pixel.
	 *
	 * @param int $b
	 */
	public function setB(int $b): void {
		$this->b = $b & 0xff;
	}

	/**
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 */
	public function setRGB(int $r, int $g, int $b): void {
		$this->setR($r);
		$this->setG($g);
		$this->setB($b);
	}
}