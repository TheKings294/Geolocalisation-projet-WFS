<?php
function http_reponse_success()
{
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}
function http_reponse_error($error)
{
    header('Content-Type: application/json');
    echo json_encode(['error' => $error]);
}
function http_response_result($result)
{
    header('Content-Type: application/json');
    echo json_encode(['result' => $result]);
}