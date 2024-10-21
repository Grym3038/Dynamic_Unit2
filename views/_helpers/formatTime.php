<?php
function formatTime(int $seconds) : string
{
    $hours = intdiv($seconds, 60 * 60);
    $seconds -= $hours * 60 * 60;
    $minutes = intdiv($seconds, 60);
    $seconds -= $minutes * 60;

    $hours_f = str_pad($hours, 2, '0', STR_PAD_LEFT);
    $minutes_f = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    $seconds_f = str_pad($seconds, 2, '0', STR_PAD_LEFT);

    return $hours_f . ':' . $minutes_f . ':' . $seconds_f;
}
?>
