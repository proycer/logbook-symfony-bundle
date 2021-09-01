<?php

namespace Proycer\LogBook\Reader;

use Proycer\LogBook\Parser\LineLogParser;

class AbstractReader
{
	/**
	 * @return LineLogParser
	 */
    protected function getDefaultParser(): LineLogParser
    {
	    return new LineLogParser();
    }
}
