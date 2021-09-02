<?php

namespace Proycer\LogBook\Parser;

use DateTime;
use Exception;
use RuntimeException;

class LineLogParser implements LogParserInterface
{
    /**
     * @var array
     */
    protected $pattern = array(
        'default' => '/\[(?P<date>.*)\] (?P<logger>[\w-]+).(?P<level>\w+): (?P<message>[^\[\{]+) (?P<context>[\[\{].*[\]\}]) (?P<extra>[\[\{].*[\]\}])/',
        'error'   => '/\[(?P<date>.*)\] (?P<logger>[\w-]+).(?P<level>\w+): (?P<message>(.*)+) (?P<context>[^ ]+) (?P<extra>[^ ]+)/'
    );


    /**
     * @param string $log
     * @param int    $days
     * @param string $pattern
     *
	 * @param string $dateFormat
     * @return array
	 * @throws Exception
     */
    public function parse($log, $dateFormat, $days = 1, $pattern = 'default'): array
    {
        if (!is_string($log) || $log === '') {
            return array();
        }

        preg_match($this->pattern[$pattern], $log, $data);

        if (!isset($data['date'])) {
            return array();
        }

        $date = DateTime::createFromFormat($dateFormat, $data['date']);

        $array = array(
            'date'    => $date,
            'logger'  => $data['logger'],
            'level'   => $data['level'],
            'message' => $data['message'],
            'context' => json_decode($data['context'], true, 512, JSON_THROW_ON_ERROR),
            'extra'   => json_decode($data['extra'], true, 512, JSON_THROW_ON_ERROR)
        );

        if (0 === $days) {
            return $array;
        }

        if (isset($date) && $date instanceof DateTime) {
            $d2 = new DateTime('now');

            if ($date->diff($d2)->days < $days) {
                return $array;
            }

	        return [];
        }
        return [];
    }

    /**
     * @param string $name
     * @param string $pattern
     *
     * @throws RuntimeException
     */
    public function registerPattern(string $name, string $pattern): void
    {
        if (!isset($this->pattern[$name])) {
            $this->pattern[$name] = $pattern;
        } else {
            throw new RuntimeException("Pattern $name already exists");
        }
    }
}
