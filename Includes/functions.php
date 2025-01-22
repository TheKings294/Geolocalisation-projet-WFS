<?php
function cleanCodeString(string $string): string
{
    return trim(htmlspecialchars($string, ENT_QUOTES));
}

function deletFile(string $file): bool
{
    if(file_exists($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIRECTORY . $file)) {
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