<?php
function http_reponse_success():void
{
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}
function http_reponse_error($error):void
{
    header('Content-Type: application/json');
    echo json_encode(['error' => $error]);
}
function http_response_result($result):void
{
    header('Content-Type: application/json');
    echo json_encode(['result' => $result]);
}
function http_reponse_success_warning($message):void
{
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'warning' => $message]);
}