<?php

namespace Laravue\Utility\Crawler\Fixtures;

class Fixture
{
    /**
     * The data set.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Return the data set.
     *
     * @return array
     */
    public static function getAll(): array
    {
        return (new static())->data;
    }
}
