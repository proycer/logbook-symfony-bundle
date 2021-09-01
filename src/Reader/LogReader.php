<?php

namespace Proycer\LogBook\Reader;

use ArrayAccess;
use Countable;
use Proycer\LogBook\Parser\LineLogParser;
use Proycer\LogBook\Parser\LogParserInterface;
use Exception;
use Iterator;
use RuntimeException;
use SplFileObject;

class LogReader extends AbstractReader implements Iterator, ArrayAccess, Countable
{
    /** @var SplFileObject */
    protected $file;

    /** @var int */
    protected $lineCount;

    /** @var LineLogParser */
    protected $parser;

    public $days;

    public $pattern;

	public $dateFormat;

    /**
     * @param        $file
     * @param int $days
     * @param string $pattern
	 * @param $dateFormat
     */
    public function __construct($file, $dateFormat, int $days = 1, string $pattern = 'default')
    {
        $this->file = new SplFileObject($file, 'r');
        $i          = 0;

        while (!$this->file->eof()) {
            $this->file->current();
            $this->file->next();
            $i++;
        }

        $this->days = $days;
        $this->pattern = $pattern;
		$this->dateFormat = $dateFormat;

        $this->lineCount = $i;
        $this->parser    = $this->getDefaultParser();
    }

    /**
     * @return LineLogParser|LogParserInterface
     */
    public function getParser()
    {
        $p =  & $this->parser;
        return $p;
    }

    /**
     * @param string $pattern
     */
    public function setPattern(string $pattern = 'default' ): void
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->lineCount < $offset;
    }

    /**
     * {@inheritdoc}
	 * @throws Exception
     */
    public function offsetGet($offset)
    {
        $key = $this->file->key();
        $this->file->seek($offset);
        $log = $this->current();
        $this->file->seek($key);
        $this->file->current();

        return $log;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException("LogReader is read-only.");
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        throw new RuntimeException("LogReader is read-only.");
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->file->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->file->next();
    }

    /**
     * {@inheritdoc}
	 * @throws Exception
     */
    public function current()
    {
        return $this->parser->parse($this->file->current(), $this->dateFormat, $this->days, $this->pattern);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->file->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return $this->file->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->lineCount;
    }
}
