<?php

declare(strict_types=1);

/**
 * Dump given variables and exit the application.
 */
function dd(): never
{
    foreach (func_get_args() as $arg) {
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }

    exit;
}
