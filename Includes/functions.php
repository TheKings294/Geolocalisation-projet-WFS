<?php
require 'vendor/autoload.php';

use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;

function cleanCodeString(string $string): string
{
    return trim(htmlspecialchars($string, ENT_QUOTES));
}
function deletFile(string $file): bool
{
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $file)) {
        try {
            unlink($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $file);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    return false;
}
function mooveFile(string $tmpFile, string $file): bool
{
    try {
        move_uploaded_file($tmpFile, $_SERVER['DOCUMENT_ROOT']. UPLOAD_DIRECTORY . $file);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
function convertOrdoToLat($value1, $value2): array
{
    $proj4 = new Proj4php();

    $sourceProj = new Proj('EPSG:2154', $proj4);

    $targetProj = new Proj('EPSG:4326', $proj4);

    $pointSource = new Point($value1, $value2, $sourceProj);

    $pointTarget = $proj4->transform($sourceProj, $targetProj, $pointSource);
    return [$pointTarget->y, $pointTarget->x];
}