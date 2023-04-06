<?php

declare(strict_types=1);

function class_parse_array($raw):array {
    return json_decode(json_encode($raw), true);
}