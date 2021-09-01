<?php

namespace Proycer\LogBook\Parser;

interface LogParserInterface
{
	/**
	 * @param $log
	 * @param $days
	 * @param $pattern
	 *
	 * @param $dateFormat
	 * @return mixed
	 */
    public function parse($log, $dateFormat, $days, $pattern);
}
