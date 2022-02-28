<?php

namespace App\Data;

use DateTime;

class SearchData
{
	/**
	 * @var null|DateTime
	 */
	public ?DateTime $startShowingDate = null;

	/**
	 * @var null|DateTime
	 */
	public ?DateTime $endShowingDate = null;

	/**
	 * @var null|int
	 */
	public int $minPrice;

	/**
	 * @var null|int
	 */
	public int $maxPrice;

	/**
	 * @var int
	 */
	public int $page = 1;
}
