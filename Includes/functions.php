<?php
function cleanCodeString(string $string): string
{
    return trim(htmlspecialchars($string, ENT_QUOTES));
}