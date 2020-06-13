<?php

namespace Lionix\LaravelPostmanRoutes\Contracts\Entities;

use stdClass;

interface CanBeMadeFromStdClassInterface
{
    public static function fromStdClass(stdClass $stdClass);
}
