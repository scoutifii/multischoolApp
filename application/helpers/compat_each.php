<?php
/**
 * Polyfill for removed each() function in PHP 8+.
 * This provides minimal backward-compatible behavior so legacy code using
 * list(...) = each($array) or $pair = each($array) continues to work.
 */

if (!function_exists('each')) {
    function each(&$array)
    {
        if (!is_array($array) && !($array instanceof Traversable)) {
            return false;
        }

        // Advance internal pointer if necessary and fetch current key/value
        $key = key($array);
        if ($key === null) {
            return false;
        }

        $value = current($array);
        // move pointer forward for next call
        next($array);

        // Emulate the old each() return structure
        return [
            'key' => $key,
            0 => $key,
            'value' => $value,
            1 => $value,
        ];
    }
}
