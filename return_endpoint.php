<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    file_put_contents('return_log.txt', print_r($input, true), FILE_APPEND);
    echo json_encode(['status' => 'Retorno recebido']);
}
