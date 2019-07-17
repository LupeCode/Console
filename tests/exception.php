<?php

/**
 * @param mixed ...$args
 *
 * @throws \Exception
 */
function throwException(...$args)
{
    throw new \Exception('Call to undefined country; long distance rates apply.');
}
