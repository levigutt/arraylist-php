<?php

function l(...$args)
{
    return new ArrayList(...$args);
}

function r(...$args)
{
    return new ArrayList(...range(...$args));
}
